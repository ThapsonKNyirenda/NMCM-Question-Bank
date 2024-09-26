<template>
    <GuestLayout>
        <Head title="Log in" />

        <!-- Remove full-height and adjust padding for form container -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="flex items-center justify-center min-h-screen bg-main-blue">
            <!-- Increase form width with sm:max-w-xl -->
            <div class="w-full max-w-lg p-6 bg-white rounded-md shadow-md sm:max-w-xl">

                <!-- Application Logo -->
                <div class="flex justify-center" :class="logoClasses">
                    <span>
                        <Link href="/">
                            <ApplicationLogo2 class="text-gray-500 fill-current" />
                        </Link>
                    </span>
                </div>

                <!-- Title with reduced top margin -->
                <h1 class="mt-2 mb-4 text-2xl font-bold text-center text-green-600 uppercase">
                    NMCM <br> Question Bank <br> System
                </h1>

                <!-- Form -->
                <form class="w-full needs-validation" @submit.prevent="submit" novalidate>
                    <!-- Email Field -->
                    <div class="mb-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="block w-full mt-1 form-control"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="block w-full mt-1 form-control"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Login Button -->
                    <!-- Reduce margin above the login button -->
                    <div class="flex items-center justify-center mt-4">
                        <PrimaryButton class="w-full h-10 text-center text-white rounded-md" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>

                    <!-- Remember Me and Forgot Password Links -->
                    <div class="flex justify-between mt-4 text-sm">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2">Remember me</span>
                        </label>
                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-gray-600 underline hover:text-gray-900">
                            Forgot your password?
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { validateForm } from "@/helpers/form_helpers.js";
import ApplicationLogo2 from '@/Components/ApplicationLogo2.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    loginCardClasses: {
        type: String,
        default: 'sm:max-w-7xl'
    },
    logoClasses: {
        type: String,
        default: 'justify-center'
    }
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    if (validateForm('needs-validation')) {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    }
};
</script>
