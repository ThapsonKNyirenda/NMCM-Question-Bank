<template>
    <div class="app-navbar-item ml-2 lg:ml-4" >
        <Dropdown width="375" content-classes="py-0">
            <template #trigger>
                <a href="#" class="btn btn-icon btn-primary text-center font-semibold relative">
                    <i class="ri-notification-3-fill"></i> <span class="absolute top-0 left-full translate-middle  badge badge-circle badge-danger">0</span>
                </a>
            </template>
            <template #content>
                <div class="menu menu-sub menu-sub-dropdown menu-column w-[350px] lg:w-[375px] show">
                    <div class="flex flex-col bg-no-repeat rounded-top bg-primary-dark">
                        <h3 class="text-white font-medium px-9 mt-10 mb-6 text-xl">
                            Notifications <span class=" text-sm opacity-75 ps-3">0 reports</span>
                        </h3>
                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch font-medium px-9" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" href="#" @click.stop.prevent role="tab">Alerts</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" href="#" @click.stop.prevent role="tab" tabindex="-1">Notifications</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" href="#" @click.stop.prevent tabindex="-1" role="tab">Logs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show">
                            <div class="scroll-y max-h-96 my-5 px-8">
                            </div>
                            <div class="py-3 text-center border-top">
                                <Link href="#" class="btn btn-color-gray-600 btn-active-color-primary">
                                    View All
                                    <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i>
                                </Link>
                            </div>
                        </div>
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
