import {computed, ref} from "vue";

export default (defaultType = 'password') => {
    const numbers = "01234567890123456789";
    const upperCaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const lowerCaseLetters = "abcdefghijklmnopqrstuvwxyz";
    const specialCharacters = "!'^+%&/()=?_#${[]}|;:><.*-@";
    const type = ref(defaultType);
    const toggleText = computed(()=>{
        return type.value === 'password'  ?  'show' : 'hide'
    });
    const toggle = ()=>{
        if (type.value === 'password'){
            type.value =  'text';
        }else{
            type.value =  'password';
        }
    }

    const generatePassword = () => {
        let password = '';
        let charsList = lowerCaseLetters;
        charsList += numbers;
        charsList += upperCaseLetters;
        charsList += specialCharacters;
        //generate the password
        for(let i = 0; i < 20; i++){
            const charIndex = Math.round(Math.random() * charsList.length);
            password = password + charsList.charAt(charIndex);
        }

        return password;
    }

    return {
        type,
        toggleText,
        toggle,
        generatePassword
    }
}
