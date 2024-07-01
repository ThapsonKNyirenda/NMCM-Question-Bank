<template>
    <Head title="Edit Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Question</h2>
                <div class="text-base fw-semibold text-muted"></div>
            </div>
        </template>
        <form :action="route('questions.update', props.question.uuid)" method="POST" @submit.prevent="submitForm">
         
            
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

            <base-form-input type="text" label="Answer Option A" id="Choice_A" name="choice_a" v-model="form.choice_a" required />
            <base-form-input type="text" label="Answer Option B" id="Choice_B" name="choice_b" v-model="form.choice_b" required />
            <base-form-input type="text" label="Answer Option C" id="Choice_C" name="choice_c" v-model="form.choice_c" required />
            <base-form-input type="text" label="Answer Option D" id="Choice_D" name="choice_d" v-model="form.choice_d" required />

            <div class="mb-4">
                <label for="correctAnswer" class="form-label">Select a Correct Answer</label>
                <select v-model="form.correct_answer" id="correctAnswer" name="correct_answer" class="form-select" required>
                    <option disabled value="">Choose a Correct Answer</option>
                    <option v-for="(value, key) in correctAnswer" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>
            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Save</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { useForm, Head } from "@inertiajs/vue3"
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue"
import { store } from "@/store.js"

defineOptions({ layout: AuthenticatedLayout })

const props = defineProps({
    question: Object
})

store.pageTitle = 'Edit Question'
store.setBreadCrumb({ Questions: route('unvettedquestions.index'), 'Edit question': null })

const form = useForm(props.question)

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
    "2023-2024": "2023-2024"
}

const correctAnswer = {
    A: "A",
    B: "B",
    C: "C",
    D: "D"
}

const submitForm = () => {
    form.patch(route('unvettedquestions.update', props.question.uuid), {
        onSuccess: () => {
            window.location.href = route('unvettedquestions.index')
        }
    })
}
</script>
