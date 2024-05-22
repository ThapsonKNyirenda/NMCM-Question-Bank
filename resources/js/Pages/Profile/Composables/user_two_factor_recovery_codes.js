import {ref} from "vue";

export function useTwoFactorRecoveryCodes() {
    const recoveryCode = ref('');

    const getRecoveryCode = () => {
        axios.get(route('two-factor.recovery-codes')).then(function (response) {
            const codes = response.data ?? [];
            const length = codes.length - 1;
            recoveryCode.value = codes[Math.floor(Math.random() * length) ]
        }).catch(function (error) {
            console.log(error);
        })
    }

    return {
        recoveryCode,
        getRecoveryCode
    }

}
