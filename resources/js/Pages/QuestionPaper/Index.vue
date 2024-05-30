<template>
    <Head title="Questions List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search 
                        placeholder="Search Question Papers"
                        :href="route('questions.index')"
                        class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary"> 
                    New Question Paper 
                </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                
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

store.pageTitle = 'Question Papers Lists';
store.setBreadCrumb({ Papers: null });

</script>
