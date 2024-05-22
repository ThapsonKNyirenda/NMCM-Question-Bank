<template>
    <Head title="Profile" />
    <div
        class="alert alert-dismissible border-dotted flex flex-wrap flex-column sm:flex-row flex-sm-row p-5 mb-5 bg-light-success border-success text-green-900"
        v-if="status === 'two-factor-authentication-confirmed'"
    >
        <i class="mr-4 mb-5 sm:mb-0 text-3xl text-green-500 ri-check-line"></i>
        <div class="flex flex-col flex-column pr-0 sm:pr-10">
            <p class="font-bold">Action successful</p>
            <p>Two factor authentication confirmed and enabled successfully.</p>
        </div>
    </div>
    <profile-header :two-factor-enabled="twoFactorEnabled"  active-tab="Security" />
    <base-card-main class="mb-5 lg:mb-10 card-main" header-classes="cursor-pointer border-0" body-classes="p-9">
        <template #header>
            <div class="card-title m-0">
                <h3 class="font-semibold m-0">Sign-in Method</h3>
            </div>
        </template>

        <div class="flex flex-wrap items-center">
            <!--begin::Label-->
            <div class="block">
                <div class="text-lg font-semibold mb-1">Email Address</div>
                <div class="font-medium text-gray-600">{{ $page.props.auth.user.email }}</div>
            </div>
        </div>

        <div class="separator separator-dashed my-6"></div>

        <div class="flex flex-wrap items-center mb-10">
            <div :class="[ resetPassword ? 'hidden' : 'block' ]">
                <div class="text-lg font-semibold mb-1">Password</div>
                <div class="font-semibold text-lg text-gray-600">************</div>
            </div>
            <div class="flex-auto" :class="[ !resetPassword ? 'hidden' : 'block' ]">
                <!--begin::Form-->
                <form class="form needs-validation w-3/4" novalidate="novalidate" @submit.prevent="submit(inertiaSubmit, 'change password?')" >
                    <div class="fv-row mb-4 relative">
                        <label class="form-label text-lg font-semibold mb-3 required">Current Password</label>
                        <input
                            autocomplete="current_password"
                            type="password"
                            class="form-control form-control-lg form-control-solid"
                            name="current_password"
                            id="current_password"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            required
                        />
                    </div>

                    <div class="fv-row mb-4 relative">
                        <label for="new_password" class="form-label text-lg font-semibold mb-3 required">New Password</label>
                        <input
                            autocomplete="new_password"
                            type="password"
                            class="form-control form-control-lg form-control-solid "
                            name="new_password"
                            id="new_password"
                            ref="passwordInput"
                            required
                            v-model="form.password"
                        />
                    </div>

                    <div class="fv-row mb-4 relative">
                        <label for="password_confirmation" class="form-label text-lg font-semibold mb-3 required">Confirm New Password</label>
                        <input
                            autocomplete="password_confirmation"
                            type="password"
                            class="form-control form-control-lg form-control-solid "
                            name="password_confirmation"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            required />
                    </div>

                    <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>

                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary mr-2 px-6">Update Password</button>
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                        <button type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6" @click="resetPassword = false">Cancel</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <div class="ml-auto" v-if="!resetPassword">
                <button type="button" class="btn btn-light btn-active-light-primary" @click.prevent.stop="resetPassword = true">Reset Password</button>
            </div>
        </div>
        <two-factor-authentication :status="status" :two-factor-enabled="twoFactorEnabled" />
    </base-card-main>
    <base-card-main class="mb-5 lg:mb-10 card-main" header-classes="cursor-pointer border-0" body-classes="p-9" v-if="twoFactorEnabled">
        <template #header>
            <div class="card-title m-0">
                <h3 class="font-semibold m-0">You have enabled two factor authentication</h3>
            </div>
        </template>
        <div class="w-3/4 text-muted">
            <p >When two factor authentication is enabled you will be prompted for a secure random token
                during authentication. You may retrieve this token from your phone's Google Authentication application
            </p>
            <p class="my-4">Two factor authentication is now enabled. Scan the following QR code using your phone's authentication application</p>
            <div v-html="qrCodeSvg"></div>
            <p class="my-4">Store these recovery codes in a secure password manager. They can be used to recover access to your account if
                your two factor authentication device is lost
            </p>
            <div class="rounded-xl bg-gray-100i text-lg p-4 font-bold">
                <ul>
                    <li class="py-1" v-for="(code, index) in recoveryCodes" :key="index">{{ code }}</li>
                </ul>
            </div>
            <Link href="/user/two-factor-recovery-codes" class="btn btn-sm btn-outline-dark uppercase my-5" method="post" as="button" type="button" >Regenerate Recovery Codes</Link>
        </div>
    </base-card-main>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from "@/Pages/Profile/Partials/ProfileHeader.vue";
import TwoFactorAuthentication from "@/Pages/Profile/Partials/TwoFactorAuthentication.vue";
import {Head, useForm, usePage, Link} from '@inertiajs/vue3';
import {store} from "@/store.js";
import {submit} from "@/helpers/form_helpers.js";
import { ref} from "vue";

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = "My Profile";
store.setBreadCrumb({ 'My Profile':null, 'Security':null });

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    twoFactorEnabled : {
        type: Boolean
    },
    qrCodeSvg: String,
    recoveryCodes: Object
});

const resetPassword = ref(false);
const user = usePage().props.auth.user;

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const inertiaSubmit = () => {
    form.patch(route('profile-security.update',{ user: user.uuid }), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};


</script>
