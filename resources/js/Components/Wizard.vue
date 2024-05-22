<template>
  <div class="w-full">
    <div class="wizard wizard-3" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="true">
      <div class="wizard-nav">
        <div class="wizard-steps flex px-8 py-5 px-lg-15 py-lg-7">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Wizard"
}
</script>

