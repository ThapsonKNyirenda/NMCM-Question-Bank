<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    loginCardClasses: {
        type: String,
        default: 'sm:max-w-7xl'
    },
    logoClasses: {
        type: String,
        default: 'justify-start'
    }
})
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-main-blue">

        <div
            class="w-full mt-6 px-6 py-4 bg-login-card shadow-md overflow-hidden sm:rounded-lg" :class="loginCardClasses"
        >
            <div class="flex" :class="logoClasses">
                <Link href="/">
                    <ApplicationLogo class="h-20 fill-current text-gray-500" />
                </Link>
            </div>

            <slot />
        </div>
        <div class="w-full text-center text-xs text-gray-400 mt-8">Copyright &copy; Malawi Research and Education Network | All rights reserved</div>
    </div>
</template>
