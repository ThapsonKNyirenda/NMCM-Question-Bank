<template>
<div class="flex items-stretch transition-none app-header">
    <div class="flex items-stretch justify-between w-full app-container ">
        <div class="flex items-center mr-2 md:hidden ms-n2">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" @click="store.toggleSidebar()">
                <i class="text-3xl ri-menu-line ri-3x text-theme-muted"></i>
            </div>
        </div>
        <!--Mobile Logo Start-->
        <div class="flex items-center grow lg:grow-0">
            <a :href="route('dashboard')" class="lg:hidden">
                <ApplicationLogo class="h-11" />
            </a>
        </div>
        <!-- Mobile Long End  -->
        <!--begin::Header wrapper-->
        <div class="flex items-stretch justify-between lg:grow">
            <div class="flex-col flex-wrap justify-center hidden mb-5 mr-3 page-title lg:mb-0 lg:flex" >
                <h1 class="flex flex-col justify-center my-0 text-2xl font-semibold text-gray-900 page-heading" >{{ store.pageTitle }}</h1>
                <span class="pt-1 font-medium page-desc text-theme-gray-500 text-fs-7" v-if="store.pageTitle === 'Dashboard' "> Welcome {{ $page.props.auth.user.name }} </span>
                <ol class="text-lg font-medium breadcrumb breadcrumb-dot text-muted" v-else>
                    <li class="breadcrumb-item"><Link :href="route('dashboard')" class="">Dashboard</Link></li>
                    <template v-for="(route, key) in store.breadCrumb">
                        <li class="breadcrumb-item" v-if="route"><Link :href="route" class="">{{ key }}</Link></li>
                        <li class="breadcrumb-item text-muted" v-else>{{ key }}</li>
                    </template>

                </ol>
            </div>
            <!--begin::Navbar-->
                <div class="items-center app-navbar shrink-0">
                    <!--Search start-->
                    <div class="ml-2 app-navbar-item lg:ml-4" >
                        <Search class="header-search" />
                    </div>
                    <!-- Searh End -->
                    <!--begin::Notifications-->
                    <!-- <HeaderQuickLink /> -->
                    <!-- <HeaderMessage /> -->
                    <!--end: Notifications -->
                    <HeaderNotification />
                    <HeaderProfileDropdown />
                </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->

    </div>
</div>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Search from "@/Components/Search.vue";
import HeaderQuickLink from "@/Components/HeaderQuickLink.vue";
import HeaderMessage from "@/Components/HeaderMessage.vue";
import HeaderNotification from "@/Components/HeaderNotification.vue";
import HeaderProfileDropdown from "@/Components/HeaderProfileDropdown.vue";
import {store} from "@/store.js";
import { Link } from "@inertiajs/vue3";


</script>
