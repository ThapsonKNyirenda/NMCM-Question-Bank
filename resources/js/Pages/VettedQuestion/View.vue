<template>
    <Head title="Vetted Questions" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Question</h2>
                <div class="text-base fw-semibold text-muted">Edit a question in the question</div>
            </div>
        </template>
        <form method="POST" :action="route('questions.store')" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'Edit the question?')">
            <base-form-input type="text" label="Question Title" id="title" name="title" v-model="form.title" required readonly />
        
            <label class="form-label required" >Question Description</label>
            <div class="mandatory-fields">
                <quill-input v-model="form.question_description" :placeholders="placeholders" disabled/>
            </div>
            
            <base-form-select label="Select a Cadre" v-model="form.cadre" id="cadre" name="cadre"
                placeholders="Choose a cadre" :options="Cadre" required disabled />

            <base-form-select label="Select a Nursing Process" v-model="form.nursing_process" id="nurseProcess"
                name="nursing_process" placeholders="Choose a Nursing Process" :options="nurseProcess" required disabled />

            <base-form-select label="Select a Disease Area" v-model="form.disease_area" id="diseaseArea"
                name="disease_area" placeholders="Choose a Disease Area" :options="diseaseArea" required disabled />
                
            <base-form-select label="Select Taxonomy Level" id="taxonomy"
                placeholders="Choose taxonomy" :options="taxonomy"/>
                
            <base-form-select label="Select a Syllabus" v-model="form.syllabus" id="syllabus" name="syllabus"
                placeholders="Choose a Syllabus" :options="Syllabus" required disabled />

            <base-form-input type="text" label="Option A" id="Choice_A" name="choice_a" v-model="form.choice_a"
                required readonly />

            <base-form-input type="text" label="Option B" id="Choice_B" name="choice_b" v-model="form.choice_b"
                required readonly />

            <base-form-input type="text" label="Option C" id="Choice_C" name="choice_c" v-model="form.choice_c"
                required readonly />

            <base-form-input type="text" label="Option D" id="Choice_D" name="choice_d" v-model="form.choice_d"
                required readonly />

            <base-form-select label="Select a Correct Answer" v-model="form.correct_answer" id="correctAnswer"
                name="correct_answer" placeholders="Choose a Correct Answer" :options="correctAnswer" required disabled />           
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
    question: Object
});

store.pageTitle = 'Vetted Questions';
store.setBreadCrumb({ Questions: route('unvettedquestions.index'), 'Edit question': null });

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

const taxonomy = {
    Knowledge: "Knowledge",
    Comprehension : "Comprehension",
    Application : "Application",
    Analysis : "Analysis",
    Synthesis : "Synthesis",
    Evaluation :"Evaluation"
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

</script>
