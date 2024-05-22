import Swal from "sweetalert2";

export default () => {
    const submit = (selector = "needs-validation", message = "save/update", inertiaSubmit=submitForm) => {
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
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, " + message + "!",
        }).then((result) => {
            if (result.isConfirmed){
                form.classList.remove("was-validated")
            }
            return result.isConfirmed
        });
    };
    const submitForm = (form)=>{
        form.submit()
    }

    return {
        submit,
    }
}