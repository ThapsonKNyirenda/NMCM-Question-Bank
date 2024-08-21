<template>
    <Head title="Question Scenarios List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search 
                        placeholder="Search..."
                        :search="filters.search"
                        class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('descriptions.create')"> 
                    New Question Scenario 
                </base-button-new>
                
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table mb-0 table-row-dashed fs-6 dataTable no-footer gy-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Disease Area</th>
                            <th>description</th>
                            <th>Date created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(description, index) in descriptions.data" :key="description.id">
                        <td v-text="index + 1"></td>
                        <td>{{ description.disease_area ? description.disease_area.name : 'N/A' }}</td>
                        <td v-text="stripHtmlTags(description.description)"></td>
                        <td>{{ new Date(description.created_at).toLocaleDateString() }}</td>
                        <td>
                            <button @click="editDescription(description.id)" class="text-green-500 hover:text-blue-700">Edit</button>
                            <button class="ml-2 text-red-500 hover:text-red-700">Delete</button>
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
                    <base-pagination :paginator="descriptions" :key="descriptions.total" />
                </div>
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
    descriptions: Object,
    filters: Object
});

// Method to strip HTML tags
const stripHtmlTags = (html) => {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};

store.pageTitle = 'Question Scenarios List';
store.setBreadCrumb({ Scenarios: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(() => filterBy.per_page, (newVal) => {
    router.get(route('descriptions.index', { search: props.filters.search, ...filterBy }));
});

const editDescription = (descriptionId) => {
    router.get(route('descriptions.edit', descriptionId));
};
</script>
