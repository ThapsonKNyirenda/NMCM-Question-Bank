<template>
  <li class="breadcrumb-item flex">
    <Link v-bind="$attrs" class="link-primary"><slot></slot></Link>
  </li>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3'
    import { useAttrs } from "vue";

    const attr = useAttrs();

    defineOptions({
        inheritAttrs: false
    })
</script>
