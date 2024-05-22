<template>
<div class="menu-item">
    <Link v-bind="$attrs" class="menu-link" :class="{active: isActive }">
        <span class="menu-icon">
            <slot name="icon" />
        </span>
        <span class="menu-title">
            <slot />
        </span>
    </Link>
</div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    isActive: {
        type: Boolean,
        default: false
    }
})

defineOptions({
    inheritAttrs: false
});

</script>
