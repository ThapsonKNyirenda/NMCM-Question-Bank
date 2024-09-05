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
                    @change="fetchDescriptions"
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
                    @change="fetchCadreQuestions"
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

            <!-- Section Label Dropdown -->
            <div class="mb-4">
                <label for="section_label" class="form-label"
                    >Section Label</label
                >
                <select
                    v-model="form.section_label"
                    id="section_label"
                    name="section_label"
                    class="form-select"
                    required
                >
                    <option disabled value="">Choose a section label</option>
                    <option v-for="n in 9" :key="n" :value="n">{{ n }}</option>
                </select>
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

            <div v-if="Object.keys(descriptions).length">
                <h3
                    class="m-2 text-lg font-semibold"
                    style="text-decoration: underline"
                >
                    Select Descriptions and Questions
                </h3>

                <div
                    v-for="(description, descriptionId) in descriptions"
                    :key="descriptionId"
                    class="mb-4"
                >
                    <div class="m-2 form-check">
                        <!-- Checkbox for the description -->
                        <input
                            type="checkbox"
                            :value="descriptionId"
                            v-model="form.selectedDescriptions"
                            class="w-5 h-5 border border-gray-300 rounded-md appearance-none form-check-input"
                            :id="`description_${descriptionId}`"
                            @change="toggleQuestions(descriptionId)"
                        />
                        <label
                            :for="`description_${descriptionId}`"
                            class="font-semibold form-check-label text-dark"
                            v-html="description"
                        ></label>
                    </div>

                    <!-- Show questions only when the description is selected -->
                    <div
                        v-if="form.selectedDescriptions.includes(descriptionId)"
                    >
                        <div v-if="filteredQuestions[descriptionId]">
                            <div
                                v-for="question in filteredQuestions[
                                    descriptionId
                                ]"
                                :key="question.id"
                                class="m-2 form-check"
                            >
                                <input
                                    type="checkbox"
                                    :value="question.id"
                                    v-model="form.selectedQuestions"
                                    class="w-5 h-5 border border-gray-300 rounded-md appearance-none form-check-input"
                                    :id="`question_${question.id}`"
                                />
                                <!-- Display question title along with taxonomy level and syllabus -->
                                <label
                                    :for="`question_${question.id}`"
                                    class="form-check-label text-dark"
                                >
                                    <span v-html="question.title"></span>
                                    <span>
                                        (Taxonomy Level:
                                        {{ question.taxonomy_level.name}},
                                        Syllabus: {{ question.syllabus }})
                                    </span>
                                </label>

                                <!-- Display choices below the question -->
                                <div class="ml-4">
                                    <p>A. {{ question.choice_a }}</p>
                                    <p>B. {{ question.choice_b }}</p>
                                    <p>C. {{ question.choice_c }}</p>
                                    <p>D. {{ question.choice_d }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
// Similar to your original script setup with a few tweaks for the new functionality

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";

defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
    cadre_id: "",
    disease_area_id: "",
    section_label: "",
    paper_code: "",
    number_of_questions: 0,
    selectedDescriptions: [],
    selectedQuestions: [],
});

const descriptions = ref({});
const questions = ref({});
const filteredQuestions = ref({});

const props = defineProps(["cadres", "diseaseAreas"]);

const fetchDescriptions = async () => {
    if (form.disease_area_id) {
        try {
            const response = await axios.get(
                `/api/descriptions/disease-area/${form.disease_area_id}`
            );
            descriptions.value = response.data;
            for (const descriptionId of Object.keys(response.data)) {
                await fetchQuestions(descriptionId);
            }
        } catch (error) {
            console.error("Error fetching descriptions:", error);
        }
    } else {
        descriptions.value = {};
        questions.value = {};
        filteredQuestions.value = {};
    }
};

const fetchQuestions = async (descriptionId) => {
    try {
        const response = await axios.get(`/api/questions/${descriptionId}`);
        questions.value = {
            ...questions.value,
            [descriptionId]: response.data,
        };
        filterQuestionsByCadre();
    } catch (error) {
        console.error(
            `Error fetching questions for description ${descriptionId}:`,
            error
        );
    }
};

const filterQuestionsByCadre = () => {
    if (form.cadre_id) {
        const filtered = {};
        Object.keys(questions.value).forEach((descriptionId) => {
            filtered[descriptionId] = questions.value[descriptionId].filter(
                (question) => question.cadre_id == form.cadre_id
            );
        });
        filteredQuestions.value = filtered;
    } else {
        filteredQuestions.value = questions.value;
    }
};

const toggleQuestions = (descriptionId) => {
    // You can handle showing/hiding questions here based on selected descriptions
};

watch(() => form.cadre_id, filterQuestionsByCadre);

const inertiaSubmit = () => {
    form.post(route("sections.store"));
};
</script>
