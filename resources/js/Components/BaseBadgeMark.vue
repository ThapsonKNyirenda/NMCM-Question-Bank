<template>
  <div class="block">
    <span class="badge badge-mark mr-1" v-bind="$attrs" ></span>
    <span class="text-muted font-size-sm"><slot></slot></span>
  </div>
</template>

<script>
export default {
  name: "BaseBadgeMark",
  inheritAttrs:false
}
</script>

<style scoped>

</style>