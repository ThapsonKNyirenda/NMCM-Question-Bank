<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between" v-if="hasPages" >
        <div class="flex justify-between flex-1 sm:hidden">
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md" v-if="onFirstPage">
                <i class="fas fa-angle-left"></i>
            </span>
            <Link :href="previousPageUrl" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" preserve-state v-else>
                <i class="fas fa-angle-left"></i>
            </Link>
            <Link :href="nextPageUrl" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" preserve-state v-if="nextPageUrl">
                <i class="fas fa-angle-right"></i>
            </Link>
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md" v-else>
                <i class="fas fa-angle-right"></i>
            </span>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between mr-3">
            <div>
                <p class="text-sm text-gray-700 leading-5"> Showing
                    <span class="font-medium" v-text="firstItem"></span>
                    to
                    <span class="font-medium" v-text="lastItem"></span>
                    of
                    <span class="font-medium" v-text="total"></span>
                    results
                </p>
            </div>
        </div>

        <div>
            <span class=" pagination pagination-circle pagination-outline">
                <!--Previous Page Link-->
                <span aria-disabled="true" class="page-item mx-1" aria-label="Prev" v-if="onFirstPage">
                    <span class="page-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                <span class="page-item mx-1" v-else>
                    <Link :href="previousPageUrl" rel="prev" class="page-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Prev" preserve-state>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </Link>
                </span>
                <template v-for="(link, key) in onlyLinks" :key="key">
                    <!--"Three Dots" Separator-->
                    <span aria-disabled="true" v-if="typeof link === 'string' ">
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5" v-text="link"></span>
                    </span>
                    <!--Array Of Links-->
                    <template v-if="typeof link === 'object'">
                        <span aria-current="page" class="page-item active mx-1"  v-if="link.active">
                            <span class="page-link relative inline-flex items-center px-3 py-3 text-sm font-medium text-white bg-blue-600  cursor-default leading-5" v-text="link.label"></span>
                        </span>
                        <span class="page-item mx-1" v-else>
                            <Link :href="link.url" class="page-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" :aria-label="'Go to page :page'+link.label" v-text="link.label" ></Link>
                        </span>
                    </template>
                </template>

                <span class="page-item mx-1" v-if="nextPageUrl">
                    <Link :href="nextPageUrl" rel="next" class="page-link relative inline-flex items-center px-2 py-2  text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next"  preserve-state>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </Link>
                </span>
                <span class="page-item mx-1" aria-disabled="true" aria-label="Next" v-else>
                    <span class="page-link relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
            </span>
        </div>
    </nav>
</template>

<script setup>
    import { defineProps, ref, computed } from 'vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        paginator: [Array, Object]
    });

    const lastPage = ref(props.paginator.last_page);
    const currentPage = ref(props.paginator.current_page);
    const previousPageUrl = ref(props.paginator.prev_page_url);
    const nextPageUrl  = ref(props.paginator.next_page_url);
    const firstItem =  ref(props.paginator.from);
    const lastItem = ref(props.paginator.to);
    const total = ref(props.paginator.total);
    const links = ref(props.paginator.links);

    const hasPages = computed(()=> lastPage.value !== 1);
    const onFirstPage = computed(()=> currentPage.value === 1  );
    const onlyLinks = computed(()=> {
        return props.paginator.links.filter((link)=>{
            return link.label !== 'Next &raquo;' && link.label !== "&laquo; Previous";
        })
    })
</script>
