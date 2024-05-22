<template>
    <div class="form-group mb-5">
        <label :for="name" class="form-label" :class="{ required: $attrs.hasOwnProperty('required') }" >{{ label }}</label>
        <base-textarea :name="name" v-model="model" v-bind="$attrs" @update:model-value="$emit('update:modelValue',  $event)" :placeholder="label" />
    </div>
</template>

<script setup>

const model = defineModel();

defineOptions({ inheritAttrs: false});

defineProps({
    label: String,
    name: String
})
</script>
