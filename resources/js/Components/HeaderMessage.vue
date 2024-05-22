<template>
    <div class="app-navbar-item ml-2 lg:ml-4">
        <Slideleft >
            <template #trigger>
                <a href="#" class="btn btn-custom btn-outline btn-icon btn-icon-gray-700 btn-active-icon-primary">
                    <i class="ri-message-2-line text-3xl"></i>
                </a>
            </template>
        </Slideleft>
    </div>
</template>

<script setup>

import Slideleft from "@/Components/Slideleft.vue";
</script>
