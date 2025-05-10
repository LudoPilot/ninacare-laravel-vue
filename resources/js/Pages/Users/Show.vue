<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AuthenticatedNavbar from '@/Components/AuthenticatedNavbar.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

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

	<Head title="User Details" />

	<AuthenticatedLayout>
		<!-- Page Heading -->
		<template #header>
			<h2 class="text-xl font-semibold leading-tight text-gray-800">
				User Details
			</h2>
		</template>

		<main class="py-12">
			<section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="flex items-center justify-end mb-6">
					<div class="space-x-2">
						<Link :href="route('users.index')"
							class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
						Back to List
						</Link>
						<Link v-if="props.isAdmin" :href="route('users.edit-by-admin', props.user.id)"
							class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
						Edit User
						</Link>
					</div>
				</div>

				<!-- User Information -->
				<div class="bg-white p-6 rounded-lg shadow">
					<div class="space-y-4">
						<div>
							<span class="font-semibold">First Name:</span>
							<span>{{ props.user.first_name }}</span>
						</div>
						<div>
							<span class="font-semibold">Last Name:</span>
							<span>{{ props.user.last_name }}</span>
						</div>
						<div>
							<span class="font-semibold">Email:</span>
							<span>{{ props.user.email }}</span>
						</div>

						<div v-if="props.user.address">
							<hr class="my-4" />
							<h3 class="text-lg font-semibold">Address</h3>
							<div>
								<span class="font-semibold">Street:</span>
								<span>{{ props.user.address.street }}</span>
							</div>
							<div>
								<span class="font-semibold">City:</span>
								<span>{{ props.user.address.city }}</span>
							</div>
							<div>
								<span class="font-semibold">Post Code:</span>
								<span>{{ props.user.address.post_code }}</span>
							</div>
							<div>
								<span class="font-semibold">Country:</span>
								<span>{{ props.user.address.country }}</span>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
	</AuthenticatedLayout>
</template>
