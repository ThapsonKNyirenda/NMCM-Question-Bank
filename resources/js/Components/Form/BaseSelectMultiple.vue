<template>
    <select class="form-select form-select-sm max-w-full" :class="{ 'is-invalid': name in $page.props.errors }" :id="id" multiple="multiple">
        <option></option>
        <template v-if="hasField">
          <template v-if="field2">
            <option v-for="option in options" :value="option.id" :key="option.id">{{ option[field][field2] }}</option>
          </template>
          <template v-else>
            <option v-for="option in options" :value="option.id" :key="option.id" >
              {{ option[field] }}
            </option>
          </template>
        </template>

        <template v-if="!hasField">
            <option v-for="(option, key, index) in options" :value="key" :key="index" v-if="isNaN(options)">{{ option }}</option>
            <option v-for="(option, key, index) in options" :value="option" :key="option" v-else>{{ option }}</option>
        </template>
    </select>
</template>

<script setup>
import {computed, defineEmits, ref, onMounted, watch} from 'vue'
import * as select2 from "select2";

const props = defineProps({
    id: { type:String, default: 'select' },
    name: String,
    placeholder : { type:String, default: 'Open Select Menu' },
    modelValue: { type: Array, default: [] },
    options:{
        type: [Array, Object,Number],
        default(){
            return {}
        }
    },
    field: { type: String, default: '' }, // The column to display if collection of models is given as options
    field2: { type:String, default: null },
    modalId: { type: String, default: '' }, // The id of the modal to show if the new button has been appended
    canAdd: { type: Boolean, default: false }, // Indicate if the user has authorization to add new model
    buttonText: { type: String, default: 'Add New' }, // The text to display on the button appended,
    dropdownParent:{ type: String, default: 'needs-validation' }
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
    let flg = 0;
    select2Input.select2(
        {
          allowClear: true,
          placeholder: props.placeholder,
          closeOnSelect: true,
          dropdownParent: $('.' + props.dropdownParent)
        }
    ).on('select2:select', function(e){
        select.value.push(e.params.data.id);
        emitSelected();
    }).on('select2:clear', function(e){
        select.value = [];
        emitSelected();
        emit('cleared', true);
    }).on("select2:unselect", function(e) {
      select.value = select.value.filter((element) => element != e.params.data.id );
      emitSelected();
    }).on('select2:open', function(){
      flg++;
      if (flg === 1 && props.modalId !== '' && props.canAdd) {
        let $this_html = `<button type="button" data-bs-toggle="modal" data-bs-target="#${props.modalId}" class="btn btn-sm btn-success w-100"><i class="fas fa-plus"></i> ${props.buttonText}</button>`;
        $(".select2-results:not(:has(a))").append(`<div class='select2-results__option text-center header-bg-grey'>${$this_html}</div>`);
      }
    });

    setDefaultValue(select2Input);
  });

  const emitSelected = ()=>{
       emit('selected', select.value);
       emit('update:modelValue', select.value);
  }

  const setDefaultValue = (input) =>{
      console.log('called');
      if (props.modelValue !== ''){
          input.val(select.value);
          input.trigger('change');
      }
  }

  const hasField = computed(() => props.field !=='' );

</script>
