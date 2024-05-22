<template>
    <div class="py-4">
        <label>
            <select name="per_page" id="per_page" class="form-select form-select-sm form-select-solid focus:ring-shadow-none" v-model="model">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </label>
    </div>
</template>

<script setup>
const model = defineModel()
</script>
