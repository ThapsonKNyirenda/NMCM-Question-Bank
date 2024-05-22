<template>
    <div class="input-group input-group-sm mb-2">
      <span class="input-group-text" :id="'basic-'+ name" v-if="prepend">{{ prepend }}</span>
      <input type="text" class="form-control form-control-sm" :class="{ 'is-invalid': name in $page.props.errors }" :name="name" :id="name" v-bind="$attrs" :value="modelValue" @input="$emit('update:modelValue',  $event.target.value)">
      <span class="input-group-text" :id="'basic-'+ name" v-if="append">{{ append }}</span>
    </div>
</template>

<script>
export default {
    name: "InputGroup",
    props: {
      name: String,
      type: {
            type: String,
            default: 'prepend'
      },
      parentClass: {
        type: String,
        default: 'mb-3'
      },
      modelValue:{
        type:[String, Number],
        default: ''
      },
      prepend: {
        type: String,
        default:null
      },
      append: {
        type: String,
        default:null
      }
    }
}
</script>
