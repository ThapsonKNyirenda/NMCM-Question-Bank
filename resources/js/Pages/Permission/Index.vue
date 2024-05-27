<template>
    <Head title="Permissions List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-1/2 card-title">
                <div class="relative flex items-center w-full my-1 mr-5">
                    <base-search placeholder="Search permissions"
                                 :href="route('permissions.index')"
                                 :search="filters.search"
                                 class="w-full"
                    />
                </div>
            </div>
            <div class="card-toolbar">
               <!-- <base-button-new class="btn-light-primary" :href="route('permissions.create')"> New Permission </base-button-new> -->
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
                        <th>Assigned To</th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                    <tr v-for="(permission, key, index) in permissions.data" :key="permission.uuid">
                        <td v-text="key + 1"></td>
                        <td>
                            {{ permission.name }}
                        </td>
                        <td v-text="permission.description"></td>
                        <td>
                            <template v-for="(role, index)  in permission.roles" :key="role.uuid">
                                <Link :href="route('roles.edit', { role:role.uuid })" class="mr-3 badge" :class="[ `badge-${getBadgeColorClass(index)}` ]" >{{ role.name  }}</Link>
                            </template>
                        </td>
                        <td class="text-right" style="min-width: 170px">
                            <base-button-link
                                :href="route('permissions.roles.create',{ permission: permission.uuid })"
                                title="roles"
                                class="p-2 mr-2 btn-outline-primary"
                                icon-class="ri-user-received-fill"
                            >Roles</base-button-link>
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
                    <base-pagination :paginator="permissions" :key="permissions.total" />
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
import {getBadgeColorClass} from "@/helpers/form_helpers.js";

defineOptions({ layout: AuthenticatedLayout});

store.pageTitle = 'Permissions Lists';
store.setBreadCrumb({ Permissions: null });

const props = defineProps({
    permissions: Object,
    filters:  Object,
});

const filterBy = reactive({ per_page: props.filters.per_page ?? 10 });

watch(()=> filterBy.per_page, (newVal)=>{
    router.get(route('permissions.index',{ search: props.filters.search, ...filterBy }))
} )

</script>
