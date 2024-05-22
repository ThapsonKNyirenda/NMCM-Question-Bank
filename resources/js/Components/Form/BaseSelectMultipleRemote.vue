<template>
    <select class="form-select" :class="{ 'is-invalid': name in $page.props.errors }" v-model="select" :id="id" style="width:100%; height: 100%;" multiple="multiple" size="30" >
        <option></option>
    </select>
</template>

<script setup>
import {defineEmits, ref, onMounted, watch} from 'vue'
import * as select2 from "select2";

const props = defineProps({
    id: { type:String, default: 'select' },
    name: String,
    placeholder : { type:String, default: 'Open Select Menu' },
    modelValue: { type: Array, default: [] },
    field: { type: String, default: '' }, // The column to display if collection of models is given as options
    field2: { type:String, default: null },
    url: String,
    modalId: { type: String, default: '' }, // The id of the modal to show if the new button has been appended
    canAdd: { type: Boolean, default: false }, // Indicate if the user has authorization to add new model
    buttonText: { type: String, default: 'Add New' }, // The text to display on the button appended,
    dropdownParent:{ type: String, default: 'site-body' },
    cache:{ type:Boolean, default:true },
    prepopulateUrl: { type: String, default: '' }
});

const emit = defineEmits(['selected', 'update:modelValue','cleared']);

const select = ref(props.modelValue);

watch(
    () => props.modelValue,
    (newVal) => {
      select.value = newVal;
      $("#" + props.id).val(newVal).trigger('change.select2');
    }
);

const formatResult = (result)=>{

  if(result.loading){
    return result.text;
  }

  if (result.text) {
    return result.text;
  }

  return result[props.field]
}

const formatSelectionResult = (result)=>{
  if (result.loading) {
    return props.placeholder;
  }

  if (result.text) {
    return result.text;
  }

 /* if(props.field === 'programStudent' && result ){
    return result.student.full_name
  }*/

  return result[props.field];
}

  onMounted(()=>{
    let select2Input = $("#" + props.id);
    select2Input.select2(
        {
          allowClear: true,
          closeOnSelect: true,
          dropdownParent: $('#' + props.dropdownParent),
          ajax: {
            delay: 200,
            data: function (params) {
              let query = {
                search: params.term,
                page: params.page || 1
              }
              return query;
            },
            transport: function (params, success, failure) {
              axios.get(props.url, { params : params.data } )
                  .then(function(response){
                    success(response);
                  })
                  .catch(function(error){
                    console.log(error);
                  });
            },
            processResults: function (response, params) {
              params.page = params.page || 1;
              return {
                results: response.data.data,
                pagination: {
                  more: (params.page * 10) < response.data.meta.total
                }
              };
            },
            cache: props.cache
          },
          placeholder: props.placeholder,
          minimumInputLength: 1,
          templateResult: formatResult,
          templateSelection: formatSelectionResult
        }
    ).on('select2:select', function(e){
        select.value.push(e.params.data.id);
        $("#" + props.id).val(select.value).trigger('change.select2')
        emitSelected();
    }).on('select2:clear', function(e){
        select.value = [];
        $("#" + props.id).val(select.value).trigger('change.select2')
        emitSelected();
        emit('cleared', true);
    }).on("select2:unselect", function(e) {
      select.value = select.value.filter( (element) => element != e.params.data.id );
      $("#" + props.id).val(select.value).trigger('change.select2')
      emitSelected();
    }).on('select2:open', function(){

    });

    setDefaultValue(select2Input);
  });

  const emitSelected = ()=>{
       emit('selected', select.value);
       emit('update:modelValue', select.value);
  }

const prePopulate = ()=>{
    let input = $("#" + props.id);
    axios.get(props.prepopulateUrl, {
      params: {
        ids: props.modelValue
      }
    })
      .then(function(response){
        let option = new Option(response.data.data[props.field], response.data.data.id, true, true);
        input.append(option).trigger('change');
        //manually trigger the `select2:select` event
        input.trigger({
          type: 'select2:select',
          params: {
            data: response.data.data
          }
        });
      })
      .catch(function(error){
        console.log(error);
      });
}

const setDefaultValue = (input) =>{
  if (props.modelValue  && props.modelValue.length > 0 ){
    prePopulate(input)
  }else{
    $("#" + props.id).val(props.modelValue).trigger('change.select2');
  }
}


</script>
