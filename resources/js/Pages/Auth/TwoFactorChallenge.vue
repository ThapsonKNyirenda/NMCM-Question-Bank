<template>
    <GuestLayout login-card-classes="sm:max-w-xl" logo-classes="justify-center">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="w-full mt-10" >
            <h1 class="font-semibold mb-6 text-login-green text-2xl text-center" >Two Factor Verification</h1>
            <p class="w-3/4 mx-auto pb-4 mb-5">
                Using an authenticator app like
                <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>,
                <a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">Microsoft Authenticator</a>,
                <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                <a href="https://support.1password.com/one-time-passwords/" target="_blank">1Password</a>,
                get your 6 digit code and enter below.
            </p>
            <form class="needs-validation w-3/4 mx-auto mb-5" @submit.prevent="submit" novalidate>
                <div>
                    <InputLabel class="required" for="code" value="Verification Code" />

                    <TextInput
                        id="code"
                        type="code"
                        class="mt-1 block w-full form-control form-control-sm"
                        v-model="form.code"
                        autofocus
                        autocomplete="code"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.code" />
                </div>

                <div class="separator separator-dashed my-6" ></div>

<!--                <div class="mt-4">-->
<!--                    <InputLabel for="password" value="Recovery Code" />-->

<!--                    <TextInput-->
<!--                        id="recovery_code"-->
<!--                        type="recovery_code"-->
<!--                        class="mt-1 block w-full form-control form-control-sm"-->
<!--                        v-model="form.recovery_code"-->
<!--                        autocomplete="recovery-code"-->
<!--                    />-->

<!--                    <InputError class="mt-2" :message="form.errors.recovery_code" />-->
<!--                </div>-->

                <div class="flex items-center justify-center mt-10">
                    <PrimaryButton class="text-center w-full rounded-0 btn-lg  h-12" style="color: #fff" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
                <div class="flex justify-end mt-6">
                    <Link
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Recover your account?
                    </Link>
                </div>
            </form>

        </div>
    </GuestLayout>
</template>

<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { validateForm } from "@/helpers/form_helpers.js";
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    code: '',
    recovery_code: '',
});

const submit = () => {
    if (validateForm('needs-validation')) {
        form.post('/two-factor-challenge', {});
    }
};

</script>
