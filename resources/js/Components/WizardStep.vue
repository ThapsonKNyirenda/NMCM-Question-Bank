<template>
  <Link class="wizard-step" data-wizard-type="step" data-wizard-state="current">
    <div class="wizard-label">
      <span class="wizard-number" v-text="wizardNumber"></span>
      <span class="wizard-check">
            <span class="svg-icon svg-icon-2x">
                <!--begin::Svg Icon | path:/keen/theme/demo1/dist/assets/media/svg/icons/Navigation/Check.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002)"></path>
                    </g>
                </svg>
              <!--end::Svg Icon-->
            </span>
        </span>
    </div>
    <div class="wizard-title"><slot></slot></div>
  </Link>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
const props = defineProps({
  wizardNumber:String
})
</script>
