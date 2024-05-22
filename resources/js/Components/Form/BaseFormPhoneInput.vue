<template>
  <div class="form-group mb-5">
    <label :for="id" class="form-label" v-text="label" :class="{ required: $attrs.hasOwnProperty('required') }"></label>
    <base-input-phone name="phone_number"  :id="id" placeholder="Phone Number" :model-value="modelValue" v-bind="$attrs" @update:model-value="$emit('update:modelValue',  $event)"></base-input-phone>
  </div>
</template>

<script setup>
defineOptions({
    inheritAttrs: false
})

const props = defineProps({
  modelValue:String,
  label:String,
  id: String
});

const emit =  defineEmits(['update:modelValue']);
</script>
