<template>

    <Head title="Add Question PAper Blueprint" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Blueprint</h2>
                <div class="text-base fw-semibold text-muted">Add a question paper blueprint</div>
            </div>
        </template>
        <form method="POST" :action="route('questionblueprints.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'add blueprint?')">
            
            <base-form-select label="Select a Cadre" v-model="form.cadre" id="cadre" name="cadre"
                placeholders="Choose a cadre" :options="Cadre" required />

            <base-form-select label="Select a Nursing Process" v-model="form.nursing_process" id="nurseProcess"
                name="nursing_process" placeholders="Choose a Nursing Process" :options="nurseProcess" required />

            <base-form-select label="Select a Disease Area" v-model="form.disease_area" id="diseaseArea"
                name="disease_area" placeholders="Choose a Disease Area" :options="diseaseArea" required />

            <base-form-select label="Select Taxonomy Level" v-model="form.taxonomy" id="taxonomy"
                name="taxonomy"
                placeholders="Choose taxonomy" :options="taxonomy" required/>

            <base-form-select label="Select a Syllabus" v-model="form.syllabus" id="syllabus" name="syllabus"
                placeholders="Choose a Syllabus" :options="Syllabus" required />

            <!-- <base-form-textarea label="Question Description" name="question_description" id="description" rows="5"
                v-model="form.question_description" /> -->
            
            <base-form-input label="Number of Questions" v-model="form.number_of_questions" id="number_of_questions" name="number_of_questions" type="number" required />

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Add
                Blueprint</base-button-submit>
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
store.setBreadCrumb({ Blueprints: route('questionblueprints.index'), 'Add blueprint': null });

const form = useForm({
    title: null,
    cadre: null,
    nursing_process: null,
    disease_area: null,
    taxonomy: null,
    syllabus: null,
    number_of_questions:null,
    
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
    Comprehension : "Comprehension",
    Application : "Application",
    Analysis : "Analysis",
    Synthesis : "Synthesis",
    Evaluation :"Evaluation"
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
    form.post(route('questionblueprints.store'));
};


</script>