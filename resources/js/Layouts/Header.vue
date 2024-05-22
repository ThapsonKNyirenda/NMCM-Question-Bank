<template>
<div class="app-header transition-none flex items-stretch">
    <div class="app-container w-full flex items-stretch justify-between ">
        <div class="md:hidden flex items-center mr-2 ms-n2">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" @click="store.toggleSidebar()">
                <i class="ri-menu-line ri-3x text-3xl text-theme-muted"></i>
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
            <div class="page-title hidden flex-col justify-center flex-wrap mb-5 lg:mb-0 mr-3 lg:flex" >
                <h1 class="page-heading text-gray-900 flex font-semibold flex-col justify-center my-0 text-2xl" >{{ store.pageTitle }}</h1>
                <span class="page-desc text-theme-gray-500 text-fs-7 font-medium pt-1" v-if="store.pageTitle === 'Dashboard' "> Welcome {{ $page.props.auth.user.name }} </span>
                <ol class="breadcrumb breadcrumb-dot text-muted text-lg font-medium" v-else>
                    <li class="breadcrumb-item"><Link :href="route('dashboard')" class="">Home</Link></li>
                    <template v-for="(route, key) in store.breadCrumb">
                        <li class="breadcrumb-item" v-if="route"><Link :href="route" class="">{{ key }}</Link></li>
                        <li class="breadcrumb-item text-muted" v-else>{{ key }}</li>
                    </template>

                </ol>
            </div>
            <!--begin::Navbar-->
                <div class="app-navbar items-center shrink-0">
                    <!--Search start-->
                    <div class="app-navbar-item ml-2 lg:ml-4" >
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
