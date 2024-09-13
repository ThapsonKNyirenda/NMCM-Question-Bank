<script setup>
import Header from "@/Layouts/Header.vue";
import Sidebar from "@/Layouts/Sidebar.vue";
import BaseValidation from "@/Components/BaseValidation.vue";
import BaseFlashMessage from "@/Components/BaseFlashMessage.vue";
import '@fortawesome/fontawesome-free/css/all.css';

const props = defineProps({
  user: Object, // Ensure that user is passed from the layout
});

</script>
<template>
    <div>
        <div class="flex flex-col flex-1 " scroll-region>
           <div class="flex flex-[1_0_auto] flex-col">
            <Header :user="user" />
               <div class="flex-col flex-auto min-w-0 app-wrapper" >
                   <Sidebar />
                   <div class="flex flex-col flex-auto min-w-0 app-main" >
                       <div class="flex flex-col  flex-[1_0_auto]" >
                           <div class="app-content flex-[1_0_auto] min-h-50vh" >
                               <div class="app-container">
                                   <base-validation />
                                   <base-flash-message />
                                   <slot />
                               </div>
                           </div>
                       </div>
                       <div class="app-footer ">
                           <!--begin::Footer container-->
                           <div class="flex flex-col items-center justify-center w-full py-3 app-container md:flex-row md:justify-between ">
                               <!--begin::Copyright-->
                               <div class="order-2 text-gray-900 md:order-1">
                                   <span class="mr-1 font-medium text-muted">2024©</span>
                                   <a href="" target="_blank" class="text-gray-800 text-hover-primary">NMCM QUESTION BANK</a>
                               </div>
                               <!--end::Copyright-->

                               <!--begin::Menu-->
                               <ul class="order-1 font-medium menu menu-gray-600 menu-hover-primary">
                                   <li class="menu-item"><a href="#" target="_blank" class="px-2 menu-link">About</a></li>
                                   <li class="menu-item"><a href="#" target="_blank" class="px-2 menu-link">Support</a></li>

                               </ul>
                               <!--end::Menu-->
                           </div>
                           <!--end::Footer container-->
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>

</template>
