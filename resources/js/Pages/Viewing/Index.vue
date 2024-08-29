<template>
    <Head title="View Question Scenario" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <!-- Top Close Button -->
        <button 
            @click="goBack" 
            class="absolute text-gray-500 top-2 right-2 hover:text-gray-700">
            <i class="fas fa-times"></i>
        </button>
        
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">View Question Scenario</h2>
                <div class="text-base fw-semibold text-muted">Scenario Details</div>
            </div>
        </template>
        
        <div class="relative w-3/4 mx-auto mt-6">
            <!-- Description -->
            <div class="mb-4">
                <h3 class="text-lg font-medium">Disease Area</h3>
                <p>{{ diseaseAreas[form.disease_area] || 'Not specified' }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-medium">Question Scenario</h3>
                <p v-html="form.question_description"></p>
            </div>

            <!-- Questions -->
            <div v-if="questions.length" class="mt-6">
                <div v-for="(question, index) in questions" :key="question.id" class="mb-6">
                    <h4 class="text-lg font-medium">Question {{ index + 1 }}</h4>
                    <p class="mb-4" v-text="stripHtmlTags(question.title)"></p>

                    <div class="ml-4">
                        <p>A) {{ stripHtmlTags(question.choice_a) }}</p>
                        <p>B) {{ stripHtmlTags(question.choice_b) }}</p>
                        <p>C) {{ stripHtmlTags(question.choice_c) }}</p>
                        <p>D) {{ stripHtmlTags(question.choice_d) }}</p>
                    </div>

                    <div class="flex gap-4 mt-2">
                        <button 
                            class="text-green-500 hover:text-blue-700"
                            @click="editQuestion(question.id, description_id)"
                        >
                            <i class="mr-2 text-xl fas fa-edit"></i> Edit
                        </button>
                        <button 
                            class="text-red-500 hover:text-red-700"
                            @click="confirmDelete(question.id)"
                        >
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="text-center text-muted">
                No questions added yet.
            </div>

            
        </div>
        <button @click="goBack" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Back
                </button>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { useForm, Head } from "@inertiajs/vue3";
import { computed } from 'vue';
import Swal from 'sweetalert2';

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'View Question Scenario';
store.setBreadCrumb({ Questions: route('questionbank.index') });

const props = defineProps(['diseaseAreas', 'questions', 'description_id', 'description']);

const form = useForm({
    disease_area: '',
    question_description: null
});

const fetchDescriptionData = async (description_id) => {
    const response = await fetch(`/api/descriptions/${description_id}`);
    const description = await response.json();

    form.disease_area = description.disease_area_id;
    form.question_description = description.description;
};

if (props.description_id) {
    fetchDescriptionData(props.description_id);
}

const stripHtmlTags = (html) => {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};

const createQuestionUrl = computed(() => {
    if (props.description_id) {
        return route('questions.create', {
            description_id: props.description_id,
            pageType: 'unvetEdi'
        });
    }
    return '#';
});

const editQuestion = (questionId, descriptionId) => {
    const editUrl = route('questions.edit', { id: questionId, description_id: descriptionId }) + `?pageType=unvetEdi`;
    window.location.href = editUrl;
};

const confirmDelete = (questionId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('questions.destroy', questionId));
        }
    });
};

// Function to navigate back
const goBack = () => {
    window.history.back();
};
</script>
