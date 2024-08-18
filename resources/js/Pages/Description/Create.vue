<template>
    <Head title="Add Question Description" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question Description</h2>
                <div class="text-base fw-semibold text-muted">Add a question Description</div>
            </div>
        </template>
        <form method="POST" :action="route('descriptions.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'add the question Description?')">

            <div class="mb-4">
                <label for="cadre" class="form-label">Select a Cadre</label>
                <select v-model="form.cadre" id="cadre" name="cadre" class="form-select" :disabled="description_id" required>
                    <option disabled value="">Choose a cadre</option>
                    <option v-for="(value, key) in cadres" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nurseProcess" class="form-label">Select a Nursing Process</label>
                <select v-model="form.nursing_process" id="nurseProcess" name="nursing_process" class="form-select" :disabled="description_id" required>
                    <option disabled value="">Choose a Nursing Process</option>
                    <option v-for="(value, key) in nursingProcesses" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="diseaseArea" class="form-label">Select a Disease Area</label>
                <select v-model="form.disease_area" id="diseaseArea" name="disease_area" class="form-select" :disabled="description_id" required>
                    <option disabled value="">Choose a Disease Area</option>
                    <option v-for="(value, key) in diseaseAreas" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="taxonomy" class="form-label">Select Taxonomy Level</label>
                <select v-model="form.taxonomy" id="taxonomy" name="taxonomy" class="form-select" :disabled="description_id" required>
                    <option disabled value="">Choose taxonomy</option>
                    <option v-for="(value, key) in taxonomyLevels" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="syllabus" class="form-label">Syllabus</label>
                <input v-model="form.syllabus" id="syllabus" name="syllabus" type="text" class="form-control" :disabled="description_id" required />
            </div>

            <label class="form-label required">Question Description</label>
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
                <h2 class="mb-1 text-xl font-semibold">Questions for Selected Description</h2>
            </div>
        </template>

        <!-- Add Question Button -->
        <div class="card-toolbar">
            <!-- Button only visible if descriptionId is set -->
            <base-button-new
                v-if="description_id"
                class="btn-light-primary"
                :href="route('questions.create')"
            >
                New Question
            </base-button-new>
        </div>

        <!-- Questions Table -->
        <div v-if="questions.length" class="mt-6">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Choice A</th>
                        <th>Choice B</th>
                        <th>Choice C</th>
                        <th>Choice D</th>
                        <th>Correct Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="question in questions" :key="question.id">
                        <td v-text="stripHtmlTags(question.title)"></td>
                        <td v-text="stripHtmlTags(question.choice_a)"></td>
                        <td v-text="stripHtmlTags(question.choice_b)"></td>
                        <td v-text="stripHtmlTags(question.choice_c)"></td>
                        <td v-text="stripHtmlTags(question.choice_d)"></td>
                        <td v-text="stripHtmlTags(question.correct_answer)"></td>
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

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

const props = defineProps(['cadres', 'nursingProcesses', 'diseaseAreas', 'taxonomyLevels', 'questions', 'description_id']);

// Initialize form with default values or fetched values
const form = useForm({
    cadre: null,
    nursing_process: null,
    disease_area: null,
    taxonomy: null,
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
</script>
