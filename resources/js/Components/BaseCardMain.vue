<template>
    <div class="card">
        <div class="card-header" :class="headerClasses">
            <slot name="header" />
        </div>
        <div class="card-body" :class="bodyClasses">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
    import { defineProps } from 'vue';
    const props = defineProps({
        title:String,
        bodyClasses: {
            type: String,
            default: 'pt-0'
        },
        headerClasses: {
            type: String,
            default: 'pt-6'
        }
    })
</script>
