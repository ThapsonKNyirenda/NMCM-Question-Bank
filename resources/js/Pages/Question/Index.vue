<template>
    <Head title="Questions List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search placeholder="Search Questions"
                                 :href="route('categories.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('questions.create')"> New Question </base-button-new>
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
                        <th>Description</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                        <tr v-for="(question, index) in questions.data">
                            <td v-text="index + 1"></td>
                            <td>{{ question.name }}</td>
                            <td>{{ question.description }}</td>
                            <td class="text-right">
                                <base-button-link
                                    :href="route('questions.edit', [question.uuid])"
                                    title="Edit"
                                    class="p-1 pl-2 ml-1 btn-primary"
                                    icon-class="text-lg ri-pencil-fill"
                                ></base-button-link>
                                <base-button-delete
                                    :action = "route('categories.destroy', { question: question.uuid })"
                                    class="p-1 py-2 pl-2 btn-danger btn-sm"
                                ></base-button-delete>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </base-card-main>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {Head} from "@inertiajs/vue3";
import {store} from "@/store.js";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    questions : Object,
    filters: Object
});

store.pageTitle = 'Questions Lists';
store.setBreadCrumb({ Questions: null });

</script>
