<template>
    <img >
</template>

<script setup>
import lozad from 'lozad';
import {onMounted} from "vue";

onMounted(()=>{
    const el = document.querySelector('img');
    const observer = lozad(el, {
        loaded: function(el) {
            el.classList.add('loaded');
        }
    }); // passing a `NodeList` (e.g. `document.querySelectorAll()`) is also valid
    observer.observe();
})
</script>
