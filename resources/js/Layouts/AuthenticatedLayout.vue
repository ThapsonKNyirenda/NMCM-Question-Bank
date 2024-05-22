<script setup>
import Header from "@/Layouts/Header.vue";
import Sidebar from "@/Layouts/Sidebar.vue";
import BaseValidation from "@/Components/BaseValidation.vue";
import BaseFlashMessage from "@/Components/BaseFlashMessage.vue";
</script>
<template>
    <div>
        <div class="flex flex-col flex-1 " scroll-region>
           <div class="flex flex-[1_0_auto] flex-col">
               <Header />
               <div class="app-wrapper flex-col flex-auto min-w-0" >
                   <Sidebar />
                   <div class="app-main flex flex-auto min-w-0 flex-col" >
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
                           <div class="app-container w-full flex flex-col md:flex-row justify-center items-center md:justify-between py-3 ">
                               <!--begin::Copyright-->
                               <div class="text-gray-900 order-2 md:order-1">
                                   <span class="text-muted font-medium mr-1">2024©</span>
                                   <a href="" target="_blank" class="text-gray-800 text-hover-primary">NMCM QUESTION BANK</a>
                               </div>
                               <!--end::Copyright-->

                               <!--begin::Menu-->
                               <ul class="menu menu-gray-600 menu-hover-primary font-medium order-1">
                                   <li class="menu-item"><a href="#" target="_blank" class="menu-link px-2">About</a></li>
                                   <li class="menu-item"><a href="#" target="_blank" class="menu-link px-2">Support</a></li>

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
