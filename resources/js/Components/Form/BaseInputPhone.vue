<template>
    <input class="form-control form-control-sm border-gray-300 focus:border-gray-800 focus:ring-indigo-800 rounded-0 shadow-sm max-w-full" :class="{'is-invalid': id in $page.props.errors }" type="tel" :id="id" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
</template>
<script setup>

import intlTelInput from 'intl-tel-input';
import { onMounted } from 'vue';

const emit =  defineEmits(['update:modelValue']);

// here, the index maps to the error code returned from getValidationError - see readme
const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

const props = defineProps({
  id: { type: String,  default: "phone"},
  modelValue: { type: String, default: "" }
})

const reset =  (phone) => {
  phone.classList.remove("is-invalid");
}
onMounted(() => {
  const phone = document.querySelector("#"+props.id);

  const phoneInput = intlTelInput(phone,{
    nationalMode: false,
    initialCountry: "mw",
    geoIpLookup: function (success, failure) {
      $.get("https://ipinfo.io", function () {}, "jsonp").always(
          function (resp) {
            var countryCode =
                resp && resp.country ? resp.country : "mw";
            success(countryCode);
          }
      );
    },
    utilsScript: "/js/utils.js",
  });
  phone.addEventListener("keyup", function () {
    reset(phone);
    if (phone.value.trim()) {
      if (phoneInput.isValidNumber()) {
        phone.setCustomValidity("");
        phone.classList.remove("is-invalid");
        phone.classList.add("is-valid");
        // invalidFeedback.innerHTML = "";
      } else {
        phone.setCustomValidity("Invalid phone number");
        phone.classList.add("is-invalid");
        phone.classList.remove("is-valid");

        let errorCode = phoneInput.getValidationError();
        // invalidFeedback.innerHTML = errorMap[errorCode];
      }
    }
    phoneInput.setNumber(
        phoneInput.getNumber(intlTelInputUtils.numberFormat.E164)
    );
  });
})

</script>
