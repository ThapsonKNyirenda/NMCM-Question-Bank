<template>
    <Head title="Questions List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search placeholder="Search Questions"
                                 :href="route('unvettedquestions.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-row-dashed fs-6 dataTable no-footer gy-3">
                    <thead>
                        <tr>
                            <th>C.No</th>
                            <th>Title</th>
                            <th>Cadre</th>
                            <th>Nursing Process</th>
                            <th>Disease Area</th>
                            <th>Syllabus</th>
                            <th>Status</th>
                            <th>Date created</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(question, index) in questions.data" :key="question.uuid">
                            <td v-text="index + 1"></td>
                            <td>{{ question.title }}</td>
                            <td>{{ question.cadre }}</td>
                            <td>{{ question.nursing_process }}</td>
                            <td>{{ question.disease_area }}</td>
                            <td>{{ question.syllabus }}</td>
                            <td>{{ question.status }}</td>
                            <td>{{ new Date(question.created_at).toLocaleDateString()}}</td>
                            <td class="text-right">
                                <!-- <base-button-link
                                    :href="route('questions.edit', [question.uuid])"
                                    title="Edit"
                                    class="p-1 pl-2 ml-1 btn-primary"
                                    icon-class="text-lg ri-pencil-fill"
                                ></base-button-link> -->
                                <base-button-link
                                    :href="route('unvettedquestions.edit', [question.uuid])"
                                    title="Edit"
                                    class="p-1 pl-2 ml-1 btn-green"
                                >
                                    Edit
                                </base-button-link>
                                <base-button-link
                                    :href="route('unvettedquestions.edit', [question.uuid])"
                                    title="Edit"
                                    class="p-1 pl-2 ml-1 btn-yellow"
                                >
                                    Vet
                                </base-button-link>
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
import { Head, router, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { store } from "@/store.js";
import { reactive, watch, defineProps, defineOptions } from "vue";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    questions: Object,
    filters: Object
});

store.pageTitle = 'Questions Lists';
store.setBreadCrumb({ Unvetted: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(() => filterBy.per_page, (newVal) => {
    router.get(route('unvettedquestions.index', { search: props.filters.search, ...filterBy }));
});
</script>

<style>
.btn-yellow {
    background-color: rgb(255, 170, 0);
    color: white;
}

.btn-yellow:hover {
    background-color: rgb(202, 135, 1);
    color: white;
}

.btn-green {
    background-color: rgb(35, 221, 38);
    color: white;
}

.btn-green:hover {
    background-color: rgb(0, 255, 136);
    color: white;
}
</style>
