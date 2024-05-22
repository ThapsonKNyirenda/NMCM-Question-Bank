<template>
    <div class="ml-5">
        <Dropdown content-classes="py-0 bg-white" width="52" >
            <template #trigger>
                <button class="btn btn-icon btn-icon-custom-color btn-active-color-primary w-auto px-0">
                    <i class="ri-settings-4-fill text-2xl mr-[-.25rem]"></i>
                </button>
            </template>

            <template #content>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary font-medium py-3" data-kt-menu="true" wfd-invisible="true" style="">
                    <!--begin::Heading-->
                    <div class="menu-item px-3">
                        <div class="menu-content text-muted font-bold pb-2 px-3  uppercase">
                            Payments
                        </div>
                    </div>
                    <!--end::Heading-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            Create Invoice
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link flex-stack px-3">
                            Create Payment
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            Generate Bill
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-1">
                        <a href="#" class="menu-link px-3">
                            Settings
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
            </template>
        </Dropdown>
    </div>
</template>

<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import { Link } from "@inertiajs/vue3";
</script>
