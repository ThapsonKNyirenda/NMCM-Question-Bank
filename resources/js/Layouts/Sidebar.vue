<template>
    <div class="flex-col app-sidebar" :class="{ 'drawer drawer-start':addDrawerClasses, 'w-80 drawer-on': store.showSidebar}" id="app-sidebar">
        <div class="items-center justify-between hidden px-8 app-sidebar-logo lg:flex shrink-0">
            <Link :href="route('dashboard')">
                <ApplicationLogo class="h-20" />
            </Link>
        </div>
        <div class="separator"></div>
        <div class="mx-3 my-5 app-sidebar-menu hover-scroll-y">
            <div class="font-medium menu menu-column menu-sub-indention menu-active-bg">
                <SidebarMenuItem
                    :href="route('dashboard')"
                    :is-active="$page.props.activeMenu === 'Dashboard'">
                    <template #icon><i class="ri-pie-chart-2-fill"></i></template>
                    Dashboard
                </SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('questions.index')"
                    :is-active="$page.props.activeMenu === 'Questions'">
                    <template #icon><i class="ri-question-mark"></i> </template>
                    Questions
                </SidebarMenuItem>

                <SidebarMenuItem
    :href="route('unvettedquestions.index')"
    :is-active="$page.props.activeMenu === 'Unvetted Questions'">
    <template #icon> <i class="ri-flag-fill"></i></template>
    Unvetted Questions
</SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('vettedquestions.index')"
                    :is-active="$page.props.activeMenu === 'Vetted Questions'">
                    <template #icon><i class="ri-checkbox-fill"></i></template>
                    Vetted Questions
                </SidebarMenuItem>

                  <SidebarMenuItem
                    :href="route('questionbank.index')"
                    :is-active="$page.props.activeMenu === 'Questions Bank'">
                    <template #icon> <i class="ri-folder-2-fill"></i></template>
                    Questions Bank
                </SidebarMenuItem>

                <!--<SidebarMenuItem
                    :href="route('categories.index')"
                    :is-active="$page.props.activeMenu === 'Category'">
                    <template #icon><i class="ri-list-check"></i></template>
                    Categories
                </SidebarMenuItem>-->
                <!-- <SidebarMenuItem
                    :href="route('categories.index')"
                    :is-active="$page.props.activeMenu === 'Categories'"
                    v-if="canany(['Add ticket categories', 'Update ticket categories', 'View ticket categories', 'Delete ticket categories'])">
                    <template #icon><font-awesome-icon :icon="['fas', 'list']" /></template>
                    Categories
                </SidebarMenuItem> -->

                <!-- <SidebarDropdown
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

                </SidebarDropdown> -->

            </div>
        </div>
        <div class="flex items-center justify-center px-8 py-5 app-sidebar-user">
            <div class="flex mr-5">
                <div class="mr-5">
                    <div class="cursor-pointer symbol symbol-40px">
                        <lozad-image class="w-auto h-10 sidebar-avatar" :src="$page.props.auth.user.photo_url" :data-src="$page.props.auth.user.photo_url" alt="avatar" />
                    </div>
                </div>
                <div class="mr-2">
                    <!--begin::Username-->
                    <Link href="#" class="text-lg font-medium text-gray-800 app-sidebar-username text-hover-primary leading-0">{{ $page.props.auth.user.name }}</Link>
                    <!--end::Username-->

                    <!--begin::Description-->
                    <span class="block text-sm font-medium text-gray-500 app-sidebar-deckription">{{ $page.props.auth.user.email }}</span>
                    <!--end::Description-->
                </div>
            </div>
            <Link :href="route('logout')" method="post" as="button" class="btn btn-icon btn-active-color-primary btn-icon-custom-color text-muted mr-[-1rem]">
                <i class="text-2xl font-medium ri-logout-box-r-line"></i>
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
