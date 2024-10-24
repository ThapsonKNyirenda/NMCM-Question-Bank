<template>
    <Head title="Edit Section" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Section</h2>
                <div class="text-base fw-semibold text-muted">
                    Update the section details
                </div>
            </div>
        </template>
        <form
            method="POST"
            :action="route('sections.update', section.id)"
            novalidate
            class="w-3/4 mx-auto needs-validation"
            @submit.prevent="inertiaSubmit"
        >
            <input type="hidden" name="_method" value="PUT" />

            <!-- Paper Code -->
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

            <!-- Disease Area Dropdown -->
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

            <!-- Cadre Dropdown -->
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

            <!-- Number of Questions -->
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

            <!-- Descriptions and Questions -->
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
                            :checked="
                                form.selectedDescriptions.includes(
                                    descriptionId
                                )
                            "
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
                                    :checked="
                                        form.selectedQuestions.includes(
                                            question.id
                                        )
                                    "
                                />

                                <label
                                    :for="`question_${question.id}`"
                                    class="form-check-label text-dark"
                                >
                                    <span v-html="question.title"></span>
                                    <span>
                                        (Taxonomy Level:
                                        {{ question.taxonomy_level.name }} ,
                                        Syllabus: {{ question.syllabus }} )
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
                >Update Section</base-button-submit
            >
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";

// Ensure props are properly defined to include 'section', 'cadres', and 'diseaseAreas'
const props = defineProps({
    section: Object, // Expect section to be passed as an object
    cadres: Object, // Expect cadres as an object
    diseaseAreas: Object, // Expect diseaseAreas as an object
});

defineOptions({ layout: AuthenticatedLayout });

// Initialize the form object with the data from the passed section prop
const form = useForm({
    id: props.section.id, // Using props.section to access the section prop
    cadre_id: props.section.cadre_id || "",
    disease_area_id: props.section.disease_area_id || "",
    section_label: props.section.section_label || "",
    paper_code: props.section.paper_code || "",
    number_of_questions: props.section.number_of_questions || 0,
    // Properly splitting comma-separated string to array
    selectedDescriptions: props.section.selected_descriptions
        ? props.section.selected_descriptions.split(",").map(Number)
        : [],
    selectedQuestions: props.section.selected_questions
        ? props.section.selected_questions.split(",").map(Number)
        : [],
});

const descriptions = ref({});
const questions = ref({});
const filteredQuestions = ref({});

const fetchDescriptions = async () => {
    if (form.disease_area_id) {
        try {
            const response = await axios.get(
                `/api/descriptions/disease-area/${form.disease_area_id}`
            );
            descriptions.value = response.data;

            // Fetch questions for each description
            for (const descriptionId of Object.keys(response.data)) {
                await fetchQuestions(descriptionId);
            }

            // Automatically expand the pre-selected descriptions
            expandSelectedDescriptions();
        } catch (error) {
            console.error("Error fetching descriptions:", error);
        }
    } else {
        descriptions.value = {};
        questions.value = {};
        filteredQuestions.value = {};
    }
};

const expandSelectedDescriptions = () => {
    form.selectedDescriptions.forEach((descriptionId) => {
        toggleQuestions(descriptionId);
    });
};

// Call this after fetching descriptions
fetchDescriptions().then(() => {
    expandSelectedDescriptions();
});

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
    if (!form.selectedDescriptions.includes(descriptionId)) {
        form.selectedQuestions = form.selectedQuestions.filter(
            (qId) =>
                !filteredQuestions.value[descriptionId].find(
                    (q) => q.id === qId
                )
        );
    }
};

watch(
    () => form.cadre_id,
    () => {
        if (form.cadre_id && Object.keys(descriptions.value).length) {
            filterQuestionsByCadre();
        }
    }
);

fetchDescriptions();
</script>
