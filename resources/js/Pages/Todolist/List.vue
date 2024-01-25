<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue'
import { FwbButton, FwbModal } from 'flowbite-vue'

const isShowModal = ref(false);

function closeModal () {
    isShowModal.value = false;
}

function showModal () {
    isShowModal.value = true;
}

defineProps({
    todolists: Array,
    status: {
        type: String,
    },
    success: {
        type: String,
    },
});

const form = useForm({
    title: '',
    text: '',
    status: '',
});

const submit = () => {
    form.post(route('todolist.create'), {
        onFinish: () => console.log("Form send"),
    });
};

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('todolist.destroy', id));
    }
}
</script>

<template>
        <Head title="To Do List" />

        <div v-if="success" class="mb-4 font-medium text-sm text-green-600">
            {{ success }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-center mb-12">
                                <h1> To Do List</h1>
                        </div>

                        <!-- Modal toggle -->
                        <fwb-button @click="showModal">
                           Add To Do List
                        </fwb-button>

                        <table className="table-fixed w-full">
                            <thead>
                            <tr className="bg-gray-100">
                                <th className="px-4 py-2 w-20">No.</th>
                                <th className="px-4 py-2">Title</th>
                                <th className="px-4 py-2">Description</th>
                                <th className="px-4 py-2">Status</th>
                                <th className="px-4 py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="todolist in todolists">
                                <td className="border px-4 py-2">{{ todolist.id }}</td>
                                <td className="border px-4 py-2">{{ todolist.title }}</td>
                                <td className="border px-4 py-2">{{ todolist.text }}</td>
                                <td className="border px-4 py-2">{{ todolist.status }}</td>
                                <td className="border px-4 py-2">
                                    <Link
                                        tabIndex="1"
                                        className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                                        :href="route('todolist.edit', todolist.id)"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        @click="destroy(todolist.id)"
                                        tabIndex="-1"
                                        type="button"
                                        className="mx-1 px-4 py-2 text-sm text-white bg-red-500 rounded"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <fwb-modal v-if="isShowModal" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg">
                Add To Do List
            </div>
        </template>
        <template #body>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Title" />
                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                        autocomplete="title"
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="mt-4">
                    <InputLabel for="text" value="Description" />

                    <TextInput
                        id="text"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.text"
                        required
                        autocomplete="text"
                    />
                    <InputError class="mt-2" :message="form.errors.text" />
                </div>
                <div class="mt-4">
                    <InputLabel for="text" value="Status" />
                    <select v-model="form.status">
                        <option disabled value="">Please select one</option>
                        <option value="1">Todo</option>
                        <option value="2">In Progress</option>
                        <option value="3">Complete</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <fwb-button @click="closeModal" color="alternative">
                    Cancel
                </fwb-button>
            </div>
        </template>
    </fwb-modal>
</template>


