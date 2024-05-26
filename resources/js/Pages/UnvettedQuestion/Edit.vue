<template>

    <Head title="View Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Question</h2>
                <div class="text-base fw-semibold text-muted">Edit a question in the question bank</div>
            </div>
        </template>
        <form method="POST" :action="route('questions.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'Edit the question?')">
            <base-form-input type="text" label="Question Title" id="title" name="title" v-model="form.title" required />

            <base-form-select label="Select a Cadre" v-model="form.cadre" id="cadre" name="cadre"
                placeholders="Choose a cadre" :options="Cadre" required />

            <base-form-select label="Select a Nursing Process" v-model="form.nursing_process" id="nurseProcess"
                name="nursing_process" placeholders="Choose a Nursing Process" :options="nurseProcess" required />

            <base-form-select label="Select a Disease Area" v-model="form.disease_area" id="diseaseArea"
                name="disease_area" placeholders="Choose a Disease Area" :options="diseaseArea" required />

            <base-form-select label="Select a Syllabus" v-model="form.syllabus" id="syllabus" name="syllabus"
                placeholders="Choose a Syllabus" :options="Syllabus" required />

            <base-form-textarea label="Question Description" name="question_description" id="description" rows="5"
                v-model="form.question_description" />

            <base-form-input type="text" label="Choice A" id="Choice_A" name="choice_a" v-model="form.choice_a"
                required />

            <base-form-input type="text" label="Choice B" id="Choice_B" name="choice_b" v-model="form.choice_b"
                required />

            <base-form-input type="text" label="Choice C" id="Choice_C" name="choice_c" v-model="form.choice_c"
                required />

            <base-form-input type="text" label="Choice D" id="Choice_D" name="choice_d" v-model="form.choice_d"
                required />

            <base-form-select label="Select a Correct Answer" v-model="form.correct_answer" id="correctAnswer"
                name="correct_answer" placeholders="Choose a Correct Asnwer" :options="correctAnswer" required />

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Edit
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

const props = defineProps({
    question: Object
});

store.pageTitle = 'Edit Question';
store.setBreadCrumb({ Questions: route('questions.index'), 'Edit question': null });

const form = useForm(
    props.question,
);

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

const correctAnswer = {
    A: "A",
    B: "B",
    C: "C",
    D: "D"
}

// const inertiaSubmit = () => {
//     console.log(JSON.stringify(form, null, 2));
//     form.post(route('questions.store'));
// };

const inertiaSubmit = () => {
    form.patch(route('questions.update', { question: props.question.uuid }));
};


</script>
