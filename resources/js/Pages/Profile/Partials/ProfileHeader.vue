<template>
    <base-card-main  class="card-main card-dashed card-flush shadow-sm mb-5 lg:mb-10" header-classes="!p-0 !min-h-0" body-classes="!pt-9 !pb-0" preserve-state>
        <div class="flex flex-wrap sm:flex-nowrap mb-6">
            <div class="mr-7 mb-4" >
                <div class="symbol symbol-100px symbol-fixed relative w-48 h-48">
                    <img class="!max-w-48 !max-h-56 w-full h-full object-cover" :src="$page.props.auth.user.photo_url" alt="user avatar">
                    <div class="absolute translate-middle bottom-0 left-full mb-6 bg-success rounded-full border !border-4 border-body h-7 w-7"></div>
                </div>
            </div>
            <div class="grow" >
                <div class="flex justify-between items-start flex-wrap mb-2">
                    <div class="flex flex-col">
                        <div class="flex items-center mb-2" >
                            <a href="#" class="text-gray-900 text-hover-primary text-2xl font-semibold me-1" >{{ $page.props.auth.user.name }}</a>
                            <a href="#">
                                <i class="ri-verified-badge-fill text-primary text-2xl ml-2"></i>
                            </a>

                        </div>
                        <div class="flex flex-wrap font-medium text-lg mb-4 pr-2">
                            <a href="#" class="flex items-center text-gray-500 text-hover-primary mr-5 mb-2" >
                                <i class="ri-user-location-fill text-muted mr-1"></i>
                                <span v-for="(role, index) in $page.props.auth.roles" :key="role">
                                    <template v-if="index !== 0"> &nbsp; | </template>
                                    {{ role }} </span>
                            </a>
                            <a href="#" class="flex items-center text-gray-500 text-hover-primary mr-5 mb-2" >
                                <i class="ri-mail-fill text-muted mr-1"></i>
                                {{ $page.props.auth.user.email }}
                            </a>
                        </div>
                    </div>
                    <div class="flex my-4">

                        <div class="mr-0">
                            <dropdown>
                                <template #trigger>
                                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ri-more-fill text-xl text-muted "></i>
                                    </button>
                                </template>
                            </dropdown>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between items-center ">
                    <div class="flex flex-col grow pr-8" >
                        <div class="flex flex-wrap">

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="separator"></div>

        <div class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent text-xl font-semibold">
            <li class="nav-item mt-2" v-for="(route, index) in tabs">
                <Link class="nav-link text-active-primary ml-0 !mr-10 !py-5" :class="{ active: activeTab === index }" :href="route">
                    {{ index }}
                </Link>
            </li>
        </div>
    </base-card-main>
</template>

<script setup>

defineProps({
    activeTab: {
        type: String,
        default: 'Overview'
    },
    twoFactorEnabled : {
        type: Boolean
    }
});

const tabs = {
    Overview : route('profile.edit'),
    Security: route('profile-security.edit')
}

import {Link, router} from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import CountUpNumber from "@/Components/CountUpNumber.vue"

</script>
