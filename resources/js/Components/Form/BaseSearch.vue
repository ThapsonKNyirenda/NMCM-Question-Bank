<template>
    <div class="flex items-center">
        <form method="GET" :action="href" class="lg:block w-full relative mb-5 lg:mb-0" @submit.stop.prevent="submitSearch" >
            <i class="ri-search-line text-base font-semibold text-muted lg:text-2xl md:text-xl absolute top-1/2 translate-middle-y ml-5 text-theme-gray-800"></i>
            <input
                type="text"
                v-model="searchTerm"
                :placeholder="placeholder"
                class="search-input form-control form-control-solid rounded-xl py-4 pl-14 focus:ring-0 text-header-search ring-0"
                name="search" />
        </form>
    </div>
</template>

<script setup>
    import { watch, ref } from 'vue';
    import { router } from '@inertiajs/vue3'
    import {debounce} from "lodash";

    const props = defineProps({
      placeholder:{
        type: String,
        default: 'Search'
      },
      href: String,
      search: String,
      filters: {
        type: Object,
        default(){
            return {}
        }
      },
      partial: {
        type: String,
        default: null
      }
    });

    const searchTerm = ref(props.search);

    const submitSearch = () => {
        router.get(props.href,
            { search: searchTerm.value },
            {
                preserveState:true,
                replace: true
            },
        );
    };

    watch(searchTerm, (search, oldvalue) => {
        searchDebounce(search)
    });

    const searchDebounce = debounce((term) => {

      if ( props.partial ){
        router.get(
            props.href,
            { search: term,...props.filters },
            {
              preserveState: true,
              replace: true,
              only:[props.partial]
            }
        );
      }else{

        router.get(
            props.href,
            { search: term,...props.filters },
            {
              preserveState: true,
              replace: true,
            }
        );
      }
    }, 400);

</script>
