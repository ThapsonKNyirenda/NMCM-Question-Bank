<template>
    <Head title="Permission's Roles" />
    <base-card-main class="card-main card-flush " >
        <template #header>
            <div class="card-title flex-col flex-column">
                <h2 class="mb-1 text-xl font-semibold">{{ permission.name }}</h2>
                <div class="text-base fw-semibold text-muted">{{ permission.roles_count }} roles assigned to the permission</div>
            </div>
        </template>
    <form class="needs-validation w-5/6 mx-auto" method="POST" novalidate @submit.prevent="submit(inertiaSubmit, 'assign role(s) to permission?')" >
        <div class="grid grid-cols-4 gap-10">
            <div v-for="(role, key, index) in roles" :key="role.id">

                <label class="flex items-center space-x-3">
                    <input type="checkbox" :checked="role.name in permissionRoles " name="roles[]" v-model="form.roles" :value="role.name" :id="strSlug(role.name)" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                    <span class="text-gray-900 font-medium ml-3" :for="strSlug(role.name)">{{ role.name }}</span>
                </label>
            </div>
        </div>

        <base-button-submit class="btn-primary" type="submit" :form-is-processing="form.processing" >Assign Roles</base-button-submit>
    </form>
    </base-card-main>
</template>

<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {store} from "@/store.js";
import {reactive, computed} from "vue";
import {submit, strSlug } from "@/helpers/form_helpers.js";


defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    permission: Object,
    roles: Array
})

store.pageTitle = "Permission's Roles";
store.setBreadCrumb({
    Permissions: route('permissions.index'),
    [props.permission.name] : null,
    Roles:null
});

const permissionRoles = computed(()=> props.permission.roles.map( (role) => { return role.name }) );

const form = reactive({
    roles: props.permission.roles.map((role)=>{return role.name})
});

const inertiaSubmit = () => {
    router.post(route('permissions.roles.store',{ permission: props.permission.uuid }), form);
};

</script>
