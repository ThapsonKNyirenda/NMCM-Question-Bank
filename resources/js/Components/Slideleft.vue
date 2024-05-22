<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import {store} from "@/store.js";
import {Link} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue"

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const open = ref(false);
</script>

<template>
    <div class="relative">
        <div @click="store.toggleChatDrawer" >
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="store.showChatDrawer" style="z-index: 109;" class="fixed inset-0 drawer-overlay" @click="store.showChatDrawer = false" ></div>

        <teleport to="body">
            <div class="bg-body drawer drawer-end w-[300px] lg:w-[500px] " :class="{ 'drawer-on': store.showChatDrawer  }">
                <div class="card w-full border-0 rounded-none">
                    <div class="card-header pr-5" style="padding-right: 1.25rem">
                        <div class="card-title">
                            <div class="flex justify-center flex-col mr-3">
                                <Link href="#" class="text-xl font-semibold text-gray-900 text-hover-primary mr-1 mb-2 leading-4">CRM Bot</Link>
                                <!--begin::Info-->
                                <div class="mb-0 leading-4">
                                    <span class="badge badge-success badge-circle mr-1" style="height: 10px; width: 10px"></span>
                                    <span class="text-fs-7 font-medium text-muted">Active</span>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <Dropdown class="mr-5 z-111" content-classes="py-0 " width="52">
                                <template #trigger>
                                    <button class="btn btn-sm btn-icon btn-active-color-primary text-muted bg-muted-more" style="width: 20px; height: 20px">
                                        <i class="ri-more-fill lg:text-xl"></i>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary font-medium py-3" >
                                        <!--begin::Heading-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 text-xl text-uppercase">
                                                Contacts
                                            </div>
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Add Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link flex-stack px-3">
                                                Invite Contacts
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" >
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">Groups</span>
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
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary bg-muted-more text-muted mx-2 " style="width: 20px; height: 20px" @click="store.showChatDrawer = false">
                                <i class="ri-close-line lg:text-xl"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                    </div>
                    <div class="card-body" >
                        <div class="scroll-y m-[-1.25rem] pr-5" ></div>
                    </div>
                    <div class="card-footer">
                        <textarea class="form-control form-control-flush mb-3" rows="1"  placeholder="Type a message" ></textarea>
                        <div class="flex justify-between items-center">
                            <div class="d-flex align-items-center me-2">
                                <button class="btn btn-sm btn-icon btn-active-light-primary mr-1" type="button" >
                                    <i class="ri-attachment-line text-xl text-muted"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-active-light-primary mr-1" type="button">
                                    <i class="ri-upload-cloud-2-fill text-xl text-muted"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary rounded-none" type="button">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>
