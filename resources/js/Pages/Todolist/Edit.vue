<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({
    todolist: Object,
    status: {
        type: String,
    },
});

const form = useForm({
    title: props.todolist.title,
    text: props.todolist.text,
    status: props.todolist.status,
});

const submit = () => {
    form.put(route('todolist.update',props.todolist.id), {
        onFinish: () => console.log("Form send"),
    });
};

</script>

<template>
        <Head title="To Do List" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-center mb-12">
                                <h1>Edit To Do List</h1>
                        </div>

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
                                    <option value="1" >Todo</option>
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

                    </div>
                </div>
            </div>
        </div>
</template>


