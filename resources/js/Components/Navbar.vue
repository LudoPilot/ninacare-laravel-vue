<script setup lang="ts">
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Typage de l'utilisateur
interface User { id: number; first_name: string; last_name: string; email: string; }
interface Props { auth: { user: User };[key: string]: any; }
const page = usePage<Props>() as ReturnType<typeof usePage> & { props: Props };
const user = page.props.auth.user;
const showingNavigationDropdown = ref(false);
</script>

<template>
	<nav class="bg-white border-b border-gray-100">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between h-16">
				<!-- Logo and app name -->
				<div class="flex items-center">
					<Link href="/" class="inline-flex items-center space-x-2">
					<ApplicationLogo class="h-8 w-auto text-gray-800" />
					<span class="text-xl font-bold text-gray-800">MyAPP</span>
					</Link>
				</div>

				<!-- Desktop links (only when authenticated) -->
				<div v-if="user" class="hidden sm:flex sm:items-center sm:space-x-4">
					<Link href="/"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900">
					Home
					</Link>
					<Link :href="route('about')"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900">
					About
					</Link>
					<Link :href="route('dashboard')"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900">
					Dashboard
					</Link>
					<Link :href="route('users.index')"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900">
					Find Users
					</Link>
					<Link :href="route('profile.edit')"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900">
					Profile
					</Link>
				</div>

				<!-- Profile + Logout (when authenticated) -->
				<div v-if="user" class="hidden sm:flex sm:items-center sm:space-x-4">
					<span class="text-gray-700">
						Welcome, {{ user.first_name }} {{ user.last_name }}
					</span>
					<Link :href="route('logout')" method="post" as="button"
						class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
					Logout
					</Link>
				</div>

				<!-- Hamburger (toggle)  -->
				<div class="-mr-2 flex items-center sm:hidden">
					<button @click="showingNavigationDropdown = !showingNavigationDropdown"
						class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
						<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
							<path
								:class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
								stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16" />
							<path
								:class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
								stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Mobile menu -->
		<div v-show="showingNavigationDropdown" class="sm:hidden border-t border-gray-200">
			<div class="pt-2 pb-3 space-y-1">
				<Link href="/"
					class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700 text-base font-medium">
				Home
				</Link>
				<Link v-if="user" :href="route('dashboard')"
					class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">
				Dashboard
				</Link>
				<Link v-if="user" :href="route('users.index')"
					class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">
				Find Users
				</Link>
				<Link v-if="user" :href="route('profile.edit')"
					class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">
				Profile
				</Link>
				<Link v-if="user" :href="route('logout')" method="post" as="button"
					class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">
				Logout
				</Link>
			</div>
			<div v-if="user" class="pt-4 pb-1 border-t border-gray-200">
				<div class="px-4">
					<div class="font-medium text-base text-gray-800">{{ user.first_name }} {{ user.last_name }}</div>
					<div class="text-sm text-gray-500">{{ user.email }}</div>
				</div>
			</div>
		</div>
	</nav>
</template>