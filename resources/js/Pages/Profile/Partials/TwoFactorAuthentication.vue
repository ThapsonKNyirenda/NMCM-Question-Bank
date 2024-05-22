<template>
    <div
        class="notice flex rounded-2xl border border-dashed p-6 w-3/4"
        :class="{ 'bg-light-primary border-primary' : !twoFactorEnabled, 'bg-light-danger border-danger' : twoFactorEnabled  }"
    >
        <!--begin::Icon-->
        <i class="ri-shield-check-fill text-4xl text-primary mr-4" :class="[ twoFactorEnabled ? 'text-danger' : 'text-primary' ]" ></i>
        <div class="flex items-center justify-between grow flex-wrap md:flex-nowrap">
        <!--begin::Content-->
        <div class="mb-3 mb-md-0 fw-semibold">
            <h4 class="text-gray-900 text-2xl font-bold">{{ twoFactorEnabled ? 'Your Account Is Secured' : 'Secure Your Account' }}</h4>
            <div class="text-lg text-gray-700 pr-7">Two-factor authentication adds an extra layer of security to your account. To log in, in addition you'll need to provide a 6 digit code</div>
            <modal :closeable="false" :show="showModal" body-classes="scroll-y pt-10 pb-15 lg:px-17" @close="showModal = false">
                <template #title >
                    <h3 class="modal-title font-bold text-2xl">Choose An Authentication Method</h3>
                </template>
                <div>
                    <h3 class="text-gray-900 text-xl font-semibold mb-7">
                        Authenticator Apps
                    </h3>
                    <div class="text-gray-500 font-medium text-lg mb-10">
                        Using an authenticator app like
                        <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>,
                        <a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">Microsoft Authenticator</a>,
                        <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                        <a href="https://support.1password.com/one-time-passwords/" target="_blank">1Password</a>,
                        scan the QR code. It will generate a 6 digit code for you to enter below.

                        <div class="py-5 text-center flex justify-center items-center min-h-20" v-html="qrCodeSvg"></div>
                        <div class="notice flex bg-light-warning rounded-2xl border-warning border border-dashed mb-10 p-6">
                            <!--begin::Icon-->
                            <i class="ri-information-2-fill text-3xl text-warning me-4"></i>
                            <div class="flex grow justify-between items-center ">
                                <!--begin::Content-->
                                <div class="font-medium">
                                    <div class="text-lg text-gray-700 ">If you having trouble using the QR code, select manual entry on your app, and enter your username and the code:
                                        <div class="font-semibold text-gray-900 pt-2" v-text="recoveryCode"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <form
                            class="form needs-validation-modal"
                            novalidate="novalidate"
                            @submit.prevent="submit(inertiaSubmit, 'confirm two factor authentication?','needs-validation-modal')">
                            <!--begin::Input group-->
                            <div class="mb-10 relative">
                                <input type="text" class="form-control form-control-lg form-control-solid" placeholder="Enter authentication code" name="code" v-model="form.code">
                            </div>
                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="flex justify-center items-center">
                                <button type="reset" class="btn btn-sm btn-light mt-0 mr-3" @click.prevent="showModal = false">
                                    Cancel
                                </button>
                                <base-button-submit class="btn-sm btn-primary !mt-0" type="submit" :form-is-processing="form.processing" >Submit</base-button-submit>
                            </div>
                            <!--end::Actions-->
                        </form>
                    </div>
                </div>
            </modal>
        </div>
        <button
            @click.prevent.stop="enableTwoFactor()"
            class="btn btn-sm btn-primary px-6 self-center text-nowrap"
            v-if="!twoFactorEnabled"
        >Enable</button>
        <button
            @click.prevent.stop="disableTwoFactor()"
            class="btn btn-sm btn-danger px-6 align-self-center text-nowrap"
            v-else
        >Disable</button>
    </div>

    </div>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import {submit} from "@/helpers/form_helpers.js";
import {useTwoFactorQrCodes} from "@/Pages/Profile/Composables/user_two_factor_qr_codes.js";
import {useTwoFactorRecoveryCodes} from "@/Pages/Profile/Composables/user_two_factor_recovery_codes.js";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
    twoFactorEnabled : {
        type: Boolean
    }
});


const { getQRCode ,qrCodeSvg} = useTwoFactorQrCodes()
const {getRecoveryCode, recoveryCode } = useTwoFactorRecoveryCodes();

const showModal = ref(false);

const form = useForm({ code: ''});
const enableForm = useForm({});

const enableTwoFactor = () => {
    enableForm.post(route('two-factor.enable'),{
        onSuccess: ()=>{
            showModal.value = true;
            getQRCode();
            getRecoveryCode();
        }
    })
}

const disableTwoFactor = () => {
    enableForm.delete(route('two-factor.disable'))
}

const inertiaSubmit = () => {
    form.post(route('two-factor.confirm'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showModal.value = false;
        },
        onError: () => {},
    });
};

</script>

