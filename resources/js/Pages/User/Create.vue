<template>
    <base-card-main class="card-main card-flush" header-classes="mt-6" >
        <template #header>
            <div class="w-full">
                <wizard>
                    <wizard-step wizard-number="1" href="#" >Add Role</wizard-step>
                    <wizard-step data-wizard-state="pending" wizard-number="2" href="#" >User Permissions</wizard-step>
                </wizard>
            </div>
<!--            <div class="card-title flex-col flex-column">-->
<!--                <h2 class="mb-1 text-xl font-semibold">Add Role</h2>-->
<!--                <div class="text-base fw-semibold text-muted">Add a role to be assigned to users</div>-->
<!--            </div>-->
        </template>
<!--        <div class="separator separator-dashed mb-5"></div>-->
        <form method="POST" novalidate class="needs-validation w-3/4 mx-auto" @submit.stop.prevent="submit(inertiaSubmit, 'Save User')" >
            <div class="form-group mb-8">
                <label for="file" class="required form-label block">Avatar</label>
                <photo-upload v-model="form.file" />
            </div>
            <base-form-input name="name" label="Full Name" v-model="form.name" required />
            <base-form-input type="email" name="email" autocomplete label="User Email/Username" v-model="form.email" required />
            <div class="form-group">
                <label for="password" class="required mb-2">Password</label>
                <div class="input-group input-group-sm mb-3">
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
                <button type="button" class="btn btn-sm btn-light-facebook" @click="form.password = generatePassword()">Generate Password</button>
            </div>
            <div class="form-group my-3">
                <label for="roles" class="form-label">Roles</label>
                <base-select-multiple id="roles" v-model="form.roles" name="roles[]" field="name" :options="roles" placeholder="Select Roles" />
            </div>
            <div class="form-group my-5">
                <label for="send_notification" class="form-label">Send User Notification</label>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" v-model="form.send_notification" name="status" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                    <span class="text-gray-900 font-medium"> Send the new user an email about their account.</span>
                </label>
            </div>
            <div class="form-group my-5">
                <label for="send_notification" class="form-label">User status</label>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" v-model="form.status" name="status" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                    <span class="text-gray-900 font-medium">Is Active</span>
                </label>
            </div>
            <base-button-submit class="btn-primary" type="submit" :form-is-processing="form.processing" >Add User & Continue</base-button-submit>
        </form>
    </base-card-main>

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import {submit} from "@/helpers/form_helpers.js";
import passwordInput from "@/helpers/password_input";
import {store} from "@/store.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Wizard from "@/Components/Wizard.vue";
import WizardStep from "@/Components/WizardStep.vue";
import PhotoUpload from "@/Components/Form/PhotoUpload.vue";

defineOptions({ layout: AuthenticatedLayout});
defineProps({ roles: Array })

//Breadcrumb
store.pageTitle = 'New User';
store.setBreadCrumb({ Users: route('users.index'), 'New User' :null });

const form = useForm({ name:null, email:null, password:null, status: true, send_notification: 0, roles:[], file:null });
const { type, toggleText, toggle,generatePassword } = passwordInput('text');

const inertiaSubmit = () => {
    form.post(
        route('users.store'),
        {
            preserveScroll: true,
            onError: () => {
                form.password =  null
            },
        });
};

const onEmployeeSelected = (employee)=>{
    form.name = employee.full_name;
    form.email = employee.contact.email_address
}


</script>
