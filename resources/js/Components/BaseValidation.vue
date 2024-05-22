<template>
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-danger border-dotted text-red-900 border-danger flex flex-wrap flex-column sm:flex-row flex-sm-row p-5 mb-5" v-if="hasErrors">
        <!--begin::Icon-->
        <i class="ri-alert-line mr-4 mb-5 sm:mb-0 text-3xl"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="flex flex-col flex-column pr-0 sm:pr-10">
            <!--begin::Title-->
            <p class="font-bold">Whoops! Something went wrong.</p>
            <!--end::Title-->

            <!--begin::Content-->
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                <li v-for="(error, key) in $page.props.errors" :key="key" v-text="error"></li>
            </ul>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="absolute m-2 sm:m-0 top-0 right-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ri-close-line"></i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
</template>

<script setup>
import {computed, ref} from 'vue'
import { usePage } from '@inertiajs/vue3'
import isEmpty from "lodash/isEmpty";

const show  = ref(true)

const hasErrors = computed(() => {
  return !isEmpty(usePage().props.errors) && true
})
</script>
