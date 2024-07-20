<template>

    
    <Head title="Edit Blueprint" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Blueprint</h2>
                <div class="text-base fw-semibold text-muted">Edit a question paper Blueprint</div>
            </div>
        </template>
        <form method="POST" :action="route('questionblueprints.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'Edit the question blueprint?')">

            <base-form-input
            label="Year"
            v-model="currentYear"
            id="year"
            name="year"
            disabled
            />

            <div class="mb-4">
                <label for="month" class="form-label">Select Month</label>
                <select v-model="form.month" id="month" name="month" class="form-select" required>
                    <option disabled value="">Choose a month</option>
                    <option v-for="(value, key) in months" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

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
            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Save</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { submit } from "@/helpers/form_helpers.js";
import { useForm, Head } from "@inertiajs/vue3";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    blueprint: Object
});

console.log(JSON.stringify(props.blueprint));

store.pageTitle = 'Edit Question Blueprint';
store.setBreadCrumb({ Blueprints: route('questionblueprints.index'), 'Edit Blueprint': null });

const form = useForm(
    props.blueprint,
);

const currentYear = new Date().getFullYear();
form.year=currentYear;

const months = {
    'January': 'January',
    'February': 'February',
    'March': 'March',
    'April': 'April',
    'May': 'May',
    'June': 'June',
    'July': 'July',
    'August': 'August',
    'September': 'September',
    'October': 'October',
    'November': 'November',
    'December': 'December'
};

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



// const inertiaSubmit = () => {
//     console.log(JSON.stringify(form, null, 2));
//     form.post(route('questions.store'));
// };

const inertiaSubmit = () => {
  form.patch(route('questionblueprints.update', props.blueprint.uuid));
};


</script>