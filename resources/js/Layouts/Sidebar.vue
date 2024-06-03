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
                    :is-active="$page.props.activeMenu === 'Questions'"
                    v-if="can('Manage questions')"
                    >
                    <template #icon><i class="ri-question-mark"></i> </template>
                    Questions
                </SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('unvettedquestions.index')"
                    :is-active="$page.props.activeMenu === 'Unvetted Questions'"
                    v-if="can('Manage unvetted questions')"
                    >
                    <template #icon> <i class="ri-flag-fill"></i></template>
                    Unvetted Questions
                </SidebarMenuItem>

                <!-- <SidebarMenuItem
                    :href="route('vettedquestions.index')"
                    :is-active="$page.props.activeMenu === 'Vetted Questions'"
                    v-if="can('Manage vetted questions')"
                    >
                    <template #icon><i class="ri-checkbox-fill"></i></template>
                    Vetted Questions
                </SidebarMenuItem> -->

                  <SidebarMenuItem
                    :href="route('questionbank.index')"
                    :is-active="$page.props.activeMenu === 'Questions Bank'"
                    v-if="can('Manage question bank')"
                    >
                    <template #icon> <i class="ri-folder-2-fill"></i></template>
                    Question Bank
                </SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('questionpapers.index')"
                    :is-active="$page.props.activeMenu === 'Question Papers'"
                    v-if="can('Manage question papers')"
                    >
                    <template #icon><i class="ri-list-check"></i></template>
                    Question Papers
                </SidebarMenuItem>
                <!-- <SidebarMenuItem
                    :href="route('categories.index')"
                    :is-active="$page.props.activeMenu === 'Categories'"
                    v-if="can('Manage categories')"
                    >
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

                <SidebarMenuItem
                    :href="route('profile.edit')"
                    :is-active="$page.props.activeMenu === 'My Profile'"
                    
                    >
                    <template #icon><i class="ri-user-line"></i></template>
                    My Profile
                </SidebarMenuItem>

                <SidebarMenuItem
                    :href="route('logout')"
                    :is-active="$page.props.activeMenu === 'Logout'"
                    method="POST"
                    >
                    <template #icon><i class="ri-logout-box-r-line"></i></template>
                    Logout
                </SidebarMenuItem>

            </div>
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
