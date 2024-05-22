<template>
    <span :id="id" ></span>
</template>

<script setup>
import {CountUp} from 'countup.js'
import {onMounted} from "vue";

const props = defineProps({
    count: {
        type: Number,
        default: 0
    },
    id: {
        type: String,
        default: 'count_up'
    }
});

onMounted(()=>{
    const countUp = new CountUp(props.id, props.count);
    countUp.start();
})

</script>
