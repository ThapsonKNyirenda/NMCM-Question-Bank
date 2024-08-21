<template>
    <Head title="Add Question Scenario" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question Scenario</h2>
                <div class="text-base fw-semibold text-muted">Add a question Scenario</div>
            </div>
        </template>
        <form method="POST" :action="route('descriptions.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'add the question Scenario?')">

            <div class="mb-4">
                <label for="diseaseArea" class="form-label">Select a Disease Area</label>
                <select v-model="form.disease_area" id="diseaseArea" name="disease_area" class="form-select" :disabled="description_id" required>
                    <option disabled value="">Choose a Disease Area</option>
                    <option v-for="(value, key) in diseaseAreas" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <label class="form-label required">Question Scenario</label>
            <div class="mandatory-fields">
                <quill-input v-model="form.question_description" :placeholder="placeholders"/>
            </div>


            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing" :disabled="description_id">Save</base-button-submit>
        </form>
    </base-card-main>

    <!-- Questions Table -->
    <base-card-main class="mt-6 card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Questions for Selected Scenario</h2>
            </div>
        </template>

        <!-- Add Question Button -->
        <div class="card-toolbar">
        <!-- Button only visible if description_id is set -->
            <base-button-new
                v-if="description_id"
                class="btn-light-primary"
                :href="createQuestionUrl"
            >
                New Question
            </base-button-new>
        </div>

        <!-- Questions Table -->
        <div v-if="questions.length" class="mt-6">
            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-sm table-auto">
        <thead>
            <tr class="text-gray-600 bg-gray-100">
                <th class="px-4 py-2 border-b">Title</th>
                <th class="px-4 py-2 border-b">Choice A</th>
                <th class="px-4 py-2 border-b">Choice B</th>
                <th class="px-4 py-2 border-b">Choice C</th>
                <th class="px-4 py-2 border-b">Choice D</th>
                <th class="px-4 py-2 border-b">Correct Answer</th>
                <th class="px-4 py-2 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="question in questions" :key="question.id" class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.title)"></td>
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_a)"></td>
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_b)"></td>
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_c)"></td>
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_d)"></td>
                <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.correct_answer)"></td>
                <td class="px-4 py-2 border-b">
                    <!-- Add your action buttons here -->
                    <button class="text-blue-500 hover:text-blue-700">Edit</button>
                    <button class="ml-2 text-red-500 hover:text-red-700">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
        </div>
        <div v-else class="text-center text-muted">
            No questions added yet.
        </div>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { submit } from "@/helpers/form_helpers.js";
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Components/QuillInput.vue"
import { computed } from 'vue';

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'Question Scenario';
store.setBreadCrumb({ Scenarios: route('descriptions.index') });

const props = defineProps(['diseaseAreas', 'questions', 'description_id']);

// Initialize form with default values or fetched values
const form = useForm({
    disease_area: null,
    syllabus: null,
    question_description: null
});

const fetchDescriptionData = async (description_id) => {
    // Fetch data from the API
    const response = await fetch(`/api/descriptions/${description_id}`);
    const description = await response.json();
    
    // Log the fetched data to the console
    console.log("Fetched Description Data:", description);

    // Update the form fields with the fetched data
    form.cadre = description.cadre_id; // Assuming you need to map this to your form field
    form.nursing_process = description.nursing_process_id; // Assuming you need to map this to your form field
    form.disease_area = description.disease_area_id; // Assuming you need to map this to your form field
    form.taxonomy = description.taxonomy_level_id; // Assuming you need to map this to your form field
    form.syllabus = description.syllabus; // This matches the form field name
    form.question_description = description.description; // Updated to match your database column
    
};

if (props.description_id) {
    // Fetch data for the given description_id and populate the form fields
    fetchDescriptionData(props.description_id);
}

const stripHtmlTags = (html) => {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};

// Form submission method
const inertiaSubmit = () => {
    // Submit the form
    form.post(route('descriptions.store'));
};

const createQuestionUrl = computed(() => {
    if (props.description_id) {
        return route('questions.create', { description_id: props.description_id });
    }
    return '#'; // Return a fallback URL if description_id is not available
});

</script>
