<template>
    <div class="stepper-icon !w-11 !h-11">
        <i class="ri-check-line stepper-check !text-xl"></i>
        <span class="stepper-number" v-text="stepperNumber"></span>
    </div>
    <div class="stepper-label">
        <h3 class="stepper-title" v-text="title"></h3>
        <div class="stepper-desc font-medium" v-text="description"></div>
    </div>
</template>

<script setup>
defineProps({
    stepperNumber: [Number, String],
    title: String,
    description: String,
})

</script>
