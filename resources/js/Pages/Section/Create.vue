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

            <div v-if="Object.keys(descriptions).length">
                <h3
                    class="m-2 text-lg font-semibold"
                    style="text-decoration: underline"
                >
                    Select desirable questions under each Scenario
                </h3>

                <div
                    v-for="(description, descriptionId) in descriptions"
                    :key="descriptionId"
                    class="mb-4"
                >
                    <div class="font-semibold" v-html="description"></div>
                    <div v-if="filteredQuestions[descriptionId]">
                        <div
                            v-for="question in filteredQuestions[descriptionId]"
                            :key="question.id"
                            class="m-2 form-check"
                        >
                            <input
                                type="checkbox"
                                :value="question.id"
                                v-model="form.selectedQuestions"
                                class="form-check-input"
                                :id="`question_${question.id}`"
                            />
                            <label
                                :for="`question_${question.id}`"
                                class="form-check-label text-dark"
                                v-html="question.title"
                            ></label>
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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";

// Set layout and initialize the form
defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
    cadre_id: "",
    disease_area_id: "",
    title: "",
    paper_code: "",
    number_of_questions: 0,
    selectedDescriptions: [],
    selectedQuestions: [],
});

const descriptions = ref({});
const questions = ref({});
const filteredQuestions = ref({}); // This will store the filtered questions based on cadre

// Receive props
const props = defineProps(["cadres", "diseaseAreas"]);

// Method to fetch descriptions by disease area
const fetchDescriptions = async () => {
    if (form.disease_area_id) {
        try {
            const response = await axios.get(
                `/api/descriptions/disease-area/${form.disease_area_id}`
            );
            console.log("Fetched Descriptions:", response.data);
            descriptions.value = response.data;
            // Fetch questions for each description
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

// Method to fetch questions by description ID
const fetchQuestions = async (descriptionId) => {
    try {
        const response = await axios.get(`/api/questions/${descriptionId}`);
        console.log(
            `Fetched Questions for Description ${descriptionId}:`,
            response.data
        );
        questions.value = {
            ...questions.value,
            [descriptionId]: response.data,
        };
        filterQuestionsByCadre(); // Apply cadre filter when questions are fetched
    } catch (error) {
        console.error(
            `Error fetching questions for description ${descriptionId}:`,
            error
        );
    }
};

// Filter questions by the selected cadre
const filterQuestionsByCadre = () => {
    if (form.cadre_id) {
        console.log("Selected Cadre ID:", form.cadre_id); // Log the selected cadre_id
        
        // Filter questions for each description based on the selected cadre
        const filtered = {};
        Object.keys(questions.value).forEach((descriptionId) => {
            console.log(`Questions for Description ${descriptionId}:`, questions.value[descriptionId]);

            filtered[descriptionId] = questions.value[descriptionId].filter(
                (question) => {
                    console.log(`Question ID: ${question.id}, Cadre ID: ${question.cadre_id}`);
                    return question.cadre_id == form.cadre_id;
                }
            );
        });

        console.log("Filtered Questions:", filtered);
        filteredQuestions.value = filtered;
    } else {
        console.log("No Cadre selected. Showing all questions.");
        filteredQuestions.value = questions.value; // If no cadre is selected, show all questions
    }
};


// Watch for cadre selection and re-apply the filter
watch(() => form.cadre_id, filterQuestionsByCadre);

// Form submission method
const inertiaSubmit = () => {
    form.post(route("sections.store"));
};
</script>
