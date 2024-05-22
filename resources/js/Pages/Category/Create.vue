<template>
    <Head title="Add Category" />
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="card-title flex-col flex-column">
                <h2 class="mb-1 text-xl font-semibold">Add Category</h2>
                <div class="text-base fw-semibold text-muted">Add a category to be assigned to a ticket</div>
            </div>
        </template>
        <form method="POST" :action="route('categories.store')" novalidate class="needs-validation w-3/4 mx-auto" @submit.prevent.stop="submit(inertiaSubmit, 'add the category?')" >
            <base-form-input type="text" label="Category Name" id="name" name="name" v-model="form.name" required />
            <base-form-textarea label="Description" name="description" id="description" rows="5" v-model="form.description" />
            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing" >Add Category</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {store} from "@/store.js";
import {submit} from "@/helpers/form_helpers.js";
import {useForm, Head} from "@inertiajs/vue3";

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'Add Category';
store.setBreadCrumb({ Categories: route('categories.index'), 'Add category': null });

const form = useForm({
    name: null,
    description:null
});

const inertiaSubmit = () => {
    form.post(route('categories.store'));
};


</script>
