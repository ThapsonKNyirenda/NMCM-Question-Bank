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
    <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-main-blue">

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden shadow-md bg-login-card sm:rounded-lg" :class="loginCardClasses"
        >
            <div class="flex" :class="logoClasses">
               <span>
                <Link href="/">
                    <ApplicationLogo class="h-20 text-gray-500 fill-current" />
                </Link>
               </span>
               
            </div>

            <slot />
        </div>
        <div class="w-full mt-8 text-xs text-center text-gray-400">Copyright &copy; Nurses and Midwifery Council of Malawi | All rights reserved</div>
    </div>
</template>
