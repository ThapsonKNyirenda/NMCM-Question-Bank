<template>
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-full">
                <wizard>
                    <wizard-step wizard-number="1" >Add Role</wizard-step>
                    <wizard-step data-wizard-state="pending" wizard-number="2" >Role Permissions</wizard-step>
                </wizard>
            </div>
<!--            <div class="card-title flex-col flex-column">-->
<!--                <h2 class="mb-1 text-xl font-semibold">Add Role</h2>-->
<!--                <div class="text-base fw-semibold text-muted">Add a role to be assigned to users</div>-->
<!--            </div>-->
        </template>
<!--        <div class="separator separator-dashed mb-5"></div>-->
        <form method="POST" :action="route('roles.store')" novalidate class="needs-validation w-3/4 mx-auto" @submit.prevent.stop="submit(inertiaSubmit, 'add role?')" >
            <div class="form-group">
                <base-form-input name="name" label="Role Name" required v-model="form.name" />
            </div>
            <base-form-textarea
                name="description"
                label="Description"
                v-model="form.description"
            />
            <base-button-submit type="submit" :form-is-processing="form.processing" >Add Role</base-button-submit>
        </form>
    </base-card-main>

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import {store} from "@/store.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";

defineOptions({ layout: AuthenticatedLayout});
//Breadcrumb
store.pageTitle = 'New Role';
store.setBreadCrumb({ Roles: route('roles.index'), 'New Role' :null });

const form = useForm({
    name: null,
    description:null
});

const inertiaSubmit = () => {
    form.post(route('roles.store'));
};

</script>
