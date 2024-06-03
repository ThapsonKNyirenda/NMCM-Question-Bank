<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                    <!-- Card 1 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Registered Users</h3>
                            <p class="text-white"><span class="font-bold">34</span></p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Available Questions</h3>
                            <p class="text-white"><span class="font-bold">143</span></p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Vetted Questions</h3>
                            <p class="text-white"><span class="font-bold">80</span></p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Unvetted Questions</h3>
                            <p class="text-white"><span class="font-bold">110</span></p>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Question Bank</h3>
                            <p class="text-white"><span class="font-bold">320</span></p>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-green-400 to-blue-600">
                        <div class="p-6">
                            <h3 class="mb-3 text-lg font-semibold text-white">Question Papers</h3>
                            <p class="text-white"><span class="font-bold">20</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
