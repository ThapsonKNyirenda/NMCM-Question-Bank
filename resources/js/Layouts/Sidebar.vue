<template>
    <div class="app-sidebar flex-col" :class="{ 'drawer drawer-start':addDrawerClasses, 'w-80 drawer-on': store.showSidebar}" id="app-sidebar">
        <div class="app-sidebar-logo hidden lg:flex justify-between items-center shrink-0 px-8">
            <Link :href="route('dashboard')">
                <ApplicationLogo class="h-12" />
            </Link>
            <SidebarSettingsDropdown />
        </div>
        <div class="separator"></div>
        <div class="app-sidebar-menu hover-scroll-y my-5 mx-3">
            <div class="menu menu-column menu-sub-indention menu-active-bg font-medium">
                <SidebarMenuItem
                    :href="route('dashboard')"
                    :is-active="$page.props.activeMenu === 'Dashboard'">
                    <template #icon><i class="ri-pie-chart-2-fill"></i></template>
                    Dashboard
                </SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('categories.index')"
                    :is-active="$page.props.activeMenu === 'Category'">
                    <template #icon><i class="ri-list-check"></i></template>
                    Categories
                </SidebarMenuItem>
                <!-- <SidebarMenuItem
                    :href="route('categories.index')"
                    :is-active="$page.props.activeMenu === 'Categories'"
                    v-if="canany(['Add ticket categories', 'Update ticket categories', 'View ticket categories', 'Delete ticket categories'])">
                    <template #icon><font-awesome-icon :icon="['fas', 'list']" /></template>
                    Categories
                </SidebarMenuItem> -->

                <SidebarDropdown
                    title="User Management"
                    icon-class="ri-user-settings-fill"
                    v-if="$page.props.auth.can.view_user_management_tab"
                    :is-active="$page.props.activeMenu === 'User Management'"
                >
                    <sidebar-dropdown-menu-item
                        :href="route('roles.index')"
                        :class="{ active: route().current('roles.*')  }"
                        v-if="canany(['Manage roles', 'Assign roles'])"
                    >
                        Roles</sidebar-dropdown-menu-item>

                    <sidebar-dropdown-menu-item
                        :href="route('permissions.index')"
                        :class="{ active: route().current('permissions.*')  }"
                        v-if="can('Assign permissions')"
                    >
                        Permissions</sidebar-dropdown-menu-item>
                    <sidebar-dropdown-menu-item
                        :href="route('users.index')"
                        :class="{ active: route().current('users.*')  }"
                        v-if="can('Manage users')"
                    >
                        Users</sidebar-dropdown-menu-item>

                </SidebarDropdown>
                
            </div>
        </div>
        <div class="app-sidebar-user flex justify-center items-center py-5 px-8">
            <div class="flex mr-5">
                <div class="mr-5">
                    <div class="symbol symbol-40px cursor-pointer">
                        <lozad-image class="h-10 w-auto sidebar-avatar" :src="$page.props.auth.user.photo_url" :data-src="$page.props.auth.user.photo_url" alt="avatar" />
                    </div>
                </div>
                <div class="mr-2">
                    <!--begin::Username-->
                    <Link href="#" class="app-sidebar-username text-gray-800 text-hover-primary text-lg font-medium leading-0">{{ $page.props.auth.user.name }}</Link>
                    <!--end::Username-->

                    <!--begin::Description-->
                    <span class="app-sidebar-deckription text-gray-500 font-medium block text-sm">{{ $page.props.auth.user.email }}</span>
                    <!--end::Description-->
                </div>
            </div>
            <Link :href="route('logout')" method="post" as="button" class="btn btn-icon btn-active-color-primary btn-icon-custom-color text-muted mr-[-1rem]">
                <i class="ri-logout-box-r-line font-medium text-2xl"></i>
            </Link>
        </div>
    </div>
    <teleport to="body">
        <div style="z-index: 105;" class="drawer-overlay" v-if="store.showSidebar" @click="store.removeSidebar()">
        </div>
    </teleport>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {store} from "@/store.js";
import {onMounted, ref} from "vue";
import { Link } from "@inertiajs/vue3";
import SidebarSettingsDropdown from "@/Components/SidebarSettingsDropdown.vue"
import SidebarMenuItem from "@/Components/SidebarMenuItem.vue";
import SidebarDropdown from "@/Components/SidebarDropdown.vue";
import SidebarDropdownMenuItem from "@/Components/Form/SidebarDropdownMenuItem.vue";
import { useHasPermission } from "@/helpers/has_permission.js";
import LozadImage from "@/Components/LozadImage.vue";

const { can, canany } = useHasPermission();

const addDrawerClasses = ref(false);
onMounted(()=>{
    toggleDrawer(window.innerWidth)
    window.addEventListener(
        'resize', () => {
            toggleDrawer(window.innerWidth)
        });
})

const toggleDrawer = (width) => {
    if (width > 920){
        store.removeSidebar()
        addDrawerClasses.value = false
    }else{
        addDrawerClasses.value = true
    }
}
</script>
