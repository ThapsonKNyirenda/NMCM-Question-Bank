<template>
    <div class="form-group mb-5">
        <label :for="id" class="form-label" :class="{ required: $attrs.hasOwnProperty('required') }">{{ label }}</label>
        <base-select :model-value="modelValue" @selected="$emit('update:modelValue', $event)" v-bind="$attrs" :id="id" />
    </div>
</template>

<script lang="ts">
    export default {
        name: "BaseFormSelect",
        inheritAttrs: false,
        props: {
            modelValue:[String, Number],
            id: String,
            label: String,
        },

        emits: [ 'update:modelValue' ],
    }
</script>
