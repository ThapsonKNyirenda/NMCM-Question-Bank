<template>

    <Head title="Add Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question</h2>
                <div class="text-base fw-semibold text-muted">Add a question to the question bank</div>
            </div>
        </template>
        <form method="POST" :action="route('questions.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'add the question?')">
            <base-form-input type="text" label="Question Title" id="title" name="title" v-model="form.title" required />

            <base-form-select label="Select a Cadre" v-model="form.Cadre" id="cadre" name="cadre"
                placeholders="Choose a cadre" :options="Cadre" required />

            <base-form-select label="Select a Nursing Process" v-model="form.nurseProcess" id="nurseProcess"
                name="nurseProcess" placeholders="Choose a Nursing Process" :options="nurseProcess" required />

            <base-form-select label="Select a Disease Area" v-model="form.diseaseArea" id="diseaseArea"
                name="diseaseArea" placeholders="Choose a Disease Area" :options="diseaseArea" required />

            <base-form-select label="Select a Syllabus" v-model="form.Syllabus" id="Syllabus" name="Syllabus"
                placeholders="Choose a Syllabus" :options="Syllabus" required />

            <base-form-textarea label="Question Description" name="description" id="description" rows="5"
                v-model="form.description" />

            <base-form-input type="text" label="Choice A" id="Choice_A" name="Choice_A" v-model="form.Choice_A"
                required />

            <base-form-input type="text" label="Choice B" id="Choice_B" name="Choice_B" v-model="form.Choice_B"
                required />

            <base-form-input type="text" label="Choice C" id="Choice_C" name="Choice_C" v-model="form.Choice_C"
                required />

            <base-form-input type="text" label="Choice D" id="Choice_D" name="Choice_D" v-model="form.Choice_D"
                required />

            <base-form-select label="Select a Correct Answer" v-model="form.correctAnswer" id="correctAnswer"
                name="correctAnswer" placeholders="Choose a Correct Asnwer" :options="correctAnswer" required />

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Add
                Question</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { submit } from "@/helpers/form_helpers.js";
import { useForm, Head } from "@inertiajs/vue3";

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'Add Question';
store.setBreadCrumb({ Categories: route('questions.index'), 'Add question': null });

const form = useForm({
    Cadre: null,
    nurseProcess: null,
    title: null,
    diseaseArea: null,
    Syllabus: null,
    correctAnswer: null,
    Choice_A: null,
    Choice_B: null,
    Choice_C: null,
    Choice_D: null,
    status: null,
});

const Cadre = {
    registeredNurse: "Registered Nurse",
    licensedPracticalNurse: "Licensed Practical Nurse",
    nursePractitioner: "Nurse Practitioner"
}

const nurseProcess = {
    Assessment: "Assessment",
    Diagnosis: "Diagnosis",
    Planning: "Planning",
    Implementation: "Implementation",
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
    2022_2023: "2022-2023",
    2023_2024: "2023-2024",
}

const correctAnswer = {
    A: "A",
    B: "B",
    C: "C",
    D: "D"
}

const inertiaSubmit = () => {
    console.log(JSON.stringify(form, null, 2));
    // form.post(route('questions.store'), form.data);
};


</script>
