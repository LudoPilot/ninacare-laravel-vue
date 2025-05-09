<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex flex-col">

        <!-- Navbar -->
        <nav class="flex justify-end items-center p-6">
            <div v-if="canLogin" class="space-x-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:underline"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                    >
                        Login
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-grow flex flex-col justify-center items-center text-center px-4">
			<img
                src="./images/ninacare-banner.png"
                alt="User management illustration"
                class="w-72 md:w-96 mb-6 drop-shadow-lg"
            />
            <h1 class="text-4xl font-extrabold mb-4">Welcome to NINACARE</h1>
            <p class="text-lg mb-6 text-gray-600 dark:text-gray-300">
                Manage and explore millions of users with a fast and modern interface.
            </p>

            <div class="space-x-4">
                <Link
                    v-if="canLogin"
                    :href="route('login')"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Login
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                >
                    Register
                </Link>
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-6 text-sm text-gray-500 dark:text-gray-400">
            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
        </footer>
    </div>
</template>