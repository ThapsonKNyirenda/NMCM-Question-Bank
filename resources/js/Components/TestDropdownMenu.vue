<template>
    <div>
        <DropdownMenu>
            <template #button>
                <button class="btn btn-icon btn-sm btn-light">
                    <i class="ri-more-2-fill"></i>
                </button>
            </template>
            <template #menu>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">Option 1</li>
                    <li class="dropdown-item">Option 2</li>
                </ul>
            </template>
        </DropdownMenu>
    </div>
</template>

<script setup>
import DropdownMenu from '@/Components/DropdownMenu.vue';
</script>

<style scoped>
.btn {
    padding: 0.5rem 1rem;
    cursor: pointer;
}

.btn:hover {
    background-color: #f8f9fa;
}
</style>
