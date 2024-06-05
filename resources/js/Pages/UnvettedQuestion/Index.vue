<template>
    <Head title="Questions List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex items-center justify-between w-full card-title">
                <div class="relative flex items-center w-1/2 my-1 mr-5">
                    <base-search placeholder="Search Questions"
                                 :href="route('unvettedquestions.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
                <button class="btn-vet-selected" @click="vetSelectedQuestions">
                    Vet Selected
                </button>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-row-dashed fs-6 dataTable no-footer gy-3">
                    <thead>
                        <tr>
                            <th><input type="checkbox" @change="toggleSelectAll($event)" :checked="isAllSelected" /></th>
                            <th>C.No</th>
                            <th>Title</th>
                            <th>Cadre</th>
                            <th>Nursing Process</th>
                            <th>Disease Area</th>
                            <th>Syllabus</th>
                            <th>Status</th>
                            <th>Date created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(question, index) in questions.data" :key="question.uuid">
                            <td><input type="checkbox" v-model="selectedQuestions" :value="question.uuid" /></td>
                            <td v-text="index + 1"></td>
                            <td>{{ question.title }}</td>
                            <td>{{ question.cadre }}</td>
                            <td>{{ question.nursing_process }}</td>
                            <td>{{ question.disease_area }}</td>
                            <td>{{ question.syllabus }}</td>
                            <td>{{ question.status }}</td>
                            <td>{{ new Date(question.created_at).toLocaleDateString() }}</td>
                            <td class="text-right">
                                <base-button-link
                                    :href="route('unvettedquestions.edit', [question.uuid])"
                                    title="Edit"
                                    class="p-1 pl-2 ml-1 btn-green"
                                >
                                    Edit
                                </base-button-link>
                                <!-- <base-button-link
                                    :href="route('unvettedquestions.vet', [question.uuid])"
                                    title="Vet"
                                    class="p-1 pl-2 ml-1 btn-yellow"
                                    :class="question.status === 'Vetted' ? 'disabled' : ''"
                                    method="POST"
                                >
                                    Vet
                                </base-button-link> -->
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
                    <base-pagination :paginator="questions" :key="questions.total" />
                </div>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { store } from "@/store.js";
import { reactive, ref, watch, defineProps, defineOptions, computed } from "vue";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    questions: Object,
    filters: Object
});

store.pageTitle = 'Questions Lists';
store.setBreadCrumb({ Unvetted: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });
const selectedQuestions = ref([]);

watch(() => filterBy.per_page, (newVal) => {
    router.get(route('unvettedquestions.index', { search: props.filters.search, ...filterBy }));
});

const isAllSelected = computed(() => {
    return selectedQuestions.value.length === props.questions.data.length;
});

const toggleSelectAll = (event) => {
    selectedQuestions.value = event.target.checked ? props.questions.data.map(q => q.uuid) : [];
};

const vetSelectedQuestions = () => {
    console.log('Button clicked'); // Debugging log
    if (selectedQuestions.value.length > 0) {
        console.log('Selected Questions:', selectedQuestions.value); // Debugging log
        router.post(route('unvettedquestions.bulkVet'), { uuids: selectedQuestions.value })
            .then(response => {
                console.log('Response:', response); // Debugging log
                selectedQuestions.value = []; // Clear the selected questions
                router.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error('Error:', error); // Debugging log
            });
    } else {
        console.log('No questions selected'); // Debugging log
    }
};
</script>

<style>
.btn-yellow {
    background-color: rgb(255, 170, 0);
    color: white;
    cursor: pointer;
}

.btn-yellow:hover {
    background-color: rgb(202, 135, 1);
    color: white;
}

.btn-green:hover {
    background-color: rgb(0, 255, 136);
    color: white; 
}

.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-vet-selected {
    background-color: #4CAF50; /* Green background */
    color: white; /* White text */
    border: none; /* No border */
    padding: 5px 7px; /* Some padding */
    text-align: center; /* Centered text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Get the element to line up correctly */
    font-size: 14px; /* Increase font size */
    margin: 4px 2px; /* Add some margin */
    cursor: pointer; /* Add a pointer cursor on hover */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Add some shadow */
    transition: 0.3s; /* Smooth transition on hover */
}

.btn-vet-selected:hover {
    background-color: #45a049; /* Darker green on hover */
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}
</style>
