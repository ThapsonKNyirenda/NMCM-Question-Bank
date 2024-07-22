<template>
  <Head title="Question Paper Details" />
  <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
    <template #header>
      <div class="w-1/2 card-title">
        <h1>Question Paper Details</h1>
      </div>
    </template>
    <div class="relative">
      <div v-if="questions.length">
        <div v-for="(question, index) in questions" :key="question.uuid" class="mb-4">
          <h2>{{ index + 1 }}. {{ question.title }}</h2>
          <p><strong>Cadre:</strong> {{ question.cadre }}</p>
          <p><strong>Nursing Process:</strong> {{ question.nursing_process }}</p>
          <p><strong>Disease Area:</strong> {{ question.disease_area }}</p>
          <p><strong>Taxonomy:</strong> {{ question.taxonomy }}</p>
          <p><strong>Syllabus:</strong> {{ question.syllabus }}</p>
          <p><strong>Description:</strong> {{ stripHtmlTags(question.question_description) }}</p>
          <p><strong>Choices:</strong></p>
          <ul>
            <li>A. {{ question.choice_a }}</li>
            <li>B. {{ question.choice_b }}</li>
            <li>C. {{ question.choice_c }}</li>
            <li>D. {{ question.choice_d }}</li>
          </ul>
          <p><strong>Correct Answer:</strong> {{ question.correct_answer }}</p>
        </div>
      </div>
      <div v-else>
        <p>No questions available.</p>
      </div>
    </div>
  </base-card-main>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
  questions: Array
});

const questions = reactive(props.questions);

// Function to strip HTML tags from a string
const stripHtmlTags = (str) => {
  const tmp = document.createElement("DIV");
  tmp.innerHTML = str;
  return tmp.textContent || tmp.innerText || "";
};
</script>
