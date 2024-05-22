<template>
    <select class="form-select rounded-none"  :class="{'is-invalid': id in $page.props.errors }" v-model="select" :id="id" style="width:100%; border-radius: 0" >
        <option></option>
        <template v-if="hasField">
          <template v-if="field2">
            <option v-for="option in options" :value="option.id" :key="option.id">{{ option[field][field2] }}</option>
          </template>
          <template v-else>
            <option v-for="option in options" :value="option.id" :key="option.id" >
              {{ option[field] }}<template v-if="field==='registration_number'"> - {{ option.make }} </template>
            </option>
          </template>
        </template>

        <template v-if="!hasField">
            <option v-for="(option, key, index) in options" :value="key" :key="index">{{ option }}</option>
        </template>
    </select>
</template>

<script setup>
import { computed, defineEmits, ref, onMounted, watch } from 'vue'
import * as select2 from "select2";

const props = defineProps({
    id: { type:String, default: 'select' },
    placeholder : { type:String, default: 'Open Select Menu' },
    modelValue: { type: [String, Number], default: '' },
    options:{
        type: [Array, Object],
        default(){
            return {}
        }
    },
    field: { type: String, default: '' }, // The column to display if collection of models is given as options
    field2: { type:String, default: null },
    modalId: { type: String, default: '' }, // The id of the modal to show if the new button has been appended
    canAdd: { type: Boolean, default: false }, // Indicate if the user has authorization to add new model
    buttonText: { type: String, default: 'Add New' }, // The text to display on the button appended,
    dropdownParent:{ type: String, default: 'site-body' }
});

const emit = defineEmits(['selected', 'update:modelValue','cleared']);

const select = ref(props.modelValue);

watch(
    () => props.modelValue,
    (newVal) => {

      let select2Input = $("#" + props.id);

      select.value = newVal;
      setDefaultValue(select2Input);
    }
)


  onMounted(()=>{
      let select2Input = $("#" + props.id);
      select2Input.select2(
          {
              allowClear: true,
              placeholder: props.placeholder,
              closeOnSelect: true,
          }
      ).on('select2:select', function(e){
          select.value = e.target.value;
          emitSelected();
      }).on('select2:clear', function(e){
          select.value = '';
          emitSelected();
          emit('cleared', true);
      });

      setDefaultValue(select2Input);
  });

    const emitSelected = ()=>{
         emit('selected', select.value);
         emit('update:modelValue', select.value);
    }

    const setDefaultValue = (input) =>{
        if (props.modelValue !== ''){
            input.val(select.value);
            input.trigger('change');
        }
    }

    const hasField = computed(() => props.field !=='' );

</script>
