<template>
    <Head title="Edit User" />
    <div class="w-full">
        <wizard>
            <wizard-step wizard-number="1" :href="route('users.edit',{user:user.uuid})" >Edit User</wizard-step>
            <wizard-step data-wizard-state="pending" wizard-number="2" :href="route('users.permissions.create',{user: user.uuid })">
                User's Permissions
            </wizard-step>
        </wizard>
    </div>
    <div class="grid grid-cols-5 gap-10 mt-10">
            <div>
                <base-card-main class="card-main card-flush" header-classes="mt-0 !min-h-0" >
                <photo-upload :logo="user.photo_url" v-model="formUpload.file" />
                </base-card-main>
            </div>

        <div class="col-span-4">
            <base-card-main class="card-main card-flush" header-classes="mt-0 !min-h-0" >
                <form method="POST" novalidate class="needs-validation " @submit.stop.prevent="submit(inertiaSubmit, 'edit the user details?')" >
                    <base-form-input name="name" label="Full Name" v-model="form.name" required />
                    <base-form-input type="email" name="email" autocomplete label="User Email/Username" v-model="form.email" required />
                    <div class="form-group">
                        <label for="password" class="mb-2" :class="{required:changePassword}">Password</label>
                        <div class="input-group input-group-sm mb-3" v-if="changePassword">
                            <input class="form-control form-control-sm rounded-none border-gray-300  "
                                   :class="{'is-invalid': 'password' in $page.props.errors }"
                                   v-model="form.password"
                                   :type="type"
                                   name="password"
                                   id="password"
                                   autocomplete="new-password"
                                   placeholder="Password"
                                   aria-label="Password"
                                   aria-describedby="basic-addon2" required  />
                            <div class="input-group-append rounded-none">
                                <a href="#" @click.prevent.stop="toggle()" class="input-group-text" id="basic-addon2">
                                    <font-awesome-icon class="mr-1" :icon="type==='password' ? ' fas fa-eye' : 'fas fa-eye-slash' " />
                                    <span v-text="toggleText"></span>
                                </a>
                            </div>
                        </div>

                        <div class="w-full">
                            <button type="button" class="btn btn-sm btn-light-facebook text-xs mr-2" @click="form.password = generatePassword()" v-if="changePassword">Generate Password</button>
                            <button class="btn btn-sm btn-outline-orange text-xs" type="button" @click="toggleChangePassword()" v-text="buttonText"></button>
                        </div>
                    </div>
                    <div class="form-group my-3">
                        <label for="roles" class="form-label">Roles</label>
                        <base-select-multiple class="!w-100" id="roles" v-model="form.roles" name="roles[]" field="name" :options="roles" placeholder="Select Roles" />
                    </div>
                    <div class="form-group my-5">
                        <label for="send_notification" class="form-label">User status</label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" v-model="form.status" name="status" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium">Is Active</span>
                        </label>
                    </div>
                    <base-button-submit class="btn-primary" type="submit" :form-is-processing="form.processing" >Edit User & Continue</base-button-submit>
                </form>
            </base-card-main>
        </div>

    </div>

</template>

<script setup>
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import {store} from "@/store.js";
import passwordInput from "@/helpers/password_input";
import { useChangePassword } from "@/helpers/change_password";
import PhotoUpload from "@/Components/Form/PhotoUpload.vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {watch} from "vue";

defineOptions({ layout: AuthenticatedLayout});
const props = defineProps({ user:Object, roles:Array })

//Breadcrumb
store.pageTitle = 'Edit User';
store.setBreadCrumb({ Roles: route('users.index'), [props.user.name] :null });

const { type, toggleText, toggle,generatePassword } = passwordInput('text');
const { changePassword, buttonText, toggleChangePassword  } = useChangePassword();

const form = useForm(
    {
        name:props.user.name,
        email:props.user.email,
        password:null,
        status: props.user.status,
        roles: props.user.roles.map( (user) => { return user.id })
    }
);

const formUpload = useForm({ file: null })

const inertiaSubmit = () => {
    form.transform((data)=>({
        ...data,
        change_password: changePassword.value
    })).patch(route('users.update', { user: props.user.uuid }), { preserveState: true });
};

watch( ()=> formUpload.file, (newFile)=>{
    formUpload.post(route('users.photo.upload', {user:props.user.uuid}),{ preserveState: false });
});


</script>
