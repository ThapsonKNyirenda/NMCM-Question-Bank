<template>
  <div class="input-group input-group-sm mb-3">
    <input
        class="form-control form-control-sm"
        :class="{ 'is-invalid': name in $page.props.errors }"
        type="date"
        :id="id"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
        v-bind="$attrs"
    />
    <span class="input-group-text" :id="'basic-'+ name" ><i class="fas fa-calendar"></i></span>
  </div>
</template>
<script setup>
import flatpickr from "flatpickr";
import {onMounted, watch} from "vue"

const props = defineProps({
  name:String,
  id: { type: String,  default: "phone"},
  modelValue: { type: String, default: "" },
  altFormat: {
    type:String,
    default: "F j, Y"
  },
  format: {
    type:String,
    default: "Y-m-d"
  }
});

const emits = defineEmits(['update:modelValue'])

onMounted(() =>  {
  flatpickr("#" + props.id, {
    altInput: true,
    altFormat: props.altFormat,
    allowInput: true,
    dateFormat: props.format,
    defaultDate: props.modelValue
  });
});

watch(
    () => props.modelValue,
    (newVal) => {
      flatpickr("#" + props.id, {
        altInput: true,
        altFormat: "F j, Y",
        allowInput: true,
        dateFormat: "Y-m-d",
        defaultDate: props.modelValue
      });
    }
)

</script>

<script>
export default {
  inheritAttrs: false
};
</script>
