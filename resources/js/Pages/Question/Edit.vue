<template>
    <Head title="Edit Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Question Item</h2>
                <div class="text-base fw-semibold text-muted">Edit the question item in the scenario</div>
            </div>
        </template>
        <form method="POST" :action="form.id ? route('questions.update', form.id) : route('questions.store')" novalidate class="w-3/4 mx-auto needs-validation"
        @submit.prevent="inertiaSubmit">
            <input type="hidden" v-model="form.description_id" name="description_id">
            <div class="mb-4">
                <label for="cadre" class="form-label">Select a Cadre</label>
                <select v-model="form.cadre" id="cadre" name="cadre" class="form-select" required>
                    <option disabled value="">Choose a cadre</option>
                    <option v-for="(value, key) in cadres" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <!-- Other form fields remain the same -->

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">
                {{ form.id ? 'Update' : 'Save' }}
            </base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue";
import { ref, onMounted } from 'vue';

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

const props = defineProps(['cadres', 'nursingProcesses', 'taxonomyLevels', 'description_id', 'question']);

const form = useForm({
    id: props.question ? props.question.id : null,
    cadre: props.question ? props.question.cadre_id : '',
    nursing_process: props.question ? props.question.nursing_process_id : '',
    taxonomy: props.question ? props.question.taxonomy_level_id : '',
    syllabus: props.question ? props.question.syllabus : '',
    description_id: props.description_id,  // This will be set when the component is created
    title: props.question ? props.question.title : '',
    choice_a: props.question ? props.question.choice_a : '',
    choice_b: props.question ? props.question.choice_b : '',
    choice_c: props.question ? props.question.choice_c : '',
    choice_d: props.question ? props.question.choice_d : '',
    correct_answer: props.question ? props.question.correct_answer : ''
});

const currentYear = new Date().getFullYear();
const syllabusOptions = ref([
    `${currentYear}`,
    `${currentYear + 1}`,
    `${currentYear + 2}`,
    `${currentYear + 3}`,
]);

// Form submission method
const inertiaSubmit = () => {
    if (form.id) {
        form.put(route('questions.update', form.id));
    } else {
        form.post(route('questions.store'));
    }
};
</script>
