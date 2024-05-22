
<template>
    <div>
        <button type="button" class="btn btn-primary float-right" @click="showTheModal()"><i class="fa fa-plus"></i> Add signature</button>
        <Teleport to="body">
            <div class="w-full">
                <base-modal title="Add signature" v-show="showModal" @hide-modal="hideModal()" >
                    <form @submit.prevent="submit(updatePassword, 'Update Password')" class="mt-6 space-y-6 needs-validation" novalidate>
                        <div class="modal-body">
                            Please sign in the dotted area
                            <div class="signature-wrapper">
                                <canvas id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                            </div>
                            <div class="mt-2">
                                <a class="btn btn-sm btn-outline-primary" id="undo">Undo</a>
                                <a class="btn btn-sm btn-outline-danger mx-2" id="clear">Clear</a>
                            </div>
                        </div>
                        <div class="modal-footer flex justify-end">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" :disabled="form.processing">
                                <i class="fa fa-save"></i>  Save
                            </button>
                        </div>

                        <base-seperator-dashed />
                    </form>
                </base-modal>
            </div>
        </Teleport>
    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import SignaturePad from "signature_pad";

const form = useForm({});
const showModal = ref(false);

const resizeCanvas = () => {
    let canvas = document.getElementById("signature-pad");
    const ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    //signaturePad.clear(); // otherwise isEmpty() might return incorrect value
}

const hideModal = ()=>{
    if(showModal.value){
        showModal.value = false;
    }
}

const showTheModal = () => {
    showModal.value = true;
    resizeCanvas();
}



const emit = defineEmits(['saveOrUpdate','modalHidden']);

</script>
