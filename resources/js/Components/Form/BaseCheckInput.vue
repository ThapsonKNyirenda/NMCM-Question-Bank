<template>
    <label class="form-check flex items-center space-x-3"  v-bind="$attrs">
        <input type="checkbox"
               v-model="model"
               :name="name"
               class="form-check-input appearance-none h-9 w-9 mt-3 focus:outline-none focus:ring-0 focus:ring-offset-0 "
               :class="{'is-invalid': name in $page.props.errors }"
        >
        <span class="text-gray-900 font-medium mt-2"><slot /></span>
    </label>
</template>

<script setup>
    defineOptions({ inheritAttrs: false });
    const model = defineModel()
    defineProps({
        name: String
    });
</script>
