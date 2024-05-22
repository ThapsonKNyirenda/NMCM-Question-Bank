<template>
    <select class="form-select form-select-sm" :class="{ 'is-invalid': 'policy_subscription_id' in $page.props.errors }" v-model="select" :id="id" style="width:100%;">
        <option></option>
    </select>
</template>

<script setup>
import 'select2'
import { computed, defineEmits, ref, onMounted, watch } from 'vue'


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
        data: props.options,
        allowClear: true,
        placeholder: props.placeholder,
        closeOnSelect: true,
        escapeMarkup: function(markup) {
          return markup;
        },
        templateResult: function(data) {
          return data.html;
        },
        templateSelection: function(data) {
          return data.text;
        }
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
