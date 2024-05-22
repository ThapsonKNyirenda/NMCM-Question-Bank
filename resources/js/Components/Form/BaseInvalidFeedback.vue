<template>
    <div class="invalid-feedback" v-if="hasError">
        {{ errorMessage }}
    </div>
</template>

<script>
export default {
    name: "BaseInvalidFeedback",
    props: {
        inputName: String
    },
    computed: {
        hasError(){
            return this.$store.getters.hasError(this.inputName)
        },
        errorMessage(){
            return this.$store.getters.inputErrorMessage(this.inputName)
        }
    }
}
</script>
