<template>
<Head title="Email Template List" />
    <header-email-template />
    <base-card-main class="card-main card-flush card-dashed" header-classes="mt-6" >
        <template #header>
            <div class="card-title w-3/4">
                <div class="w-full grid grid-cols-5 gap-5">
                    <div class="col-span-4">
                        <div class="flex items-center relative my-1 mr-5 w-full">
                            <base-search placeholder="Search email templates"
                                         :href="route('email-templates.index')"
                                         :search="filters.search"
                                         class="w-full"
                            />
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <base-select class=" py-4" :options="emailTemplateFolders" field="name" id="filter" placeholder="Filter By Folder" v-model="filterBy.email_template_folder_id" />
                    </div>
                </div>

            </div>
            <div class="card-toolbar">
                <base-button-new class="btn-sm btn-light-primary" :href="route('email-templates.create')"> New Email Template </base-button-new>
            </div>
        </template>
        <div class="relative">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 mb-0 dataTable no-footer gy-3">
                    <thead>
                    <tr>
                        <th>C.No</th>
                        <th>Name</th>
                        <th>Email Subject</th>
                        <th>Module</th>
                        <th>Folder</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="=font-medium text-gray-600" >
                    <tr v-for="(emailTemplate,index) in emailTemplates.data" :key="emailTemplate.uuid">
                        <td v-text="index +1"></td>
                        <td>
                            {{ emailTemplate.name }}
                        </td>
                        <td v-text="emailTemplate.email_subject"></td>
                        <td>
                            {{ emailTemplate.module }}
                        </td>
                        <td>{{ emailTemplate.email_template_folder.name }}</td>
                        <td class="text-right">
<!--                            <base-button-link-->
<!--                                :href="route('users.permissions.create', { user: user.uuid })"-->
<!--                                class="btn-outline-success p-2 pl-2 px-3 mr-1"-->
<!--                                title="Permissions"-->
<!--                                icon-class="fas fa-clipboard-list"-->
<!--                            ><font-awesome-icon  class="text-lg" icon="fa-solid fa-list-check" /></base-button-link>-->
<!--                            <base-button-link-->
<!--                                :href="route('users.roles.create', { user: user.uuid })"-->
<!--                                title="Roles"-->
<!--                                class="btn-outline-warning p-2 pl-2 px-3"-->
<!--                            >-->
<!--                                <font-awesome-icon  class="text-lg" icon="fas fa-user-tag" /> </base-button-link>-->
                            <base-button-link
                                :href="route('email-templates.edit', [emailTemplate.uuid])"
                                title="Edit"
                                class="btn-outline-primary btn-sm ml-1 p-1 pl-2 "
                                icon-class="ri-pencil-fill text-lg"
                            ></base-button-link>
                            <base-button-delete
                                :action = "route('email-templates.destroy', { email_template: emailTemplate.uuid })"
                                class="btn-danger btn-sm p-1 pl-2 py-2"
                            ></base-button-delete>
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
                    <base-pagination :paginator="emailTemplates" :key="emailTemplates.total" />
                </div>
            </div>
        </div>
    </base-card-main>
</template>

<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {store} from "@/store.js";
import HeaderEmailTemplate from "@/Pages/EmailTemplate/Partials/HeaderEmailTemplate.vue"
import {reactive, watch} from "vue";

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    emailTemplates: Object,
    emailTemplateModules: Object,
    emailTemplateFolders: Array,
    filters:  Object,
});

//Breadcrumb
store.pageTitle = 'All Email Templates';
store.setBreadCrumb({ 'Email Templates': null });

const filterBy = reactive({
    email_template_folder_id: props.filters.email_template_folder_id,
    per_page: props.filters.per_page ?? 10
});

watch([()=>filterBy.email_template_folder_id, ()=>filterBy.per_page], (folderId, perPage)=>{
    router.get(
        route('email-templates.index'), { search: props.filters.search, ...filterBy },
        {
            preserveState: true,
            replace:  true
        }
    )
})

</script>
