<template>
    <Head title="Add Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question Item</h2>
                <div class="text-base fw-semibold text-muted">Add a new question item to the scenario</div>
            </div>
        </template>
        <form method="POST" :action="route('questions.scestore')" novalidate class="w-3/4 mx-auto needs-validation"
        @submit.prevent="inertiaSubmit">
            
            <input type="hidden" v-model="form.description_id" name="description_id">

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
                <label for="taxonomy" class="form-label">Select Taxonomy Level</label>
                <select v-model="form.taxonomy" id="taxonomy" name="taxonomy" class="form-select" required>
                    <option disabled value="">Choose taxonomy</option>
                    <option v-for="(value, key) in taxonomyLevels" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>


            <div class="mb-4">
                <label for="syllabus" class="form-label">Syllabus</label>
                <select v-model="form.syllabus" id="syllabus" name="syllabus" class="form-select" required>
                    <option disabled value="">Choose a syllabus</option>
                    <option v-for="year in syllabusOptions" :key="year" :value="year">
                        {{ year }}
                    </option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="title" class="form-label">Question Item Title</label>
                <quill-input v-model="form.title" placeholder="Enter the question title" />
            </div>

            <div class="mb-4">
                <label for="choice_a" class="form-label">Choice A</label>
                <input type="text" v-model="form.choice_a" id="choice_a" name="choice_a" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="choice_b" class="form-label">Choice B</label>
                <input type="text" v-model="form.choice_b" id="choice_b" name="choice_b" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="choice_c" class="form-label">Choice C</label>
                <input type="text" v-model="form.choice_c" id="choice_c" name="choice_c" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="choice_d" class="form-label">Choice D</label>
                <input type="text" v-model="form.choice_d" id="choice_d" name="choice_d" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="correct_answer" class="form-label">Correct Answer</label>
                <select v-model="form.correct_answer" id="correct_answer" name="correct_answer" class="form-select" required>
                    <option disabled value="">Choose the correct answer</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Save</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue";
import { ref } from 'vue';

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
    cadre: '',
    nursing_process: '',
    taxonomy: '',
    syllabus: '',
    description_id: null,  // This will be set when the component is created
    title: '',
    choice_a: '',
    choice_b: '',
    choice_c: '',
    choice_d: '',
    correct_answer: ''
});

// Receive props
const props = defineProps(['cadres', 'nursingProcesses', 'taxonomyLevels', 'description_id']);

// Initialize form with description_id
form.description_id = props.description_id;

const currentYear = new Date().getFullYear();
const syllabusOptions = ref([
    `${currentYear}`,
    `${currentYear + 1}`,
    `${currentYear + 2}`,
    `${currentYear + 3}`,
]);

// Form submission method
const inertiaSubmit = () => {
    form.post(route('questions.scestore'));
};
</script>
