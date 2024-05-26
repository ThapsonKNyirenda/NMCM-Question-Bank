<template>
    <Head title="Edit Email Template" />
    <base-card-main class="card-main flex flex-auto" header-classes="mt-6" body-classes="!pt-10">
        <template #header>
            <div class="card-title flex-col flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Email Template</h2>
                <div class="text-base fw-semibold text-muted">Use templates to send mass emails and workflow alerts.</div>
            </div>
        </template>
        <!-- <div class="separator separator-dashed mb-5"></div> -->
        <form method="POST" novalidate class="needs-validation w-full mx-auto" @submit.stop.prevent="submit(inertiaSubmit, 'edit email template?')" >

            <base-form-input name="name" label="Template Name" v-model="form.name" required />

            <base-form-select
                label="Module"
                placeholder="Choose Module"
                v-model="form.module"
                :options="emailTemplateModules"
                class="form-control-solid required"
                name="module"
                id="module"
                required
            />

            <base-form-input name="email_subject" label="Email Subject" v-model="form.email_subject" required />

            <base-form-input type="email" name="reply_to" label="Reply To" v-model="form.reply_to" />

            <base-form-select
                label="Folder"
                v-model="form.email_template_folder_id"
                :options="emailTemplateFolders"
                class="form-control-solid required"
                name="email_template_folder_id"
                id="email_template_folder_id"
                field="name"
            />

            <label class="form-label required" >Message</label>
            <div class="mandatory-fields">
                <quill-input v-model="form.message" :placeholders="placeholders" />
            </div>

            <div class="flex justify-end">

                <base-button-link type="reset" class="btn btn-sm btn-light mr-3 mt-5" :href="route('email-templates.index')">
                    Cancel
                </base-button-link>
                <base-button-submit class="btn-primary" type="submit" :form-is-processing="form.processing" >Edit Template</base-button-submit>
            </div>

        </form>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Head } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import {store} from "@/store.js";
import QuillInput from "@/Pages/EmailTemplate/Partials/QuillInput.vue"

defineOptions({ layout: AuthenticatedLayout});
const props = defineProps({
    emailTemplateFolders: Array,
    emailTemplateModules: Object,
    emailTemplate: Object,
    placeholders: Object
})

//Breadcrumb
store.pageTitle = 'New Email Template';
store.setBreadCrumb({ 'Email Templates': route('email-templates.index'), 'Edit Email Template': null });

const form = useForm( props.emailTemplate );

const inertiaSubmit = () => {
    form.patch(
        route('email-templates.update',{email_template: props.emailTemplate.uuid}),
        { preserveScroll: false });
};

</script>
