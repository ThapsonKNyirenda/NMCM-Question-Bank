<template>
    <Head title="Roles List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search placeholder="Search Roles"
                                 :href="route('roles.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('roles.create')"> New Role </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-row-dashed fs-6 dataTable no-footer gy-3">
                    <thead>
                    <tr class="font-semibold text-left text-gray-500 uppercase fs-7 ">
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th></th>
                        <th class="w-32 text-right"></th>
                    </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                    <tr v-for="(role, key, index) in roles.data" :key="role.id">
                        <td v-text="key + 1"></td>
                        <td v-text="role.name"></td>
                        <td v-text="role.description"></td>
                        <td>
                            <Link class="badge badge-light-success" :href="route('roles.permissions.create', { role: role.uuid })" >{{ role.permissions_count }} permissions</Link>
                        </td>
                        <td class="text-right">
                            <base-button-link
                                :href="route('roles.permissions.create', { role: role.uuid })"
                                title="Permissions"
                                class="p-2 px-3 pl-2 btn-warning"
                            >
                                <font-awesome-icon  class="text-lg" icon="fa-solid fa-list-check" /> </base-button-link>
                            <base-button-link
                                :href="route('roles.edit', [role.uuid])"
                                title="Edit"
                                class="p-1 pl-2 ml-1 btn-primary"
                                icon-class="text-lg ri-pencil-fill"
                            ></base-button-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-5 gap-4">
                <div class="flex items-center justify-center md:justify-start">
                    <base-select-page v-model="filterBy.per_page" />
                </div>
                <div class="flex items-center justify-center col-span-4 md:justify-end">
                    <base-pagination :paginator="roles" :key="roles.total" />
                </div>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import {Head, router, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {store} from "@/store.js";
import {reactive, watch} from "vue";

defineOptions({ layout: AuthenticatedLayout});

store.pageTitle = 'Roles Lists';
store.setBreadCrumb({ Roles: null });

const props = defineProps({
    roles: Object,
    filters:  Object,
});

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(()=> filterBy.per_page, (newVal)=>{
    router.get(route('roles.index',{ search: props.filters.search, ...filterBy }))
} )

</script>
