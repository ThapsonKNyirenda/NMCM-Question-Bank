<template>
  <input
      class="form-control form-control-sm border-gray-300 focus:border-gray-800 focus:ring-indigo-800 rounded-0 shadow-sm "
      :class="{'is-invalid': name in $page.props.errors }"
      :type="type"
      :name="name"
      v-model="model"
      v-bind="$attrs" />
</template>

<script setup>
    defineOptions({ inheritAttrs: false });
    const model = defineModel()
    defineProps({
        name: String,
        type: {
            type: String,
            default: 'text'
        }
    });
</script>
