<template>
  <Head title="Question Paper Blueprints List" />
  <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
    <template #header>
      <div class="w-1/2 card-title">
        <div class="relative flex items-center w-full my-1 mr-5">
          <base-search placeholder="Search Questions" :href="route('questionblueprints.index')" class="w-full" />
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
              <th>#</th>
              <th>Paper Code</th>
              <th>Cadre</th>
              <th>Taxonomy</th>
              <th>Nursing Process</th>
              <th>Disease Area</th>
              <!-- <th>Taxonomy Level</th> -->
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
              <td>{{ questionBlueprints.question_paper_code }}</td>
              <td>{{ questionBlueprints.cadre }}</td>
              <td>{{ questionBlueprints.taxonomy }}</td>
              <td>{{ questionBlueprints.nursing_process }}</td>
              <td>{{ questionBlueprints.disease_area }}</td>
              <!-- <td>{{ questionBlueprints.taxonomy_level }}</td> -->
              <td>{{ questionBlueprints.syllabus }}</td>
              <td>{{ questionBlueprints.number_of_questions }}</td>
              <td class="text-right">
                <!-- Actions Buttons -->
                <base-button-link
                    :href="route('questionblueprints.edit', [questionBlueprints.uuid])"
                    title="Edit"
                    class="p-1 pl-2 ml-1 btn-primary"
                    icon-class="text-lg ri-pencil-fill"
                ></base-button-link>
                <base-button-delete
                    :action="route('questionblueprints.destroy', {questionblueprint: questionBlueprints.uuid })"
                    class="p-1 py-2 pl-2 btn-danger btn-sm"
                ></base-button-delete>
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

// Watch for changes in per_page filter
watch(() => filterBy.per_page, (newVal) => {
  router.get(route('questionblueprints.index', { search: props.filters.search, ...filterBy }));
});

// Toggle select all checkboxes
const toggleSelectAll = (event) => {
  selectedQuestions.value = event.target.checked ? props.questionBlueprints.data.map(q => q.uuid) : [];
};

// Function to generate question paper
// Function to generate question paper
const generateQuestionPaper = async () => {
  if (selectedQuestions.value.length > 0) {
    console.log('Selected Question IDs:', selectedQuestions.value);

    const selectedData = props.questionBlueprints.data
      .filter(bp => selectedQuestions.value.includes(bp.uuid))
      .map(bp => ({
        cadre: bp.cadre,
        nursing_process: bp.nursing_process,
        disease_area: bp.disease_area,
        taxonomy: bp.taxonomy
      }));

    console.log('Selected Data:', selectedData);

    // Create a function to fetch questions based on the selected data
    const fetchQuestions = async (data) => {
      try {
        const response = await fetch(`/api/questions`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        return await response.json();
      } catch (error) {
        console.error('Error fetching questions:', error);
        return [];
      }
    };

    // Fetch questions for each set of selected data
    const questionsPromises = selectedData.map(data => fetchQuestions(data));
    const questionsResults = await Promise.all(questionsPromises);

    // Combine the questions into a single array
    const combinedQuestions = questionsResults.flat();

    console.log('Fetched Questions Type:', typeof combinedQuestions);
    console.log('Fetched Questions:', combinedQuestions);
    console.log('Fetched Questions JSON:', JSON.stringify(combinedQuestions, null, 2));

    // Process or navigate to another page with the fetched questions
    router.visit(route('question.show', { uuid: combinedQuestions[0].uuid }));
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
</script>
