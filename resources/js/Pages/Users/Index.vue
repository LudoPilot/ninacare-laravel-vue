<script setup lang="ts">
import { router, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps<{
	users: any;
	filters: { search: string | null };
}>();

const search = ref(props.filters.search || "");

watch(search, (value) => {
	router.get(
		route("users.index"),
		{ search: value },
		{ preserveState: true, replace: true }
	);
});
</script>

<template>
	<div class="p-6">
		<h1 class="text-2xl font-bold mb-4">User Search</h1>

		<input v-model="search" type="text" class="w-full px-4 py-2 border rounded"
			placeholder="Search by name or email" />

		<div class="mt-6 space-y-4">
			<div v-for="user in users.data" :key="user.id"
				class="p-4 bg-white rounded shadow hover:bg-gray-100 cursor-pointer"
				@click="$inertia.visit(route('users.show', user.id))">
				<div class="font-semibold">
					{{ user.first_name }} {{ user.last_name }}
				</div>
				<div class="text-sm text-gray-600">{{ user.email }}</div>
				<div class="text-sm text-gray-400">
					{{ user.address?.street }}, {{ user.address?.city }}
				</div>
			</div>
		</div>

		<div class="mt-4 flex justify-center space-x-2">
			<button v-for="page in users.links" :key="page.label" v-html="page.label" :disabled="!page.url"
				@click.prevent="page.url && router.visit(page.url)" class="px-3 py-1 border rounded text-sm" :class="{
					'bg-gray-200': page.active,
					'text-gray-400 cursor-not-allowed': !page.url,
				}"></button>
		</div>
	</div>
</template>
