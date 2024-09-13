<template>
    <Head title="Sections List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <template #header>
            
            <div class="flex space-x-4 card-toolbar">
                <base-button-new class="btn-light-primary"> 
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
                    
                </table>
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
    sectionsData: Array,
    paper_code: String,
});

// Data for the new form
const selectedPaperCode = ref('');

store.pageTitle = 'Sections List';

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
const sectionsData = ref(null); // Store fetched data here
const isDataFetched = ref(false); // To toggle the View Paper button

// Function to fetch data when Generate Paper is clicked
const generatePaper = async () => {
  try {
    const response = await axios.get(`/api/sections/questions/${selectedPaperCode.value}`);
    sectionsData.value = response.data; // Store the fetched data
    isDataFetched.value = true; // Toggle to show View Paper button
  } catch (error) {
    console.error('Error fetching paper:', error);
  }
};

// Function to navigate to Paper.vue and pass the data
const viewPaper = () => {
  router.visit('/api/paper', {
    method: 'get', // This specifies the method (GET in this case)
    data: {
      sectionsData: sectionsData.value, // Pass the fetched sections data
      paper_code: selectedPaperCode.value, // Pass the selected paper code
    },
  });
};




</script>

