<template>
    <div class="w-full">
        <div class="quill quill-editor" id="quill-editor"></div>
    </div>
</template>

<script setup>
import Quill from 'quill';
import {onMounted} from "vue";
import Dropdown from "@/Components/Dropdown.vue"

defineProps({
    placeholders: Object
})

const message = defineModel();

const options = {
    modules: {
        toolbar: [
            [{ 'font': [] }],
            [{
            header: [1, 2,3,4, false],
            }],
            ['bold', 'italic', 'underline'],
            // dropdown with defaults from theme
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'align': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
        ],
    },
    theme: 'snow'
};

let quill = null;

onMounted(()=>{
    quill = new Quill('#quill-editor', options);

    quill.root.innerHTML = message.value;

    quill.on('text-change', ()=>{
        message.value = quill.getText() ? quill.root.innerHTML : ''
    })
});

const insert = (placeholder)=> {
    if (quill){
        let range = quill.getSelection();
        if (range){
            quill.insertText(range.index, placeholder, 'normal', true);
        }
    }
}
</script>
