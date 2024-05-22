<template>
    <button class="btn btn-sm float-right submit-button mt-5" :disabled="formIsProcessing" >
        <span class="indicator-label" v-if="!formIsProcessing">
            <slot>Submit</slot>
        </span>
        <span v-else>
            Please wait... <span class="spinner-border spinner-border-sm align-middle ml-2"></span>
        </span>
    </button>
</template>

<script setup>
defineProps({
    formIsProcessing: Boolean
})
</script>
