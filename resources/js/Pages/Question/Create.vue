<template>
    <Head title="Add Question" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Question</h2>
                <div class="text-base fw-semibold text-muted">Add a new question to the description</div>
            </div>
        </template>
        <form method="POST" :action="route('questions.store')" novalidate class="w-3/4 mx-auto needs-validation"
        @submit.prevent="inertiaSubmit">
            
            <input type="hidden" v-model="form.description_id" name="description_id">
            
            <div class="mb-4">
                <label for="title" class="form-label">Question Title</label>
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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue"

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });
const form = useForm({
    description_id: null,  // This will be set when the component is created
    title: '',
    choice_a: '',
    choice_b: '',
    choice_c: '',
    choice_d: '',
    correct_answer: ''
});

const props = defineProps(['description_id']);

// Set the description_id from the props
form.description_id = props.description_id;

// Form submission method
const inertiaSubmit = () => {
    // Submit the form
    form.post(route('questions.store'));
};
</script>
