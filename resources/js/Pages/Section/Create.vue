<template>
    <Head title="Create Section" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Create Section</h2>
                <div class="text-base fw-semibold text-muted">
                    Add a new section for the paper
                </div>
            </div>
        </template>
        <form
            method="POST"
            :action="route('sections.store')"
            novalidate
            class="w-3/4 mx-auto needs-validation"
            @submit.prevent="inertiaSubmit"
        >
            <div class="mb-4">
                <label for="paper_code" class="form-label">Paper Code</label>
                <input
                    type="text"
                    v-model="form.paper_code"
                    id="paper_code"
                    name="paper_code"
                    class="form-control"
                    placeholder="Enter the paper code"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="disease_area" class="form-label"
                    >Select a Disease Area</label
                >
                <select
                    v-model="form.disease_area_id"
                    id="disease_area"
                    name="disease_area_id"
                    class="form-select"
                    required
                >
                    <option disabled value="">Choose a disease area</option>
                    <option
                        v-for="(value, key) in diseaseAreas"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="cadre" class="form-label">Select a Cadre</label>
                <select
                    v-model="form.cadre_id"
                    id="cadre"
                    name="cadre_id"
                    class="form-select"
                    required
                >
                    <option disabled value="">Choose a cadre</option>
                    <option
                        v-for="(value, key) in cadres"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
            </div>

           
            <div class="mb-4">
                <label for="title" class="form-label">Section Title</label>
                <input
                    type="text"
                    v-model="form.title"
                    id="title"
                    name="title"
                    class="form-control"
                    placeholder="Enter the section title"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="number_of_questions" class="form-label"
                    >Number of Questions</label
                >
                <input
                    type="number"
                    v-model.number="form.number_of_questions"
                    id="number_of_questions"
                    name="number_of_questions"
                    class="form-control"
                    required
                />
            </div>

            <base-button-submit
                class="btn-light-primary"
                type="submit"
                :form-is-processing="form.processing"
                >Create Section</base-button-submit
            >
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
    cadre_id: "",
    disease_area_id: "",
    title: "",
    paper_code: "",
    number_of_questions: 0,
});

// Receive props
const props = defineProps(["cadres", "diseaseAreas"]);

// Form submission method
const inertiaSubmit = () => {
    form.post(route("sections.store"));
};
</script>
