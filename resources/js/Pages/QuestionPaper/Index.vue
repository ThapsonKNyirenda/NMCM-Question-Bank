<template>
    <Head title="Question Papers"/>
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search placeholder="Search Question Papers"
                                 :href="route('unvettedquestions.index')"
                                 class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('questions.create')"> New Question Paper</base-button-new>
            </div>
        </template>
        
    </base-card-main>
</template>

<script setup>
import { Head, router, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { store } from "@/store.js";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    questions: Object,
    filters: Object
});

store.pageTitle = 'Question Papers';
store.setBreadCrumb({Papers: null });

</script>
