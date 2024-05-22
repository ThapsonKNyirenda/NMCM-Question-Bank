<template>
    <div class="stepper-item">
        <div class="stepper-wrapper" v-if="href === ''">
            <stepper-item-content :stepper-number="stepperNumber" :title="title" :description="description" />
        </div>
        <Link class="stepper-wrapper" :href="href" v-else>
            <stepper-item-content :stepper-number="stepperNumber" :title="title" :description="description" />
        </Link>
        <div class="stepper-line h-12" v-if="!isFinal"></div>
    </div>
</template>

<script setup>
import StepperItemContent from "@/Components/StepperItemContent.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    stepperNumber: [Number, String],
    title: String,
    description: String,
    isFinal: {
        type: Boolean,
        default: false
    },
    href: {
        type: String,
        default: ''
    }
})

</script>
