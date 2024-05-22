<template>
    <input
        class="form-control form-control-sm border-gray-300 focus:border-gray-800 focus:ring-indigo-800 rounded-0 shadow-sm rounded-none py-0"
        :class="{'is-invalid': name in $page.props.errors }"
        :id="id"
        v-model="model"
        v-bind="$attrs"
    />
</template>

<script setup>
import Tagify from '@yaireo/tagify'
import {onMounted, ref} from "vue";
defineOptions({ inheritAttrs: false });
const model = defineModel();

const emit = defineEmits(['contact-tags.index'])

const props = defineProps({
    name: String,
    id: {
        type: String,
        default: 'tagify'
    },
    url: {
        type: String,
        default: ''
    },
    whitelist: {
        type: Array,
        default(rawProps){
            return []
        }
    }
});

onMounted(()=>{
    const inputElem = document.getElementById(props.id);
    let tagify = new Tagify(inputElem, {
        // A list of possible tags. This setting is optional if you want to allow
        // any possible tag to be added without suggesting any to the user.
        whitelist: props.whitelist,
        dropdown: {
            maxItems: 20,           // <- mixumum allowed rendered suggestions
            classname: "tagify__inline__suggestions", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
        },
        texts: {
            duplicate: "Duplicates are not allowed"
        }
    }), controller;

    tagify.on('add', onAddTag)
        .on('remove', onRemoveTag)
        .on('input', onInput)

    function onInput(e){
        if (props.url !== ''){
            const value = e.detail.value;
            tagify.whitelist = null // reset the whitelist

            // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
            controller && controller.abort()
            controller = new AbortController()

            // show loading animation.
            tagify.loading(true);

            fetch(props.url + '?search=' + value, {signal:controller.signal})
                .then(RES => RES.json())
                .then(function(newWhitelist){
                    tagify.whitelist = newWhitelist // update whitelist Array in-place
                    tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
                })
        }
    }

})

const onAddTag = (e)=>{
    if (!model.value.includes(e.detail.data.value)){
        model.value.push(e.detail.data.value);
    }
}

const onRemoveTag = (e)=>{
    const index = model.value.indexOf(e.detail.data.value);

    if (index > -1) { // only splice array when item is found
        model.value.splice(index, 1); // 2nd parameter means remove one item only
    }
}


</script>

