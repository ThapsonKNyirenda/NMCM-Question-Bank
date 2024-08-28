<template>
    <Head title="Edit Question Scenario" />
    <base-card-main class="card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Edit Question Scenario</h2>
                <div class="text-base fw-semibold text-muted">Edit the question scenario</div>
            </div>
        </template>
        <form method="POST" :action="route('unvettedquestions.update', { id: description_id })" novalidate class="w-3/4 mx-auto needs-validation"
            @submit.prevent.stop="submit(inertiaSubmit, 'update the question Scenario?')">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-4">
                <label for="diseaseArea" class="form-label">Select a Disease Area</label>
                <select v-model="form.disease_area" id="diseaseArea" name="disease_area" class="form-select" required>
                    <option disabled value="">Choose a Disease Area</option>
                    <option v-for="(value, key) in diseaseAreas" :key="key" :value="key">{{ value }}</option>
                </select>
            </div>

            <label class="form-label required">Question Scenario</label>
            <div class="mandatory-fields">
                <quill-input v-model="form.question_description" :placeholder="placeholders"/>
            </div>

            <base-button-submit class="btn-light-primary" type="submit" :form-is-processing="form.processing">Update</base-button-submit>
        </form>
    </base-card-main>

    <!-- Questions Table -->
    <base-card-main class="mt-6 card-main card-flush" header-classes="mt-6">
        <template #header>
            <div class="flex-col card-title flex-column">
                <h2 class="mb-1 text-xl font-semibold">Question Items for Selected Scenario</h2>
            </div>
        </template>

        <!-- Add Question Button -->
        <div class="card-toolbar">
            <base-button-new
                v-if="description_id"
                class="btn-light-primary"
                :href="createQuestionUrl"
            >
                New Question Item
            </base-button-new>
        </div>

        <!-- Questions Table -->
        <div v-if="questions.length" class="mt-6">
            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-sm table-auto">
                <thead>
                    <tr class="text-gray-600 bg-gray-100">
                        <th class="px-4 py-2 border-b">Title</th>
                        <th class="px-4 py-2 border-b">Choice A</th>
                        <th class="px-4 py-2 border-b">Choice B</th>
                        <th class="px-4 py-2 border-b">Choice C</th>
                        <th class="px-4 py-2 border-b">Choice D</th>
                        <th class="px-4 py-2 border-b">Correct Answer</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="question in questions" :key="question.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.title)"></td>
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_a)"></td>
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_b)"></td>
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_c)"></td>
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.choice_d)"></td>
                        <td class="px-4 py-2 border-b" v-text="stripHtmlTags(question.correct_answer)"></td>
                        <td class="flex items-center justify-start gap-2 px-4 py-2 border-b">
                            <button 
                                class="text-green-500 hover:text-blue-700"
                                @click="editQuestion(question.id, description_id)"
                            >
                                <i class="mr-2 text-xl fas fa-edit"></i>
                            </button>
                            <button 
                                class="ml-2 text-red-500 hover:text-red-700"
                                @click="confirmDelete(question.id)"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="text-center text-muted">
            No questions added yet.
        </div>
    </base-card-main>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { store } from "@/store.js";
import { submit } from "@/helpers/form_helpers.js";
import { useForm, Head } from "@inertiajs/vue3";
import QuillInput from "@/Components/QuillInput.vue"
import { computed, ref, onMounted } from 'vue';

defineOptions({ layout: AuthenticatedLayout });

store.pageTitle = 'Edit Question Scenario';
store.setBreadCrumb({ Questions: route('descriptions.index') });

const props = defineProps(['diseaseAreas', 'questions', 'description_id','description']);

const form = useForm({
    disease_area: '',
    question_description: null
});

const fetchDescriptionData = async (description_id) => {
    const response = await fetch(`/api/descriptions/${description_id}`);
    const description = await response.json();

    form.disease_area = description.disease_area_id;
    form.question_description = description.description;
};

if (props.description_id) {
    fetchDescriptionData(props.description_id);
}

const stripHtmlTags = (html) => {
    const doc = new DOMParser().parseFromString(html, 'text/html');
    return doc.body.textContent || "";
};

const inertiaSubmit = () => {
    form.patch(route('unvettedquestions.update', { id: props.description_id }));
};

const createQuestionUrl = computed(() => {
    if (props.description_id) {
        return route('questions.create', {
            description_id: props.description_id,
            pageType: 'descEdi'
        });
    }
    return '#';
});

const editQuestion = (questionId, descriptionId) => {
    const editUrl = route('questions.edit', { id: questionId, description_id: descriptionId }) + `?pageType=descEdi`;
    window.location.href = editUrl;
};




const confirmDelete = (questionId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('questions.destroy', questionId));
        }
    });
};
</script>
