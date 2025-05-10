<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AuthenticatedNavbar from '@/Components/AuthenticatedNavbar.vue';

const props = defineProps<{
	users: { data: any[]; links: Array<{ label: string; url: string | null; active: boolean }> };
	filters: { search: string | null };
}>();

const search = ref(props.filters.search || '');
watch(search, (value) => {
	router.get(
		route('users.index'),
		{ search: value },
		{ preserveState: true, replace: true }
	);
});
</script>

<template>
	<Head title="User Search" />

	<AuthenticatedLayout>
		<template #header>
			<h2 class="text-xl font-semibold leading-tight text-gray-800">
				User Search
			</h2>
		</template>

		<!-- Main content -->
		<div class="py-12">
			<div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

				<!-- Formulaire de recherche -->
				<div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
					<label for="search" class="block text-sm font-medium text-gray-700 mb-2">
						Search users
					</label>
					<input id="search" v-model="search" type="text"
						class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
						placeholder="Search by name or email" />
				</div>

				<!-- Results -->
				<div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
					<ul class="divide-y divide-gray-200">
						<li v-for="user in props.users.data" :key="user.id"
							@click="$inertia.visit(route('users.show', user.id))"
							class="p-4 hover:bg-gray-50 cursor-pointer flex flex-col md:flex-row md:justify-between md:items-center">
							<div>
								<h3 class="text-lg font-semibold text-gray-800">
									{{ user.first_name }} {{ user.last_name }}
								</h3>
								<p class="text-sm text-gray-600">{{ user.email }}</p>
								<p class="text-sm text-gray-400">
									{{ user.address?.street }}, {{ user.address?.city }}
								</p>
							</div>
						</li>
					</ul>
				</div>

				<!-- Pagination -->
				<div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
					<nav class="flex justify-center space-x-2" aria-label="Pagination">
						<button v-for="page in props.users.links" :key="page.label" v-html="page.label"
							:disabled="!page.url" @click.prevent="page.url && router.visit(page.url)"
							class="px-3 py-1 border rounded text-sm focus:outline-none" :class="{
								'bg-gray-200': page.active,
								'text-gray-400 cursor-not-allowed': !page.url,
								'hover:border-gray-500 hover:text-gray-900': page.url
							}"></button>
					</nav>
				</div>

			</div>
		</div>
	</AuthenticatedLayout>
</template>
