<template>
    <Head title="Question Descriptions List" />
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
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-row-dashed fs-6 dataTable no-footer gy-3">
                    <thead>
                        <tr>
                            <th>C.No</th>
                            <th>Cadre</th>
                            <th>Nursing Process</th>
                            <th>Disease Area</th>
                            <th>Taxonomy</th>
                            <th>Syllabus</th>
                            <th>Status</th>
                            <th>Date created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-600">
                        <tr v-for="(description, index) in descriptions.data" :key="description.uuid">
                            <td v-text="index + 1"></td>
                            <td>{{ description.cadre.name }}</td>
                            <td>{{ description.nursing_process_id }}</td>
                            <td>{{ description.disease_area_id }}</td>
                            <td>{{ description.taxonomy_level_id }}</td>
                            <td>{{ description.syllabus }}</td>
                            <td>{{ description.status }}</td>
                            <td>{{ new Date(description.created_at).toLocaleDateString() }}</td>
                            <td class="text-right">
                                <!-- Actions -->
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

store.pageTitle = 'Question Descriptions Lists';
store.setBreadCrumb({ Questions: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(() => filterBy.per_page, (newVal) => {
    router.get(route('descriptions.index', { search: props.filters.search, ...filterBy }));
});
</script>
