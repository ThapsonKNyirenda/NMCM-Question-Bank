<template>
    <div class="p-8 exam-paper">
      <h1 class="mb-8 text-2xl font-bold text-center">NMCM Exams</h1>
      <div v-for="(question, index) in filteredQuestions" :key="index" class="mb-8">
        <div>
          <p class="font-medium">{{ question.question_description}}</p>
        </div>
        <div class="ml-4">
          <p v-if="question.choice_a">A. {{ question.choice_a }}</p>
          <p v-if="question.choice_b">B. {{ question.choice_b }}</p>
          <p v-if="question.choice_c">C. {{ question.choice_c }}</p>
          <p v-if="question.choice_d">D. {{ question.choice_d }}</p>
        </div>
      </div>
      <button @click="printPage" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">
        Print Question Paper
      </button>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { Head } from '@inertiajs/vue3';
  
  const props = defineProps({
    questions: Array
  });
  
  const filteredQuestions = props.questions.filter(question => question.question_description !== '');
  
  const printPage = () => {
    window.print();
  };
  </script>
  
  <style scoped>
  .exam-paper {
    max-width: 800px;
    margin: auto;
    background-color: white;
    padding: 20px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .exam-paper p {
    margin: 0.5em 0;
  }
  
  @media print {
    .exam-paper {
      border: none;
      box-shadow: none;
    }
  
    .exam-paper button {
      display: none;
    }
  }
  </style>