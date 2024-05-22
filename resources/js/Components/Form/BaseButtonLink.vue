<template>
    <Link class="btn btn-sm"><i :class="iconClass" v-if="iconClass"></i> <slot></slot></Link>
</template>

<script setup>
    import { defineProps } from 'vue';
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        iconClass: {
            type: String,
            default: null
        },
    })
</script>

