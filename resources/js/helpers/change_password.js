
import { ref, computed } from 'vue'

export function useChangePassword (){
    const changePassword = ref(false);
    const buttonText = computed(()=>{
        return changePassword.value === false ?  'Change Password' : 'Cancel';
    })
    const toggleChangePassword = ()=> {
        changePassword.value = !changePassword.value
    };

    return {
        changePassword,
        buttonText,
        toggleChangePassword
    }
}
