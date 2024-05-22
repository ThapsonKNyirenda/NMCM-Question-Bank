<template>
    <select class="form-select form-select-sm" :class="{ 'select2-hidden-accessible is-invalid': name in $page.props.errors }" v-model="select" :id="id" style="width:100%;">
        <option></option>
    </select>
</template>

<script setup>
import * as select2 from "select2";
import {defineEmits, ref, onMounted, watch} from 'vue'

const props = defineProps({
    id: { type:String, default: 'select' },
    name: String,
    placeholder : { type:String, default: 'Open Select Menu' },
    modelValue: { type: [String, Number], default: '' },
    field: { type: String, default: '' }, // The column to display if collection of models is given as options
    field2: { type:String, default: null },
    url: String,
    modalId: { type: String, default: '' }, // The id of the modal to show if the new button has been appended
    canAdd: { type: Boolean, default: false }, // Indicate if the user has authorization to add new model
    buttonText: { type: String, default: 'Add New' }, // The text to display on the button appended,
    dropdownParent:{ type: String, default: 'site-body' },
    prepopulateUrl: { type: String, default: '' }
});

const emit = defineEmits(['selected', 'update:modelValue','cleared', 'employeeSelected']);

const select = ref(props.modelValue);

watch(
    () => props.modelValue,
    (newVal) => {
      select.value = newVal;
    }
);

const formatResult = (result)=>{

  if(result.loading){
    return result.text;
  }

  /*if(props.field === 'programStudent' && result )
  {
    const student = result.student
    const $container = $(
        "<div class='select2_result_student' >" +
          "<div class='select2_result_student_name fw-bold'><i class='fa-solid fa-user-graduate me-2'></i></div>" +
          "<div class='select2_result_student_id'><span class='me-2 fw-bold'>ID:</span></div>" +
          "<div class='select2_result_student_program'></div>" +
          "<div class='select2_result_student_type fw-semibold'></div>" +
        "</div>"
    )
    $container.find(".select2_result_student_name").append(student.full_name);
    $container.find(".select2_result_student_id").append(result.student_number);
    $container.find(".select2_result_student_type").text(result.student_type.type + ' - ' + result.campus.name);

    return $container;
  }*/

  return result[props.field]
}

const formatSelectionResult = (result)=>{
  if (result.loading) {
    return props.placeholder;
  }

  if (result.text) {
    return result.text;
  }

  /*if(props.field === 'programStudent' && result ){
    return result.student.full_name
  }*/

  return result[props.field] || props.placeholder;
}

  onMounted(()=>{
    let select2Input = $("#" + props.id);
    let flg = 0;
    select2Input.select2(
        {
          allowClear: true,
          closeOnSelect: true,
          dropdownParent: $('#' + props.dropdownParent),
          ajax: {
            delay: 200,
            data: function (params) {
              var query = {
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
            cache: true
          },
          placeholder: props.placeholder,
          minimumInputLength: 1,
          templateResult: formatResult,
          templateSelection: formatSelectionResult
        }
    ).on('select2:select', function(e){
        select.value = e.target.value;
        emitSelected();
        if(props.name === 'employee_id'){
          emit('employeeSelected', e.params.data)
        }
    }).on('select2:clear', function(e){
        select.value = '';
        emitSelected();
        emit('cleared', true);
    }).on('select2:open', function(){
      flg++;
      if (flg === 1 && self.modalId !== '' && self.canAdd) {
        let $this_html = `<button type="button" data-bs-toggle="modal" data-bs-target="#${self.modalId}" class="btn btn-sm btn-success w-100"><i class="fas fa-plus"></i> ${self.buttonText}</button>`;
        $(".select2-results:not(:has(a))").append(`<div class='select2-results__option text-center header-bg-grey'>${$this_html}</div>`);
      }
    });

    $(document).on('select2:open', (e) => {
      const selectId = e.target.id

      $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function (
          key,
          value,
      ){
        value.focus();
      })
    });

    setDefaultValue(select2Input);
  });

  const emitSelected = ()=>{
       emit('selected', select.value);
       emit('update:modelValue', select.value);
  }

const prePopulate = ()=>{
    let input = $("#" + props.id);
    axios.get(props.prepopulateUrl)
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
  if (props.modelValue  && props.modelValue !== ''){
    prePopulate(input)
  }
}
</script>
