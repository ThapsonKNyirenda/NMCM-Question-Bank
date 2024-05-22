import Swal from "sweetalert2";

const getBtnColorClass = (indexNum) => {
    if (indexNum % 5 === 0) {
        return 'btn-pink';
    }
    if (indexNum % 4 === 0) {
        return 'btn-teal';
    }
    if (indexNum % 3 === 0) {
        return 'btn-danger';
    }
    return indexNum % 2 === 0 ? 'btn-indigo' : 'btn-green';
}

const getBadgeColorClass = (indexNum) => {
    if (indexNum % 5 === 0) {
        return 'light-warning';
    }
    if (indexNum % 4 === 0) {
        return 'light-success';
    }
    if (indexNum % 3 === 0) {
        return 'light-danger';
    }
    return indexNum % 2 === 0 ? 'light-primary' : 'primary';
}

const strAcronym = (text)=>{
    return text
        .split(/\s/)
        .reduce((accumulator, word) => accumulator + word.charAt(0), '')
        .substring(0,2)
        .toUpperCase()
}
const strSlug = (str)=> {
    str = str.replace(/^\s+|\s+$/g, ""); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    const from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    const to = "aaaaeeeeiiiioooouuuunc------";
    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
        .replace(/\s+/g, "_") // collapse whitespace and replace by -
        .replace(/-+/g, "_") // collapse dashes
        .replace(/^-+/, "") // trim - from start of text
        .replace(/-+$/, ""); // trim - from end of text

    return str;
}

const strUcFirst = (str)=>{
    return str ? str.charAt(0).toUpperCase() + str.slice(1)  : ''
}
const strReplaceAsterisk = (str) => {
    return str.charAt(str.length - 1) === '*' ? str.slice(0,-1) : str
}

const submit = (inertiaSubmit=submitForm, message = "save/update", selector = "needs-validation") => {
    let form = document.querySelector("."+selector);
    if (form.checkValidity() === true) {
        confirmSubmission(message, form).then(result=>{
            if (result){
                inertiaSubmit(form)
            }
        });
    }
    form.classList.add("was-validated");
};

const confirmSubmission = (message = "save/update", form)=>{
    return Swal.fire({
        position: "top",
        text: "Do you really want to " + message,
        imageUrl: '/images/warning.png',
        showCancelButton: true,
        confirmButtonColor: "#4FC9DA",
        cancelButtonColor: "transparent",
        confirmButtonText: "Confirm",
    }).then((result) => {
        if (result.isConfirmed){
            form.classList.remove("was-validated")
        }
        return result.isConfirmed
    });
};

const confirmOnly = ( message )=>
{
    return Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, " + message + "!",
    }).then((result) => {
        return result.isConfirmed
    });
}

const submitForm = (form)=>{
    form.submit()
}

const validateForm = (selector = "needs-validation") => {
    let form = document.querySelector("."+selector);
    form.classList.add("was-validated")
    return form.checkValidity();
}

const inputIsFilled = ( inputVal )=> {
   return inputVal && inputVal !== '';
}

const restoreScrolls =()=>{
    const element = document.getElementById('site-body');
    element.style.removeProperty("overflow");
    element.style.removeProperty("padding-right");
}

const strCapitalizeWord = (string) =>{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export{
    getBtnColorClass,
    getBadgeColorClass,
    strAcronym,
    strSlug,
    strUcFirst,
    strReplaceAsterisk,
    submit,
    validateForm,
    inputIsFilled,
    confirmOnly,
    restoreScrolls,
    strCapitalizeWord
}
