<template>
  <div class="fixed z-101 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" @click="$emit('hideModal')">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full" @click.stop="" >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex md:items-start w-full">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
              <div class="bg-red-100 border-t-4 w-full border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md mb-4" role="alert" v-if="hasErrors">
                <p class="font-bold">Whoops! Something went wrong.</p>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                  <li v-for="($error, index) in errors" :key="index" v-text="error"></li>
                </ul>
              </div>
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" v-text="title"></h3>
              <div class="mt-8">
                <slot></slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props =  defineProps({
  errors:{
    type: Object,
    default(){
      return {}
    }
  },
  title:String
});

const emits = defineEmits(['hideModal'])

const hasErrors = computed(()=>{
  return ! _.isEmpty(props.errors);
})

</script>