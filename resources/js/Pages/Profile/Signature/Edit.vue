<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from "@/Pages/Profile/Partials/ProfileHeader.vue";
import { submit } from '@/helpers/form_helpers.js'
import {Head, useForm, Link} from '@inertiajs/vue3';
import {onMounted, ref} from "vue";
import SignaturePad from "signature_pad";
import InputError from "@/Components/InputError.vue";

defineOptions({ layout: AuthenticatedLayout })

let signaturePad = null;

defineProps({
    mustVerifyEmail: Boolean,
    status: {
        type: String,
    },
    twoFactorEnabled : {
        type: Boolean
    }
});

const errors = ref(null);

const form = useForm({
    signature: null
});

onMounted(() => {
    let canvas = document.getElementById("signature-pad");
    const clear = document.getElementById("clear");
    const undo = document.getElementById("undo");

    function clearPad(){
        signaturePad.clear();
    }

    function undoPad() {
        const data = signaturePad.toData();
        if (data) {
            data.pop(); // remove the last dot or line
            signaturePad.fromData(data);
        }
    }

    window.addEventListener("resize", resizeCanvas);
    clear.addEventListener('click', clearPad);
    undo.addEventListener('click', undoPad);
    resizeCanvas();

    signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
})


const updateSignature = () => {
    errors.value = null;
    if (signaturePad.isEmpty()){
        errors.value = 'Please provide a signature first'
    }else{
        const data = signaturePad.toDataURL();
        form.signature = data

        form.patch(route('profile.signature.update'), {
            preserveScroll: true,
        });
    }
};

const resizeCanvas = () => {
    let canvas = document.getElementById("signature-pad");
    const ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    //signaturePad.clear(); // otherwise isEmpty() might return incorrect value
}


</script>

<template>
    <Head title="Update Signature" />
    <profile-header :two-factor-enabled="twoFactorEnabled"  active-tab="Signature" />

    <base-card-main class="mb-5 lg:mb-10 card-main" header-classes="cursor-pointer border-0" body-classes="p-9">
        <template #header>
            <div class="card-title m-0">
                <h3 class="font-semibold m-0">Add/Update Signature</h3>
            </div>
        </template>

        <div class="py-6 pt-1 ">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <section class="w-full">
                        <header>
                            <p class="mt-1 text-sm text-gray-600">
                                Please sign in the dotted area
                            </p>
                        </header>

                        <form @submit.prevent="submit(updateSignature, 'change signature?')" class="mt-6 space-y-6 needs-validation" novalidate>
                            <div class="signature-wrapper">
                                <canvas id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                                <input type="hidden" name="signature" v-model="form.signature" required />
                            </div>
                            <div class="block my-2">
                                <InputError :message="errors" class="mt-2" />
                            </div>
                            <div class="mt-2">
                                <a class="btn btn-sm btn-light-google" id="undo">
                                    <i class="ri-arrow-go-back-line"></i> Undo
                                </a>
                                <a class="btn btn-sm btn-light-primary mx-2" id="clear">
                                    <i class="ri-eraser-fill"></i>Clear</a>
                            </div>
                            <div class="modal-footer flex justify-end">
                                <Link :href="route('profile.signature.show')" type="button" class="btn btn-sm btn-light-dark mr-3">Cancel</Link>
                                <button type="submit" class="btn btn-sm btn-primary" :disabled="form.processing">
                                    <i class="ri-save-fill"></i> Save
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </base-card-main>
</template>
