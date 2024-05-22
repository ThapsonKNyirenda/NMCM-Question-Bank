<template>
    <div class="app-navbar-item ml-2 lg:ml-4">
        <Dropdown width="96" content-classes="py-0">
            <template #trigger>
                <a href="#" class="btn btn-custom btn-icon btn-outline btn-icon-gray-700 btn-active-icon-primary">
                    <i class="ri-dashboard-horizontal-fill text-3xl"></i>
                </a>
            </template>
            <template #content>
                <div class="menu menu-sub menu-sub-dropdown flex-col">
                    <div class="flex flex-col justify-center items-center bg-no-repeat py-10 px-9 bg-primary-dark rounded-top">
                        <h3 class="text-white font-medium text-xl mb-3">
                            Quick Links
                        </h3>
                        <span class="badge bg-primary text-inverse-primary py-2 px-3">0 pending tasks</span>
                    </div>
                    <div class="grid grid-cols-2 gap-0">
                        <div>
                            <Link href="#" class="flex flex-col justify-center items-center h-full p-6 bg-hover-light  border-end border-bottom">
                                <i class="ri-coupon-3-line mb-2 text-primary lg:text-5xl"></i>
                                <span class="text-lg font-medium text-gray-800 mb-0">Tickets</span>
                                <span class="text-sm text-gray-500">Help Desk</span>
                            </Link>
                        </div>
                        <div>
                            <Link href="#" class="flex flex-col justify-center items-center h-full p-6 bg-hover-light border-bottom">
                                <i class="ri-admin-fill mb-2 text-primary lg:text-5xl"></i>
                                <span class="text-lg font-medium text-gray-800 mb-0">Administration</span>
                                <span class="text-sm text-gray-500">Console</span>
                            </Link>
                        </div>
                        <div>
                            <Link href="#" class="flex flex-col justify-center items-center h-full p-6 bg-hover-light  border-end border-bottom">
                                <i class="ri-list-check-3 mb-2 text-primary lg:text-5xl"></i>
                                <span class="text-lg font-medium text-gray-800 mb-0">Activities</span>
                                <span class="text-sm text-gray-500">Pending Tasks</span>
                            </Link>
                        </div>

                        <div>
                            <Link href="#" class="flex flex-col justify-center items-center h-full p-6 bg-hover-light  border-bottom">
                                <i class=" ri-shopping-cart-line mb-2 text-primary lg:text-5xl"></i>
                                <span class="text-lg font-medium text-gray-800 mb-0">Customers</span>
                                <span class="text-sm text-gray-500">Customers List</span>
                            </Link>
                        </div>
                    </div>
                    <div class="py-2 text-center border-top">
                        <Link href="#" class="btn btn-color-gray-600 btn-active-color-primary text-sm">
                            View All
                            <i class="ri-arrow-right-line text-sm"></i>
                        </Link>
                    </div>
                </div>
            </template>
        </Dropdown>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";

</script>
