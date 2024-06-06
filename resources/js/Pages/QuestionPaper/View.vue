<template>
    <div class="p-8 exam-paper">
      <h1 class="mb-8 text-2xl font-bold text-center">Examination Paper</h1>
      <div v-for="(question, index) in descriptions" :key="index" class="mb-4">
        <p class="font-medium">Question {{ index + 1 }}:</p>
        <p v-html="question"></p>
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
    descriptions: Array
  });
  
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
  
  @media print {
    .exam-paper {
      border: none;
      box-shadow: none;
    }
  }
  </style>
  