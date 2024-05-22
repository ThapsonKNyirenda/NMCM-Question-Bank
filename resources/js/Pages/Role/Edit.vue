<template>
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-full">
                <wizard>
                    <wizard-step wizard-number="1" href="#" >Edit Role</wizard-step>
                    <wizard-step data-wizard-state="pending" wizard-number="2" :href="route('roles.permissions.create',{ role:role.uuid })" >Role Permissions</wizard-step>
                </wizard>
            </div>
<!--            <div class="card-title flex-col flex-column">-->
<!--                <h2 class="mb-1 text-xl font-semibold">Edit Role</h2>-->
<!--                <div class="text-base fw-semibold text-muted">Update role details</div>-->
<!--            </div>-->
        </template>
        <wizard-title><h2 class="text-center text-lg font-semibold">Edit Role</h2></wizard-title>
<!--        <div class="separator separator-dashed mb-5"></div>-->
        <form method="POST" novalidate class="needs-validation w-3/4 mx-auto" @submit.prevent.stop="submit(inertiaSubmit, 'edit this role?')" >
            <div class="form-group">
                <base-form-input name="name" label="Role Name" required v-model="form.name" />
            </div>
            <base-form-textarea
                name="description"
                label="Description"
                v-model="form.description"
            />
            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing" >Edit Role</base-button-submit>
        </form>
    </base-card-main>

</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import WizardTitle from "@/Components/WizardTitle.vue";
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";
import { useForm } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import {store} from "@/store.js";


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
