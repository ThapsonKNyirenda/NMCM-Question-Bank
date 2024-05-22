<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from "@/Pages/Profile/Partials/ProfileHeader.vue";
import {Head, Link, useForm, useRemember} from '@inertiajs/vue3';
import { submit } from '@/helpers/form_helpers.js'
import {store} from "@/store.js";

defineOptions({ layout: AuthenticatedLayout });

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

store.pageTitle = "My Signature";
store.setBreadCrumb({ 'My Profile':null, 'My Signature' : null  });

const form = useForm({});

const deleteSignature = () => {
    form.delete(route('profile.signature.destroy'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <Head title="Update Signature" />

    <profile-header :two-factor-enabled="twoFactorEnabled"  active-tab="Signature" />
    <base-card-main class="mb-5 lg:mb-10 card-main" header-classes="cursor-pointer border-0" body-classes="p-9">
        <template #header>
            <div class="card-title m-0">
                <h3 class="font-semibold m-0">My Signature</h3>
            </div>
        </template>

        <div class="py-12 pt-5">
            <div class="sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <section class="w-full">
                        <div class="w-full">
                            <div class="text-center" v-if="!$page.props.auth.user.signature">
                                <h3 class="text-xl text-danger font-semibold">No signature Found !</h3>
                                <p class="w-3/4 mx-auto text-muted font-medium text-lg py-5">You have not set up your signature. Kindly note that some of the action will require your signature to be completed</p>
                            </div>
                            <div v-else>
                                <img height="200" :src="$page.props.auth.user.signature" />
                            </div>
                            <form @submit.prevent="submit(deleteSignature, 'delete signature?')" class="mt-6 space-y-6 needs-validation" novalidate>
                                <div class="card-footer flex justify-between mt-3">
                                    <Link :href="route('profile.edit')" type="button" class="btn btn-sm btn-outline-secondary py-2 m-0">
                                        <i class="ri-arrow-go-back-line"></i> Cancel
                                    </Link>
                                    <Link :href="route('profile.signature.edit')" type="button" class="btn btn-sm btn-primary float-right" v-if="!$page.props.auth.user.signature">
                                        <i class="ri-add-fill"></i> Add signature
                                    </Link>
                                    <div v-else>
                                        <Link :href="route('profile.signature.edit')" class="btn btn-sm btn-primary float-right ml-2 ">
                                            <font-awesome-icon :icon="['fas', 'signature']" />  Change signature</Link>
                                        <button type="submit" class="btn btn-sm btn-danger float-right ml-2"><i class="ri-delete-bin-6-line"></i> Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </base-card-main>

</template>
