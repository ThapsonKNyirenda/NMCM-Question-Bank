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

            <base-form-select label="Select a Cadre" v-model="form.cadre" id="cadre" name="cadre" :options="Cadre" required />

            <base-form-select label="Select a Nursing Process" v-model="form.nursing_process" id="nurseProcess"
                name="nursing_process" placeholders="Choose a Nursing Process" :options="nurseProcess" required />

                <base-form-select label="Select a Disease Area" v-model="form.disease_area" id="diseaseArea"
                name="disease_area" placeholders="Choose a Disease Area" :options="diseaseArea" required />

            <base-form-select label="Select Taxonomy Level" v-model="form.taxonomy" id="taxonomy"
                name="taxonomy"
                placeholders="Choose taxonomy" :options="taxonomy" required/>

            <base-form-select label="Select a Syllabus" v-model="form.syllabus" id="syllabus" name="syllabus"
                placeholders="Choose a Syllabus" :options="Syllabus" required />

            <base-form-input label="Number of Questions" v-model="form.number_of_questions" id="number_of_questions" name="number_of_questions" type="number" required />

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