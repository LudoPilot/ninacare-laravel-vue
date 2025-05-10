<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    user: {
        id: number;
        first_name: string;
        last_name: string;
        email: string;
        address?: {
            country: string;
            city: string;
            post_code: string;
            street: string;
        };
    };
	isAdmin: boolean;
}>();
</script>

<template>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">User Details</h1>
            <div class="space-x-2">
                <!-- ✅ Bouton Retour -->
                <Link
    				:href="route('users.index')"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                >
                    Back to List
                </Link>

                <!-- Edit button -->
                <Link
				    v-if="props.isAdmin"
                    :href="route('users.edit-by-admin', user.id)"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Edit User
                </Link>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <strong>First Name:</strong> {{ user.first_name }}
            </div>
            <div>
                <strong>Last Name:</strong> {{ user.last_name }}
            </div>
            <div>
                <strong>Email:</strong> {{ user.email }}
            </div>

            <div v-if="user.address">
                <hr class="my-4" />
                <h2 class="text-lg font-semibold">Address</h2>
                <div><strong>Street:</strong> {{ user.address.street }}</div>
                <div><strong>City:</strong> {{ user.address.city }}</div>
                <div><strong>Post Code:</strong> {{ user.address.post_code }}</div>
                <div><strong>Country:</strong> {{ user.address.country }}</div>
            </div>
        </div>
    </div>
</template>
