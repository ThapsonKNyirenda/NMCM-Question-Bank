import {ref} from "vue";

export function useTwoFactorQrCodes() {
    const qrCodeSvg = ref('<span class="block my-10">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>');

    const getQRCode = () => {
        axios.get(route('two-factor.qr-code')).then(function (response) {
            qrCodeSvg.value = response.data.svg;
        }).catch(function (error) {
            console.log(error);
        })
    }

    return {
        getQRCode,
        qrCodeSvg
    }

}
