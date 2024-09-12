<template>
    <Head title="Sections List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search 
                        placeholder="Search..."
                        :search="filters.search"
                        class="w-full"
                    />
                </div>
            </div>
            <div class="flex space-x-4 card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('sections.create')"> 
                    New Section 
                </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">#</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Paper Code</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Cadre</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Disease Area</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Section Label</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Date Created</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Last Update</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(section, index) in sections.data" :key="section.id" class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3" v-text="index + 1"></td>
                            <td class="px-4 py-3">{{ section.paper_code }}</td>
                            <td class="px-4 py-3">{{ section.cadre ? section.cadre.name : 'N/A' }}</td>
                            <td class="px-4 py-3">{{ section.disease_area ? section.disease_area.name : 'N/A' }}</td>
                            <td class="px-4 py-3">{{ section.section_label }}</td>
                            <td class="px-4 py-3">{{ new Date(section.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}</td>
                            <td class="px-4 py-3">{{ new Date(section.updated_at).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}</td>
                            <td class="flex px-4 py-3 space-x-4">
                                <button @click="editSection(section.id)" class="flex items-center text-green-500 hover:text-green-700">
                                    <i class="mr-2 text-xl fas fa-edit"></i>
                                </button>
                                <button @click="confirmDelete(section.id)" class="flex items-center text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-5 gap-4 mt-4">
                <div class="flex items-center justify-center md:justify-start">
                    <base-select-page v-model="filterBy.per_page" />
                </div>
                <div class="flex items-center justify-center col-span-4 md:justify-end">
                    <base-pagination :paginator="sections" :key="sections.total" />
                </div>
            </div>

            <!-- New Form for Selecting Paper Code -->
            <div class="p-6 mt-8 bg-white border rounded-lg shadow-md">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Generate Question Paper</h3>
                <form @submit.prevent="generatePaper">
                    <div class="mb-4">
                        <label for="paper_code" class="block mb-2 text-sm font-medium text-gray-700">Select Paper Code</label>
                    <select id="paper_code" v-model="selectedPaperCode" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="" disabled>Select Paper Code</option>
                        <option v-for="(code, index) in uniquePaperCodes" :key="index" :value="code">
                            {{ code }}
                        </option>
                    </select>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Generate Paper
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { store } from "@/store.js";
import { reactive, ref, watch, computed } from "vue";
import axios from 'axios';
import { onMounted } from 'vue';
import Swal from 'sweetalert2';
import '@fortawesome/fontawesome-free/css/all.css';

defineOptions({ layout: AuthenticatedLayout });

const successMessage = ref(route().params.successMessage || '');

watch(() => route().params.successMessage, (newValue) => {
    if (newValue) {
        successMessage.value = newValue;
        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
    }
});

onMounted(() => {
    if (successMessage.value) {
        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
    }
});

const props = defineProps({
    sections: Object, // Using sections from props
    filters: Object
});

// Data for the new form
const selectedPaperCode = ref('');

store.pageTitle = 'Sections List';

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

// Watch for per_page changes
watch(() => filterBy.per_page, (newVal) => {
    router.get(route('sections.index', { search: props.filters.search, ...filterBy }));
});

// Method to edit a section
const editSection = (sectionId) => {
    router.get(route('sections.edit', sectionId));
};

// Extract unique paper codes
const uniquePaperCodes = computed(() => {
    if (props.sections && props.sections.data) {
        const codes = props.sections.data.map(section => section.paper_code);
        return [...new Set(codes)]; // Return only unique paper codes
    }
    return []; // Return an empty array if sections or data is not available
});

// Method to confirm deletion
const confirmDelete = (sectionId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won’t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            deleteSection(sectionId);
        }
    });
};

// Method to delete a section
const deleteSection = async (sectionId) => {
    try {
        await axios.delete(route('sections.destroy', sectionId));
        router.get(route('sections.index'), {
            preserveScroll: true,
            successMessage: 'Section deleted successfully',
        });
    } catch (error) {
        console.error('Error:', error);
    }
};

// Dummy method for generating question paper (button functionality not yet implemented)
const generatePaper = () => {
    console.log("Generate Question Paper for Paper Code:", selectedPaperCode.value);
};
</script>

