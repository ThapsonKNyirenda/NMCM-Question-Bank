<template>
    <base-card-main  class="card-main card-dashed card-flush shadow-sm mb-5 lg:mb-10" header-classes="!p-0 !min-h-0" body-classes="!pt-9 !pb-0" preserve-state>
        <div class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent text-xl font-semibold">
            <li class="nav-item mt-2" v-for="(route, index) in tabs">
                <Link class="nav-link text-active-primary ml-0 !mr-10 !py-5" :class="{ active: activeTab === index }" :href="route">
                    {{ index }}
                </Link>
            </li>
        </div>
    </base-card-main>
</template>

<script setup>

defineProps({
    activeTab: {
        type: String,
        default: 'Overview'
    },
});

const tabs = {
    Overview : route('email-templates.index'),
    'Help Desk': '#',
    Customers: '#',
    Tasks: '#',
}

import {Link, router} from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import CountUpNumber from "@/Components/CountUpNumber.vue"

</script>
