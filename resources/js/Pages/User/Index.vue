<template>
    <Head title="Users List" />
    <base-card-main class="shadow-sm card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="card-title w-3/4">
                <div class="w-full grid grid-cols-5 gap-5">
                    <div class="col-span-3">
                        <div class="flex items-center relative my-1 mr-5 w-full">
                            <base-search placeholder="Search Users"
                                         :href="route('users.index')"
                                         :search="filters.search"
                                         class="w-full"
                            />
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <base-select class=" py-4" :options="roles" id="filter" field="name" placeholder="Filter By role" v-model="filterBy.role_id" />
                    </div>
                    <div class="col-span-1 flex items-center ">
                        <base-select class="py-4" :options="status" id="filter2" placeholder="Filter By Status" v-model="filterBy.status" />
                    </div>
                </div>

            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-light-primary" :href="route('users.create')"> New User </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 mb-0 dataTable no-footer gy-3">
                    <thead>
                        <tr>
                            <th>C.No</th>
                            <th>Name</th>
                            <th>Email/Username</th>
                            <th>Roles</th>
                            <th>Last Login</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                    <tr v-for="(user,index) in users.data" :key="user.id">
                        <td>
                            <div class="symbol symbol-circle overflow-hidden me-3" v-if="user.photo">
                                <div class="symbol-label">
                                    <lozad-image class="w-100 h-auto " :src="user.photo_url" alt="user avatar" />
                                </div>
                            </div>
                            <a class="btn btn-sm btn-teal h-12 w-12 rounded-pill" :class="[getBtnColorClass(index + 1)]" v-text="strAcronym( user.name )" v-else></a>
                        </td>
                        <td>
                            {{ user.name }}
                            <base-badge-mark :class="[ user.status ? 'border-success' : 'border-danger' ]">
                                <span class="badge badge-light-success" v-if="user.status">active</span>
                                <span class="badge badge-light-danger" v-else>in active</span>
                            </base-badge-mark>
                        </td>
                        <td v-text="user.email"></td>
                        <td>
                            <template v-for="(role, index)  in user.roles" :key="role.uuid">
                                <Link :href="route('roles.edit', { role:role.uuid })" class="badge mr-3" :class="[ `badge-${getBadgeColorClass(index)}` ]" >{{ role.name  }}</Link>
                            </template>
                        </td>
                        <td v-text="user.last_login_after"></td>
                        <td class="text-right">
                            <base-button-link
                                :href="route('users.permissions.create', { user: user.uuid })"
                                class="btn-outline-success p-2 pl-2 px-3 mr-1"
                                title="Permissions"
                                icon-class="fas fa-clipboard-list"
                            ><font-awesome-icon  class="text-lg" icon="fa-solid fa-list-check" /></base-button-link>
                            <base-button-link
                                :href="route('users.roles.create', { user: user.uuid })"
                                title="Roles"
                                class="btn-outline-warning p-2 pl-2 px-3"
                            >
                                <font-awesome-icon  class="text-lg" icon="fas fa-user-tag" /> </base-button-link>
                            <base-button-link
                                :href="route('users.edit', [user.uuid])"
                                title="Edit"
                                class="btn-outline-primary ml-1 p-1 pl-2"
                                icon-class="ri-pencil-fill text-lg"
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
                <div class="col-span-4 flex items-center justify-center md:justify-end">
                    <base-pagination :paginator="users" :key="users.total" />
                </div>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import {Head, router, Link} from "@inertiajs/vue3";
import {store} from "@/store.js";
import {strAcronym, getBtnColorClass, getBadgeColorClass} from "@/helpers/form_helpers.js";
import {reactive, watch, ref} from "vue";
import LozadImage from "@/Components/LozadImage.vue";

defineOptions({ layout: AuthenticatedLayout});

store.pageTitle = 'Users Lists';
store.setBreadCrumb({ Users: null });

const status = ref({ 1: 'Active', 0: 'In-active' });

const props = defineProps({
    users: Object,
    roles: Array,
    filters:  Object,
});

const filterBy = reactive({
    status: props.filters.status,
    role_id: props.filters.role_id,
    per_page: props.filters.per_page ?? 10
});
watch([()=>filterBy.role_id, ()=>filterBy.status, ()=>filterBy.per_page], (roleId, status, perPage)=>{
    router.get(
        route('users.index'), { search: props.filters.search, ...filterBy },
        {
            preserveState: true,
            replace:  true
        }
    )
})

const filterByStatus = (status)=>{
    router.get(
        route('users.index'),
        { status:status },
        {
            preserveState: true,
            replace:  true
        }
    );
}

</script>
