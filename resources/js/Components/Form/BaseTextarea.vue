<template>
    <textarea :name="name" :id="name" class="form-control form-control-sm rounded-0 shadow-sm" :class="{'is-invalid': name in $page.props.errors }" v-model="model"></textarea>
</template>
<script setup>
    import { defineProps, defineEmits } from 'vue'
    const model = defineModel();

    const props = defineProps({
        name: String,
    });
</script>
