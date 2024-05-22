<template>
    <a class="btn btn-sm ml-1" :href="action" @click.stop.prevent="deleteRecord()">
        <slot><i class="ri-delete-bin-6-fill"></i></slot>
    </a>
</template>
<script setup lang="ts">
    import Swal from "sweetalert2";
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        action: String,
        message: {
            type: String,
            default: "Delete it"
        }
    });

    const deleteRecord = ()=>{
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, " + props.message + "!",
        }).then((result) => {
            if (result.isConfirmed){
                router.delete(props.action, {
                    preserveState: false
                });
            }
        });
    }

</script>
