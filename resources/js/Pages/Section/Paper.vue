<template>
  <Head title="View Paper" />

  <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
    <template #header>
      <div class="w-1/2 card-title">
        <h1>Paper Code: {{ paperCode }}</h1>
      </div>
    </template>

    <!-- Display sections and questions -->
    <div v-if="isDataFetched">

      <div v-for="(section, index) in sectionsData" :key="section.section_label" class="mb-4">
        <!-- Display Section A, Section B, etc. -->
        <h3 style="font-size: large; font-weight: bold;">Section {{ getSectionLabel(index) }}:</h3>
        <div v-for="(questions, descriptionId) in groupQuestionsByDescription(section.section_label)" :key="descriptionId" class="mb-4">
          <!-- Display the description without the "Description" title -->
          <div v-if="questions.length > 0 && questions[0].description">
            <p v-html="questions[0].description.description"></p>
          </div>

          <!-- Loop through questions with the same description -->
          <ul>
            <li v-for="question in questions" :key="question.id" class="mb-4">
              <!-- Display the question -->
              <div class="flex items-start">
                <strong class="mr-2">{{ getQuestionNumber() }}.</strong> 
                <span v-html="question.title"></span>
              </div>

              <!-- Display multiple-choice options below the question title -->
              <ul class="pl-5 mt-2">
                <li v-if="question.choice_a">A. {{ question.choice_a }}</li>
                <li v-if="question.choice_b">B. {{ question.choice_b }}</li>
                <li v-if="question.choice_c">C. {{ question.choice_c }}</li>
                <li v-if="question.choice_d">D. {{ question.choice_d }}</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </base-card-main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
  paperCode: String,
});

// Variables to store the fetched data
const sectionsData = ref([]);
const isDataFetched = ref(false);
const sectionQuestions = ref({}); // Store questions for each section
let globalQuestionCounter = 1; // Global question counter

// Function to fetch data when the page is loaded
const generatePaper = async () => {
  try {
    const response = await axios.get(`/api/sections/questions/${props.paperCode}`);
    sectionsData.value = response.data;

    // Fetch the questions for each section
    await fetchQuestionsForSections(sectionsData.value);

    isDataFetched.value = true;
  } catch (error) {
    console.error('Error fetching paper:', error);
  }
};

// Function to fetch questions by their IDs
const fetchQuestionsForSections = async (sections) => {
  for (const section of sections) {
    const questionIds = section.question_ids;

    // Fetch questions where the IDs match the question_ids array
    try {
      const response = await axios.post('/api/questions/by-ids', { ids: questionIds });
      sectionQuestions.value[section.section_label] = response.data;
    } catch (error) {
      console.error('Error fetching questions for section:', section.section_label, error);
    }
  }
};

// Function to group questions by description for a specific section label
const groupQuestionsByDescription = (sectionLabel) => {
  const questions = sectionQuestions.value[sectionLabel] || [];
  return questions.reduce((grouped, question) => {
    if (!grouped[question.description_id]) {
      grouped[question.description_id] = [];
    }
    grouped[question.description_id].push(question);
    return grouped;
  }, {});
};

// Function to get section labels as Section A, B, C, etc.
const getSectionLabel = (index) => {
  return String.fromCharCode(65 + index); // 65 is ASCII for 'A'
};

// Computed property to get and increment the question number
const getQuestionNumber = () => {
  return globalQuestionCounter++;
};

// Call the generatePaper function once the page has loaded
onMounted(() => {
  generatePaper();
});

// Setting the page title
import { store } from "@/store.js";
store.pageTitle = 'Generated Paper';
</script>
