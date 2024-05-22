<template>
    <nav aria-label="breadcrumb" class="block">
        <ol class="breadcrumb flex">
            <base-breadcrumb-link :href="route('dashboard')">Home</base-breadcrumb-link>
            <slot></slot>
        </ol>
    </nav>
</template>
<script setup>
</script>
