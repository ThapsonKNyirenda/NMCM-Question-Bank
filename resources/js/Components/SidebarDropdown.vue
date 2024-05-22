<template>
    <div class="menu-item here menu-accordion" :class="{'here hover show': show}" >
        <span class="menu-link" role="button" v-on:click="toggle()">
            <span class="menu-icon">
                <i :class="[iconClass]"></i>
            </span>
            <span class="menu-title" v-text="title"></span>
            <span class="menu-arrow"></span>
        </span>

        <div class="menu-sub menu-sub-accordion" :class="{'show': show}" v-if="show">
            <slot />
        </div>

    </div>
</template>

<script setup>

import {ref, watch} from "vue";

const props = defineProps({
    isActive:{
        type: Boolean,
        default: false,
    },
    title: String,
    iconClass: String,
});

const show = ref(props.isActive);

const toggle = () => { show.value = !show.value }

watch( ()=> props.isActive, (newVal) => {
    show.value = newVal;
})
</script>
