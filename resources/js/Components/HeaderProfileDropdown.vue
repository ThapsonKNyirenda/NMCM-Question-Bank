<template>
    <div class="app-navbar-item ml-2 lg:ml-4">
        <Dropdown width="96" content-classes="py-0">
            <template #trigger>
                <a href="#" class="btn btn-custom btn-icon btn-outline btn-icon-gray-700 btn-active-icon-primary overflow-hidden">
                    <lozad-image :src="$page.props.auth.user.photo_url" class="w-full" />
                </a>
            </template>
            <template #content>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color font-medium text-lg py-4">
                    <div class="menu-item px-3">
                        <div class="menu-content flex items-center px-3 ">
                            <div class="symbol mr-5">
                                <lozad-image :src="$page.props.auth.user.photo_url" class="h-14 object-cover "/>
                            </div>
                            <div class="flex flex-col">
                                <div class="font-semibold flex items-center text-xl">
                                    {{ $page.props.auth.user.name }}
                                </div>

                                <a href="#" class="font-semibold text-muted text-hover-primary text-sm">
                                    {{ $page.props.auth.user.email }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="separator my-2"></div>

                    <div class="menu-item px-5">
                        <Link :href="route('profile.edit')" class="menu-link px-5">
                            My Profile
                        </Link>
                    </div>

                    <div class="separator my-2"></div>
                    <div class="menu-item px-5">
                        <Link :href="route('profile-security.edit')" class="menu-link px-5">
                            Account Settings
                        </Link>
                    </div>
                    <div class="menu-item px-5">
                        <Link :href="route('logout')" method="post" as="button" class="menu-link px-5">
                            Sign Out
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
import LozadImage from "@/Components/LozadImage.vue";

</script>
