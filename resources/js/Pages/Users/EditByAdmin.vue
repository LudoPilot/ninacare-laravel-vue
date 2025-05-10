<script setup lang="ts">
import type { User } from '@/types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    email: props.user.email,
});

const submit = () => {
    form.put(route('users.update', props.user.id));
};

const toggleStatus = () => {
    router.patch(route('users.toggle-status', props.user.id));
};

const deleteUser = () => {
    if (confirm('Are you sure you want to permanently delete this user?')) {
        router.delete(route('users.destroy', props.user.id));
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit User" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Back button (redirect to the list of users)-->
                        <div class="mb-4">
                            <Link
                                :href="route('users.index')"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-black dark:text-white text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600"
                            >
                                ← Back to Users
                            </Link>
                        </div>

                        <h2 class="text-xl font-semibold mb-6">Edit User</h2>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="first_name" value="First Name" />
                                <TextInput id="first_name" v-model="form.first_name" type="text" class="mt-1 block w-full" required autofocus />
                            </div>

                            <div>
                                <InputLabel for="last_name" value="Last Name" />
                                <TextInput id="last_name" v-model="form.last_name" type="text" class="mt-1 block w-full" required />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save changes</PrimaryButton>

                                <PrimaryButton type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white" @click="toggleStatus">
                                    {{ props.user.status === 'active' ? 'Deactivate' : 'Activate' }}
                                </PrimaryButton>

                                <DangerButton type="button" @click="deleteUser">Delete</DangerButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
