<template>
    <Head title="User Direct Permissions"/>
    <div class="w-full">
        <wizard>
            <wizard-step data-wizard-state="done" :href="route('users.edit', { user:user.uuid })">
                Edit User
            </wizard-step>
            <wizard-step wizard-number="2" data-wizard-state="current" :href="route('users.permissions.create',{user: user.uuid })" >Role Permissions</wizard-step>
        </wizard>
        <wizard-title class="text-center text-xl font-medium"> {{ user.name }}s' Direct Permissions </wizard-title>
        <form class="needs-validation w-full" method="POST" novalidate @submit.prevent="submit(inertiaSubmit, 'assign permissions(s) to user?')" >
            <div class="grid gap-10 grid-cols-4">
                <base-card-main class="card-main card-flush shadow-sm" header-classes="mt-0" v-for="(group, index) in permissions" :key="index">
                    <template #header>
                        <div class="card-title flex-col flex-column">
                            <h2 class="mb-1 text-xl font-semibold" v-text="index"></h2>
                            <div class="text-base fw-semibold text-muted">Enable required permissions</div>
                        </div>
                    </template>
                    <div class="flex flex-col">
                        <div class="block my-2" v-for="permission in group" :key="permission.name">
                            <label class="flex items-center space-x-3" >
                                <template v-if="permissionsViaRoles.includes(permission.name)">
                                    <input type="checkbox" name="permissions[]"  checked  disabled  :value="permission.name" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none" />
                                </template>
                                <template v-else>
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        v-model="form.permissions"
                                        :checked="userPermissions.includes(permission.name)"
                                        :value="permission.name"
                                        class="form-tick appearance-none h-6 w-6  border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none" />
                                </template>

                                <span class="text-gray-900 font-medium" v-text="permission.name"></span>
                            </label>
                        </div>
                    </div>
                </base-card-main>
            </div>
        </form>
    </div>
</template>

<script setup>
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";
import WizardTitle from "@/Components/WizardTitle.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {Head, Link, router} from "@inertiajs/vue3";
import {store} from "@/store.js";
import {submit} from "@/helpers/form_helpers.js";
import {computed, reactive} from "vue";



defineOptions({ layout: AuthenticatedLayout});


const props = defineProps({
    user: Object,
    userRolePermissions: Array,
    permissions: Object,
});

store.pageTitle = "User Direct Permissions";
store.setBreadCrumb({ Users: route('users.index'), [props.user.name] : null, Permissions: null });


const userPermissions = computed(()=> props.user.permissions.map( (permission) => { return permission.name }) );
const permissionsViaRoles = computed ( ()=> props.userRolePermissions.map( (perm) => perm.name ))

const form = reactive({
    permissions: props.user.permissions.map( (permission) => { return permission.name })
});


const inertiaSubmit = () => {
    router.post(route('users.permissions.store', { user: props.user.uuid }), form ,{
        preserveState: false
    });
};

</script>
