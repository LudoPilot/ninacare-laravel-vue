<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthenticatedNavbar from '@/Components/AuthenticatedNavbar.vue'

</script>

<template>
	<Head title="About" />

	<!-- Navbar -->
	<AuthenticatedNavbar />

	<!-- Page content -->
	<main class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
		<section class="py-12 w-full">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
					<div class="p-6 text-gray-900 dark:text-gray-100">
						<h1 class="text-2xl font-bold">About MyAPP</h1>
						<p class="mt-4 leading-relaxed">
							MyAPP is a fast, modern user management interface built with Laravel, Inertia.js, and Vue 3.
							Whether you’re browsing publicly available information or managing your user base, MyAPP
							provides an intuitive experience.
						</p>
						<p class="mt-2 leading-relaxed">
							Logged-in users can access features like dashboards, profile management, and administrative
							tools directly from the navbar above.
						</p>
					</div>
				</div>
			</div>
		</section>
	</main>
</template>