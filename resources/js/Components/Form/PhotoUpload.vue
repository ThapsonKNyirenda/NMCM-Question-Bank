<template>
    <div class="image-input image-input-outline" :class="{ 'image-input-empty': !url, 'image-input-placeholder': isAvatar, 'image-input-placeholder-logo': !isAvatar  }">
        <!--begin::Image preview wrapper-->
        <div class="image-input-wrapper" :class="imageWrapperClasses" :style="{'background-image' : bgImage }"></div>
        <!--end::Image preview wrapper-->
        <!--begin::Edit button-->
        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary bg-body shadow"
               data-kt-image-input-action="change"
               data-bs-dismiss="click"
               title="Change avatar"
               style="height: 30px; width: 30px"
        >
            <font-awesome-icon icon="fas fa-pencil"/>
            <!--begin::Inputs-->
            <input type="file" name="avatar" accept=".png, .jpg, .jpeg"   @input="changeFile($event)" v-bind="$attrs" />
            <input type="hidden" name="avatar_remove" />
            <!--end::Inputs-->
        </label>
        <!--end::Edit button-->
        <!--begin::Cancel button-->
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="cancel"
              data-bs-toggle="tooltip"
              data-bs-dismiss="click"
              title="Cancel avatar"
              style="height: 30px; width: 30px"
        ><font-awesome-icon icon="fas fa-xmark" /></span>
        <!--end::Cancel button-->

        <!--begin::Remove button-->
        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="remove"
              data-bs-toggle="tooltip"
              data-bs-dismiss="click"
              title="Remove avatar"
              style="height: 30px; width: 30px"
              @click="file = remove()"
        >
            <font-awesome-icon icon="fas fa-close" />
    </span>
        <!--end::Remove button-->

    </div>
    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
</template>

<script setup>
import {computed, ref, watchEffect} from 'vue';


defineOptions({ inheritAttrs:false })

//isAvatar determines which type of placeholder to use on the image i.e. ( image or avatar placeholder )
const props = defineProps({
  logo:{
      type:String,
      default: null,
  },
    isAvatar:{
      type:Boolean,
        default: true
  },
    imageWrapperClasses: {
      type: String,
        default: 'w-125px h-125px'
    }
});

const file = defineModel();
const url  = ref(props.logo);

const bgImage = computed(()=> url.value ? `url(${url.value })` : 'none' );

const changeFile = (e)=>{
    file.value = e.target.files[0];
    url.value = URL.createObjectURL(e.target.files[0])
}

const remove = () => {
    file.value = null;
    url.value = null;
}
watchEffect(()=>{
    url.value = props.logo
})

</script>
