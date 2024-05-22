<script setup>
import {onMounted, onUnmounted, ref, watch, watchEffect} from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    formIsProcessing: {
        type: Boolean,
        default: false
    },
    showDrawer: {
        type: Boolean,
        default: false
    },
});

const emit = defineEmits(['close','open']);
const open = ref(false);
const headerHeight = ref(0);
const footerHeight = ref(0);
const bodyHeight = ref(200);

const closeOnCloseButton = () => {
    open.value = !open;
    emit('close');
}

const openDrawer = () => {
    open.value = !open;
    emit('open');
}

const close = () => {
    if (props.closeable) {
        open.value = !open;
        emit('close');
    }
};

const closeOnEscape = (e) => {

    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

const getDrawerBodyHeight = ()=>{
    const height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    bodyHeight.value = height - (footerHeight.value + headerHeight.value + 60)
}

onMounted(() => {
    headerHeight.value = document.getElementById('drawer-header').clientHeight;
    footerHeight.value = document.getElementById('drawer-footer').clientHeight;

    getDrawerBodyHeight();

    document.addEventListener('keydown', closeOnEscape);
    window.addEventListener('resize', getDrawerBodyHeight)
});
onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    window.removeEventListener('resize', getDrawerBodyHeight)
    document.body.style.overflow = null;
});

watch(() => props.showDrawer,(newVal)=>{
    open.value = props.showDrawer;
})

</script>

<template>
    <div class="relative">
        <div @click="openDrawer()" >
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" style="z-index: 109;" class="fixed inset-0 drawer-overlay" @click="close()" ></div>

        <teleport to="body">
            <div class="bg-body drawer drawer-end w-[300px] md:w-[600px] " :class="{ 'drawer-on': open  }">
                <div class="card w-full border-0 rounded-none">
                    <div class="card-header !flex-nowrap pr-5" id="drawer-header" style="padding-right: 1.25rem">
                        <div class="card-title">
                            <div class="flex justify-center flex-col mr-3">
                                <slot name="header" />
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="btn btn-sm btn-icon btn-active-color-primary bg-muted-more text-muted mx-2 " style="width: 20px; height: 20px" @click="closeOnCloseButton()" v-if="!formIsProcessing">
                                <i class="ri-close-line lg:text-xl"></i>
                            </div>
                            <!--end::Close-->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="scroll-y pr-5" :style="{ height: bodyHeight + 'px' }">
                            <slot />
                        </div>
                    </div>
                    <div class="card-footer" id="drawer-footer">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>
