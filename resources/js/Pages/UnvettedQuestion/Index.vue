<template>
    <Head title="Question Scenarios List" />
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
                <button @click="submitUnvetted" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Vet Selected
                </button>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-2">
                                <input type="checkbox" @change="toggleAllCheckboxes" v-model="selectAll">
                            </th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">#</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Disease Area</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Description</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Status</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Date Created</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Last Update</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(description, index) in descriptions.data" :key="description.id" class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <input type="checkbox" v-model="selectedRows" :value="description.id">
                            </td>
                            <td class="px-4 py-3" v-text="index + 1"></td>
                            <td class="px-4 py-3">{{ description.disease_area ? description.disease_area.name : 'N/A' }}</td>
                            <td class="px-4 py-3" v-text="truncateText(stripHtmlTags(description.description), 100)"></td>
                            <td class="px-4 py-3" v-text="stripHtmlTags(description.status)"></td>
                            <td class="px-4 py-3">{{ new Date(description.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}</td>
                            <td class="px-4 py-3">{{ new Date(description.updated_at).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}</td>
                            <td class="flex px-4 py-3 space-x-4">
                                <button @click="editDescription(description.id)" class="flex items-center text-green-500 hover:text-green-700">
                                    <i class="mr-2 text-xl fas fa-edit"></i>
                                </button>
                                <button @click="confirmDelete(description.id)" class="flex items-center text-red-500 hover:text-red-700">
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
                    <base-pagination :paginator="descriptions" :key="descriptions.total" />
                </div>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { store } from "@/store.js";
import { reactive, ref, watch } from "vue";
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
        }, 3000); // Adjust the time as needed
    }
});

onMounted(() => {
    if (successMessage.value) {
        setTimeout(() => {
            successMessage.value = '';
        }, 3000); // Adjust the time as needed
    }
});

const props = defineProps({
    descriptions: Object,
    filters: Object
});

// Method to strip HTML tags
const stripHtmlTags = (html) => {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};

// Method to truncate text
const truncateText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};

store.pageTitle = 'Question Scenarios List';
store.setBreadCrumb({ Scenarios: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });
const selectedRows = ref([]);
const selectAll = ref(false);

// Watch for per_page changes
watch(() => filterBy.per_page, (newVal) => {
    router.get(route('descriptions.index', { search: props.filters.search, ...filterBy }));
});

// Toggle all checkboxes
const toggleAllCheckboxes = () => {
    if (selectAll.value) {
        selectedRows.value = props.descriptions.data.map(description => description.id);
    } else {
        selectedRows.value = [];
    }
};

// Method to handle the submission and change status to "unvetted"
const submitUnvetted = async () => {
    try {
        const payload = { ids: selectedRows.value, status: 'unvetted' };
        const response = await axios.post(route('descriptions.update-status'), payload);
        // Navigate to the index page and pass the success message as a parameter
        router.get(route('descriptions.index'), {
            preserveScroll: true,
            successMessage: 'Successfully Submitted the questions',
        });
    } catch (error) {
        console.error('Error:', error); // Debugging log
        // alert('Failed to update status.');
    }
};

// Method to handle the confirmation and deletion of a description
const confirmDelete = (descriptionId) => {
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
            deleteDescription(descriptionId);
        }
    });
};

// Method to delete a description
const deleteDescription = async (descriptionId) => {
    try {
        await axios.delete(route('descriptions.destroy', descriptionId));
        // Reload the page or update the list of descriptions after successful deletion
        router.get(route('descriptions.index'), {
            preserveScroll: true,
            successMessage: 'Question scenario deleted successfully',
        });
    } catch (error) {
        console.error('Error:', error); // Debugging log
        // alert('Failed to delete description.');
    }
};

// Method to edit a description
const editDescription = (descriptionId) => {
    router.get(route('unvettedquestions.edit', descriptionId));
};
</script>
