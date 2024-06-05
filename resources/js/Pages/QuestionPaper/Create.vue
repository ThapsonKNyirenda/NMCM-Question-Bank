<template>
    <Head title="Question Paper Blueprints List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
      <template #header>
        <div class="w-1/2 card-title">
          <div class="relative flex items-center w-full my-1 mr-5">
            <base-search
              placeholder="Search Questions"
              :href="route('questionblueprints.index')"
              class="w-full"
            />
          </div>
        </div>
        <div class="card-toolbar">
          <base-button-new class="btn-light-primary" :href="route('questionblueprints.create')">
            New Paper Blueprint
          </base-button-new>
        </div>
      </template>
      <div class="relative">
        <div class="table-responsive">
          <table class="table mb-0 align-middle table-row-dashed fs-6 dataTable no-footer gy-3">
            <thead>
              <tr>
                <th class="pl-4">
                  <input type="checkbox" @change="toggleSelectAll($event)" />
                </th>
                <th>C.No</th>
                <th>Cadre</th>
                <th>Nursing Process</th>
                <th>Disease Area</th>
                <th>Taxonomy Level</th>
                <th>Syllabus</th>
                <th>Number of Questions</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="font-medium text-gray-600">
              <tr v-for="(questionBlueprints, index) in questionBlueprints?.data" :key="questionBlueprints.uuid">
                <td class="pl-4">
                  <input type="checkbox" v-model="selectedQuestions" :value="questionBlueprints.uuid" />
                </td>
                <td v-text="index + 1"></td>
                <td>{{ questionBlueprints.cadre }}</td>
                <td>{{ questionBlueprints.nursing_process }}</td>
                <td>{{ questionBlueprints.disease_area }}</td>
                <td>{{ questionBlueprints.taxonomy_level }}</td>
                <td>{{ questionBlueprints.syllabus }}</td>
                <td>{{ questionBlueprints.number_of_questions }}</td>
                <td class="text-right">
                  <!-- Actions Buttons -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <div class="grid grid-cols-5 gap-4">
          <div class="flex items-center justify-center md:justify-start">
            <base-select-page v-model="filterBy.per_page" />
          </div>
          <div class="flex items-center justify-center col-span-4 md:justify-end">
            <base-pagination :paginator="questionBlueprints" :key="questionBlueprints.total" />
          </div>
        </div>
  
        <div class="card-toolbar">
          <br>
          <br>
          <base-button-new class="btn-light-primary" @click="generateQuestionPaper">
            Generate Question Paper
          </base-button-new>
        </div>
      </div>
      <div v-if="formattedQuestions.length > 0" class="p-4 mt-8 bg-white border rounded">
        <h2 class="mb-4 text-xl font-bold">Generated Question Paper</h2>
        <div v-for="(question, index) in formattedQuestions" :key="index" class="mb-4">
          <p class="font-medium">Question {{ index + 1 }}:</p>
          <p>{{ question }}</p>
        </div>
        <base-button-new class="btn-light-primary" @click="printQuestionPaper">
          Print Question Paper
        </base-button-new>
      </div>
    </base-card-main>
  </template>
  
  <script setup>
  import { Head, router } from "@inertiajs/vue3";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { store } from "@/store.js";
  import { reactive, ref, watch } from "vue";
  
  defineOptions({ layout: AuthenticatedLayout });
  
  const props = defineProps({
    questionBlueprints: Object,
    filters: Object
  });
  
  store.pageTitle = 'Question Blueprints Lists';
  store.setBreadCrumb({ Blueprints: null });
  
  const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });
  const selectedQuestions = ref([]);
  const formattedQuestions = ref([]);
  
  // Watch for changes in per_page filter
  watch(() => filterBy.per_page, (newVal) => {
    router.get(route('questionblueprints.index', { search: props.filters.search, ...filterBy }));
  });
  
  // Toggle select all checkboxes
  const toggleSelectAll = (event) => {
    selectedQuestions.value = event.target.checked ? props.questionBlueprints.data.map(q => q.uuid) : [];
  };
  
  // Function to generate question paper
  const generateQuestionPaper = async () => {
    if (props.questionBlueprints.data.length > 0) {
      const firstRow = props.questionBlueprints.data[0];
      const cadre = firstRow.cadre;
  
      try {
        // Query the database to get the question descriptions with the same cadre value
        const response = await fetch(`/api/questions/descriptions?cadre=${cadre}`);
        const result = await response.json();
        formattedQuestions.value = result.descriptions.map(desc => stripHtmlTags(desc));
      } catch (error) {
        console.error('Error fetching question descriptions:', error);
      }
    } else {
      console.log('No data available in the table.');
    }
  };
  
  // Function to strip HTML tags from a string
  const stripHtmlTags = (str) => {
    const tmp = document.createElement("DIV");
    tmp.innerHTML = str;
    return tmp.textContent || tmp.innerText || "";
  };
  
  // Function to print the question paper
  const printQuestionPaper = () => {
    const printContents = document.querySelector('.mt-8').innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
  };
  </script>
  