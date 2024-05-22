<template>
    <div class="menu-item">
        <Link class="menu-link" v-bind="$attrs">
            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
            <span class="menu-title font-medium"><slot /></span>
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineOptions({
    inheritAttrs: false
})
</script>

