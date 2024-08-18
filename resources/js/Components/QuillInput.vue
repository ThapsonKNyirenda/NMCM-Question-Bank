<template>
    <div class="w-full">
        <div class="quill quill-editor" id="quill-editor"></div>
    </div>
</template>

<script setup>
import Quill from 'quill';
import { ref, watch, onMounted, defineEmits, defineProps } from 'vue';

const props = defineProps({
    modelValue: String,
    placeholder: String,
    disabled: Boolean
});

const emit = defineEmits(['update:modelValue']);

const options = {
    modules: {
        toolbar: [
            [{ 'font': [] }],
            [{ 'header': [1, 2, 3, 4, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'align': [] }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
        ],
    },
    theme: 'snow'
};

let quill = null;

onMounted(() => {
    quill = new Quill('#quill-editor', options);
    
    // Initialize with the value from v-model
    quill.root.innerHTML = props.modelValue;

    // Update v-model when the editor content changes
    quill.on('text-change', () => {
        emit('update:modelValue', quill.root.innerHTML);
    });
});

// Watch for changes in modelValue prop to update the editor
watch(() => props.modelValue, (newValue) => {
    if (quill) {
        quill.root.innerHTML = newValue;
    }
});

// Optional: method to insert placeholder text
const insert = (placeholder) => {
    if (quill) {
        const range = quill.getSelection();
        if (range) {
            quill.insertText(range.index, placeholder, 'normal', true);
        }
    }
};
</script>
