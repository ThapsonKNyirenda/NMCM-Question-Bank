<template>
    <Head title="Add Category" />
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="card-title flex-col flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Category</h2>
                <div class="text-base fw-semibold text-muted">Edit a category to be assigned to a ticket</div>
            </div>
        </template>
        <form method="POST" :action="route('roles.store')" novalidate class="needs-validation w-3/4 mx-auto" @submit.prevent.stop="submit(inertiaSubmit, 'add the role?')" >
            <base-form-input type="text" label="Category Name" id="name" name="name" v-model="form.name" required />
            <base-form-textarea label="Description" name="description" id="description" rows="5" v-model="form.description" />
            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing" >Edit Category</base-button-submit>
        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {store} from "@/store.js";
import {submit} from "@/helpers/form_helpers.js";
import {useForm, Head} from "@inertiajs/vue3";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    category: Object
});

store.pageTitle = 'Edit Category';
store.setBreadCrumb({ Categories: route('categories.index'), [props.category.name]: null, });

const form = useForm( props.category )

const inertiaSubmit = () => {
    form.patch(route('categories.update', { category: props.category.uuid }));
};

</script>
