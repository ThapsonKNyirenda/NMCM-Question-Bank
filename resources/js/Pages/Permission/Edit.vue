<template>
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="card-title flex-col flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Role</h2>
                <div class="text-base fw-semibold text-muted">Update role details</div>
            </div>
        </template>
        <div class="separator separator-dashed mb-5"></div>
        <form method="POST" novalidate class="needs-validation w-3/4 mx-auto" @submit.prevent.stop="submit(inertiaSubmit, 'edit this role?')" >
            <div class="form-group">
                <base-form-input name="name" label="Role Name" required v-model="form.name" />
            </div>
            <base-form-textarea
                name="description"
                label="Description"
                v-model="form.description"
            />
            <base-button-submit type="submit" :form-is-processing="form.processing" >Edit Role</base-button-submit>
        </form>
    </base-card-main>

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import {store} from "@/store.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineOptions({ layout: AuthenticatedLayout});
const props = defineProps({ role:Object })

//Breadcrumb
store.pageTitle = 'Edit Role';
store.setBreadCrumb({ Roles: route('roles.index'), [props.role.name] :null });

const form = useForm(props.role);

const inertiaSubmit = () => {
    form.patch(route('roles.update', { role: props.role.uuid }));
};

</script>
