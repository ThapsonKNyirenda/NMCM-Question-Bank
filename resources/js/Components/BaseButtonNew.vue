<template>
    <Link type="submit" class="btn btn-sm" >
        <i class="ri-add-fill"></i> <slot>Add New</slot>
    </Link>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'
</script>
