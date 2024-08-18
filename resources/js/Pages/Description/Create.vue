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
                <select v-model="form.cadre" id="cadre" name="cadre" class="form-select" required>
                    <option disabled value="">Choose a cadre</option>
                    <option v-for="(value, key) in cadres" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nurseProcess" class="form-label">Select a Nursing Process</label>
                <select v-model="form.nursing_process" id="nurseProcess" name="nursing_process" class="form-select" required>
                    <option disabled value="">Choose a Nursing Process</option>
                    <option v-for="(value, key) in nursingProcesses" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="diseaseArea" class="form-label">Select a Disease Area</label>
                <select v-model="form.disease_area" id="diseaseArea" name="disease_area" class="form-select" required>
                    <option disabled value="">Choose a Disease Area</option>
                    <option v-for="(value, key) in diseaseAreas" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="taxonomy" class="form-label">Select Taxonomy Level</label>
                <select v-model="form.taxonomy" id="taxonomy" name="taxonomy" class="form-select" required>
                    <option disabled value="">Choose taxonomy</option>
                    <option v-for="(value, key) in taxonomyLevels" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="syllabus" class="form-label">Select a Syllabus</label>
                <select v-model="form.syllabus" id="syllabus" name="syllabus" class="form-select" required>
                    <option disabled value="">Choose a Syllabus</option>
                    <option v-for="(value, key) in syllabusOptions" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <label class="form-label required">Question Description</label>
            <div class="mandatory-fields">
                <quill-input v-model="form.question_description" :placeholder="placeholders" />
            </div>

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Save</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { submit } from "@/helpers/form_helpers.js";
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue"

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });
const form = useForm({
    cadre: null,
    nursing_process: null,
    disease_area: null,
    taxonomy: null,
    syllabus: null,
    question_description: null
});

// Hardcoded syllabus options
const syllabusOptions = {
    "2022-2023": "2022-2023",
    "2023-2024": "2023-2024",
};

// Destructure props to get dropdown options from the backend
const props = defineProps(['cadres', 'nursingProcesses', 'diseaseAreas', 'taxonomyLevels']);

// Form submission method
const inertiaSubmit = () => {
    // Submit the form
    form.post(route('descriptions.store'));
};
</script>
