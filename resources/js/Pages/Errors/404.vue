<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
	<Head title="404 Not Found" />

	<Navbar />

	<GuestLayout>
		<template #default>
			<div class="text-center">
				<h1 class="text-5xl font-bold text-red-600">404</h1>
				<h2 class="mt-2 text-2xl font-semibold text-gray-800">Page Not Found</h2>
				<p class="mt-4 text-gray-600">
					The page does not exist.
				</p>
				<Link href="/"
					class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
				Go back to the homepage
				</Link>
			</div>
		</template>
	</GuestLayout>
</template>