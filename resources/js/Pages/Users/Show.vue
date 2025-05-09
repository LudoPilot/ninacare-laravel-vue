<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

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
}>();
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">User Details</h1>

        <div class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <b>First name:</b> {{ user.first_name }}
            </div>
            <div>
                <b>Last name:</b> {{ user.last_name }}
            </div>
            <div>
                <b>Email:</b> {{ user.email }}
            </div>

            <div v-if="user.address">
                <hr class="my-4" />
                <h2 class="text-lg font-semibold">Address</h2>
                <div><b>Street:</b> {{ user.address.street }}</div>
                <div><b>City:</b> {{ user.address.city }}</div>
                <div><b>Post Code:</b> {{ user.address.post_code }}</div>
                <div><b>Country:</b> {{ user.address.country }}</div>
            </div>
        </div>
    </div>
</template>
