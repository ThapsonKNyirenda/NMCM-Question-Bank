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
});
</script>

<template>
    <div class="flex flex-col items-center min-h-screen pt-2 sm:justify-center sm:pt-0 bg-main-blue">
        <!-- Added max-w-sm and w-full for responsiveness -->
        <div class="w-full max-w-sm overflow-hidden sm:max-w-md" :class="loginCardClasses">
            <slot />
        </div>
        <div class="w-full text-xs text-center text-white-400">Copyright &copy; Nurses and Midwifery Council of Malawi | All rights reserved</div>
    </div>
</template>
