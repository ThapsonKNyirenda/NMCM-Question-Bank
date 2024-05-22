<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {store} from "@/store.js";
import ProfileHeader from "@/Pages/Profile/Partials/ProfileHeader.vue";


defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = "My Profile";
store.setBreadCrumb({ 'My Profile':null });

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    twoFactorEnabled : {
        type: Boolean
    }
});

const user = usePage().props.auth.user;

</script>

<template>
    <Head title="Profile" />

    <profile-header/>

    <base-card-main class="mb-5 lg:mb-10 card-main" header-classes="cursor-pointer" body-classes="p-9">
        <template #header>
            <div class="card-title m-0">
                <h3 class="font-semibold m-0">Profile Details</h3>
            </div>
            <button href="#" class="btn btn-sm btn-primary ali self-center">Edit Profile</button>
        </template>

        <div class="grid grid-cols-12 gap-10 mb-7">
            <label class="col-span-4 font-semibold text-muted">Full Name</label>
            <div class="col-span-8">
                <span class="font-bold text-lg text-gray-800">{{ $page.props.auth.user.name }}</span>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-10 mb-7">
            <label class="col-span-4 font-semibold text-muted">Organisation</label>
            <div class="col-span-8">
                <span class="font-bold text-lg text-gray-800">Nurses and Midwifery Council of Malawi</span>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-10 mb-7">
            <label class="col-span-4 font-semibold text-muted">Contact Phone</label>
            <div class="col-span-8">
                <span class="font-bold text-lg text-gray-800"></span>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-10 mb-7">
            <label class="col-span-4 font-semibold text-muted">Email Address</label>
            <div class="col-span-8">
                <span class="font-bold text-lg text-gray-800">{{ $page.props.auth.user.email }}</span>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-10 mb-7">
            <label class="col-span-4 font-semibold text-muted">Country</label>
            <div class="col-span-8">
                <span class="font-bold text-lg text-gray-800">Malawi</span>
            </div>
        </div>
    </base-card-main>

    <DeleteUserForm class="" />
</template>
