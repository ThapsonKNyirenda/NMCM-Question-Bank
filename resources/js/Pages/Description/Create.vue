<template>
    <Head title="Add Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question Description</h2>
                <div class="text-base fw-semibold text-muted">Add a question Description</div>
            </div>
        </template>
        <form method="POST" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'add the question Description?')">
  
            <div class="mb-4">
                <label for="cadre" class="form-label">Select a Cadre</label>
                <select v-model="form.cadre" id="cadre" name="cadre" class="form-select" required>
                    <option disabled value="">Choose a cadre</option>
                    <option v-for="(value, key) in Cadre" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nurseProcess" class="form-label">Select a Nursing Process</label>
                <select v-model="form.nursing_process" id="nurseProcess" name="nursing_process" class="form-select" required>
                    <option disabled value="">Choose a Nursing Process</option>
                    <option v-for="(value, key) in nurseProcess" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="diseaseArea" class="form-label">Select a Disease Area</label>
                <select v-model="form.disease_area" id="diseaseArea" name="disease_area" class="form-select" required>
                    <option disabled value="">Choose a Disease Area</option>
                    <option v-for="(value, key) in diseaseArea" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="taxonomy" class="form-label">Select Taxonomy Level</label>
                <select v-model="form.taxonomy" id="taxonomy" name="taxonomy" class="form-select" required>
                    <option disabled value="">Choose taxonomy</option>
                    <option v-for="(value, key) in taxonomy" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="syllabus" class="form-label">Select a Syllabus</label>
                <select v-model="form.syllabus" id="syllabus" name="syllabus" class="form-select" required>
                    <option disabled value="">Choose a Syllabus</option>
                    <option v-for="(value, key) in Syllabus" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <base-form-input type="text" label="Question Title" id="title" name="title" v-model="form.title" required />

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

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'Add Question';
store.setBreadCrumb({ Questions: route('questions.index'), 'Add question': null });

const form = useForm({
    cadre: null,
    nursing_process: null,
    disease_area: null,
    taxonomy: null,
    syllabus: null,
    question_description: null
});

const Cadre = {
    "Registered Nurse": "Registered Nurse",
    "Licensed Practical Nurse": "Licensed Practical Nurse",
    "Nurse Practitioner": "Nurse Practitioner"
}

const nurseProcess = {
    Assessment: "Assessment",
    Diagnosis: "Diagnosis",
    Planning: "Planning",
    Implementation: "Implementation",
    Evaluation: "Evaluation"
}

const taxonomy = {
    Knowledge: "Knowledge",
    Comprehension: "Comprehension",
    Application: "Application",
    Analysis: "Analysis",
    Synthesis: "Synthesis",
    Evaluation: "Evaluation"
}

const diseaseArea = {
    Cardiology: "Cardiology",
    Neurology: "Neurology",
    Oncology: "Oncology",
    Pediatrics: "Pediatrics",
    Orthopedics: "Orthopedics"
}

const Syllabus = {
    "2022-2023": "2022-2023",
    "2023-2024": "2023-2024",
}


const inertiaSubmit = () => {
    console.log(JSON.stringify(form, null, 2));
    form.post(route('questions.store'));
};
</script>

<style scoped>
.form-select {
    display: block;
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>
