<template>
    <Head title="View Paper" />
  
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
      <template #header>
        <div class="w-1/2 card-title">
          <h1>Paper Code: {{ paperCode }}</h1>
        </div>
      </template>
  
      <!-- Display sections and questions data structure -->
      <div class="p-4 bg-gray-100 border rounded-md">
        <h2 class="font-bold">Data Structure of sectionsData:</h2>
        <pre>{{ displayData(sectionsData) }}</pre>
      </div>
  
    </base-card-main>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  defineOptions({ layout: AuthenticatedLayout });
  
  const props = defineProps({
    sectionsData: Array,
    paperCode: String,
  });
  
  // Function to display the structure of sectionsData
  const displayData = (data) => {
    return JSON.stringify(data, null, 2); // Formats the JSON data with indentation
  };
  
  // Setting the page title
  import { store } from "@/store.js";
  store.pageTitle = 'Generated Paper';
  </script>
  