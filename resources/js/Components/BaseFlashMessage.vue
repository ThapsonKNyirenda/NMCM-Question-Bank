<template>
    <div class="alert alert-dismissible border-dotted flex flex-wrap flex-column sm:flex-row flex-sm-row p-5 mb-5" :class="alert.mainClasses" role="alert" v-if="hasFlash">
        <i class="mr-4 mb-5 sm:mb-0 text-3xl" :class="[alert.icon, alert.textClass,]"></i>

        <!--begin::Wrapper-->
        <div class="flex flex-col flex-column pr-0 sm:pr-10">
            <!--begin::Title-->
            <p class="font-bold" v-text="alert.title"></p>
            <!--end::Title-->

            <!--begin::Content-->
            <p v-text="alert.message"></p>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const hasFlash = computed(() => {
  return usePage().props.flash.warning !== null ||
      usePage().props.flash.error !== null ||
      usePage().props.flash.success !== null ||
      usePage().props.flash.info !== null
});

const alert = computed(() => {
  let flash = usePage().props.flash
  if (flash.success) {
    return {
        mainClasses: ['bg-light-success', 'border-success', 'text-green-900'],
      textClass: 'text-green-500',
      icon: 'ri-check-line',
      title: 'Action Successful!',
      message: flash.success
    }
  }

  if (flash.error) {
    return {
        mainClasses: ['bg-light-danger', 'border-danger', 'text-red-900'],
      textClass: 'text-red-500',
      icon: 'ri-alert-line',
      title: 'Whoops! Something went wrong.',
      message: flash.error
    }
  }

  if (flash.warning) {
    return {
        mainClasses: ['bg-light-warning', 'border-warning', 'text-orange-900'],
      textClass: 'text-orange-500',
      icon: 'ri-error-warning-fill',
      title: 'Be Warned! Something went wrong.',
      message: flash.warning
    }
  }
  return {
    mainClasses: ['bg-light-primary', 'border-primary', 'text-green-900'],
    textClass: 'text-blue-500',
    icon: 'ri-information-line',
    title: 'Info!',
    message: flash.info
  }
})
</script>
