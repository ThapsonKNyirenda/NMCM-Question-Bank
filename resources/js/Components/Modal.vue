<script setup>
import {computed, onMounted, onUnmounted, ref, watchEffect} from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    bodyClasses: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['close']);
const open = ref( false );

watchEffect(()=>{
    open.value = props.show;
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
})

const closeProper = () => {
    open.value = !open;
    emit('close');
}

const close = () => {
    if (props.closeable) {
        open.value = !open;
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <div @click="open = !open">
        <slot name="toggle" />
    </div>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div v-show="open" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-111">
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div class="fixed inset-0 transform transition-all" @click="close()">
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </Transition>

                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        class="modal fade mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
                        :class="maxWidthClass"
                    >
                        <div class="modal-content">
                            <div class="modal-header">
                                <slot name="title" />
                                <div class="btn btn-icon btn-sm btn-active-light-primary ml-2" @click="closeProper()">
                                    <font-awesome-icon icon="fas fa-close text-2xl" />
                                </div>
                            </div>

                            <div class="modal-body max-h-full" :class="[bodyClasses]">
                                <slot />
                            </div>

                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
