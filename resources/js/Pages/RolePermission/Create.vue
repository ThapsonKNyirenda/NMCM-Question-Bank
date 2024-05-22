<template>
<Head title="Role's Permissions" />
    <div class="w-full">
        <wizard>
            <wizard-step data-wizard-state="done" :href="route('roles.edit', { role:role.uuid })">
                Edit Role
            </wizard-step>
            <wizard-step wizard-number="2" data-wizard-state="current" href="#" >Role Permissions</wizard-step>
        </wizard>
        <wizard-title class="text-center text-xl font-medium"> {{ role.name }}s' Permissions </wizard-title>
    </div>
    <form method="POST" novalidate class="needs-validation w-full" @submit.prevent.stop="submit(inertiaSubmit, 'assign permissions(s) to role?')" >
        <div class="grid gap-10 grid-cols-4">
            <base-card-main class="card-main card-flush shadow-sm" header-classes="mt-0" v-for="(group, index) in permissionGroups" :key="index">
                <template #header>
                    <div class="card-title flex-col flex-column">
                        <h2 class="mb-1 text-xl font-semibold" v-text="index"></h2>
                        <div class="text-base fw-semibold text-muted">Enable required permissions</div>
                    </div>
                </template>
                <div class="flex flex-col">
                    <div class="block my-2" v-for="permission in group" :key="permission.name">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" :checked="rolePermissions.includes(permission.name)" v-model="form.permissions" :value="permission.name" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium" v-text="permission.name"></span>
                        </label>
                    </div>
                </div>
            </base-card-main>
        </div>
        <base-button-submit class="btn-primary" type="submit" :form-is-processing="form.processing" >Assign Permissions</base-button-submit>
    </form>

</template>

<script setup>
import {Head, router} from "@inertiajs/vue3";
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";
import WizardTitle from "@/Components/WizardTitle.vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {store,} from "@/store.js";
import { computed, reactive } from "vue";
import { submit } from "@/helpers/form_helpers.js";


defineOptions({ layout: AuthenticatedLayout })

const props = defineProps({
    role: Object,
    permissionGroups : Object
})

store.pageTitle = "Permission's Roles";
store.setBreadCrumb({
    Roles: route('roles.index'),
    [props.role.name] : null,
    Permissions:null
});

const rolePermissions = computed(()=> props.role.permissions.map( (permission) => { return permission.name }) );

const form = reactive({
    permissions: props.role.permissions.map( (permission) => { return permission.name })
});

const inertiaSubmit = () => {
    router.post( route('roles.permissions.store', { role: props.role.uuid } ), form,{ preserveState: false });
};

</script>
