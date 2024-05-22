<template>
    <div class="form-group mb-5">
        <label :for="name" class="form-label" :class="{ required: $attrs.hasOwnProperty('required') }">{{ label }}</label>
        <base-input :placeholder="label" :name="name" v-model="model" v-bind="$attrs" />
    </div>
</template>
<script setup>

defineOptions({ inheritAttrs: false })

const model = defineModel();

defineProps({
    label: String,
    name: String,
})
</script>
