<template>
    <div class="search_box block relative">
        <span class="ic_lens flex items-center" id="employee_search">
            <i class="fa-solid fa-magnifying-glass mx-auto"></i>
        </span>
        <select class="form-select form-select-sm" v-model="select" style="width:100%;" id="search-employees" >
            <option></option>
        </select>
    </div>
</template>

<script setup lang="ts">
import {defineEmits, ref, onMounted, watch} from 'vue'
import "select2"

const props = defineProps({
    url:String
})

const emit = defineEmits(['selected', 'update:modelValue','cleared']);

const select = ref('');

const formatResult = (result)=>{

    if(result.loading){
        return result.text;
    }

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
    // $container.find(".select2_result_student_program").text(result.program.code);
    $container.find(".select2_result_student_type").text(result.student_type.type + ' - ' + result.campus.name);

    return $container;

}

const formatSelectionResult = (result)=>{
    if (result.loading) {
        return result.text;
    }

    if (result.text) {
        return result.text;
    }

    return result.student.full_name
}

onMounted(()=>{
    let select2Input = $("#search-employees");
    let flg = 0;
    select2Input.select2(
        {
            allowClear: true,
            closeOnSelect: true,
            dropdownParent: $('#top-navigation'),
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
            placeholder: 'Search for employees',
            minimumInputLength: 1,
            templateResult: formatResult,
            templateSelection: formatSelectionResult
        }
    ).on('select2:select', function(e){
        select.value = e.target.value;
        emitSelected();
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

});

const emitSelected = ()=>{
    emit('selected', select.value);
    emit('update:modelValue', select.value);
}

</script>
