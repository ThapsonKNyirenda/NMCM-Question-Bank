<template>
    <Head title="Category List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="card-title w-1/2">
                <div class="flex items-center relative my-1 mr-5 w-full">
                    <base-search placeholder="Search Categories"
                                 :href="route('categories.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('categories.create')"> New Category </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 mb-0 dataTable no-footer gy-3">
                    <thead>
                    <tr>
                        <th>C.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                        <tr v-for="(category, index) in categories.data">
                            <td v-text="index + 1"></td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td class="text-right">
                                <base-button-link
                                    :href="route('categories.edit', [category.uuid])"
                                    title="Edit"
                                    class="btn-primary ml-1 p-1 pl-2"
                                    icon-class="ri-pencil-fill text-lg"
                                ></base-button-link>
                                <base-button-delete
                                    :action = "route('categories.destroy', { category: category.uuid })"
                                    class="btn-danger btn-sm p-1 pl-2 py-2"
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
    categories : Object,
    filters: Object
});

store.pageTitle = 'Categories Lists';
store.setBreadCrumb({ Categories: null });

</script>
