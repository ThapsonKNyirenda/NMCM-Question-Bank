<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>
        
        

        <div class="flex items-center justify-center h-screen">
            <div class="w-full max-w-md p-4">
                <div class="flex" :class="logoClasses">
            <span>
            <Link href="/">
                <ApplicationLogo2 class="text-gray-500 fill-current " />
            </Link>
            </span>
            
        </div>
        <br>
        <h1 class="mt-4 mb-6 text-3xl font-bold text-center text-green-600 uppercase">
                    NMCM <br>Question Bank <br> System
                </h1><br>
                
                <form class="w-full needs-validation" @submit.prevent="submit" novalidate>
                    <div>
                        
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

                    <div class="mt-4">
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

                    
                    <div class="flex items-center justify-center mt-10">
                        <PrimaryButton class="w-full text-center rounded-0" style="color: #fff" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                    <div class="flex justify-between mt-6">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="text-sm text-gray-600 ms-2">Remember me</span>
                        </label>
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
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