<template>
    <base-card-main class="card-flush card-dashed card-main mb-7" header-classes="mt-5" body-classes="mb-0 mt-0 !pt-0 pb-0">
        <template #header>
            <div class="card-title w-1/2 lg:w-8/12 ">
                <div class="flex items-center relative my-1 mr-5 w-full">
                    <slot name="search" />
                </div>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-sm mr-3" :class="[show ? 'btn-primary' : 'btn-light-primary' ]"  @click="show = !show">
                    <i class="ri-filter-2-fill"></i> Filter
                </button>
                <base-button-new class="btn-primary" :href="createUrl" v-if="createUrl !== ''"> New {{ title }} </base-button-new>
            </div>
        </template>
        <Transition
            enter-active-class="transition height .35s eas"
        >
            <div v-if="show" :class="{show: show}">
                <div class="separator separator-dashed mt-9 mb-6"></div>
                <slot />
            </div>
        </Transition>
    </base-card-main>
</template>

<script setup>
import {ref} from "vue";

defineProps({
    createUrl: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: 'Customer'
    }
});

const show = ref( false );

</script>
