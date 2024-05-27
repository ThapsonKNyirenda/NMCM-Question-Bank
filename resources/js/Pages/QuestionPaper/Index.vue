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
import { Head, router, Link } from "@inertiajs/vue3";
import { store } from "@/store.js";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    questions: Object,
    filters: Object
});

store.pageTitle = 'Question Papers Header';
store.setBreadCrumb({ Questions: null });

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(() => filterBy.per_page, (newVal) => {
    router.get(route('questions.index', { search: props.filters.search, ...filterBy }));
});
</script>
