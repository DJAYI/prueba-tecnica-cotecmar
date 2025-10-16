<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4"
    >
        <div class="w-full max-w-md">
            <!-- Flash Messages -->
            <FlashMessages />

            <div
                class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 text-center"
            >
                <div class="mb-6">
                    <div
                        class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg"
                    >
                        <svg
                            class="w-8 h-8 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                            />
                        </svg>
                    </div>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Sistema COTECMAR
                </h1>
                <p class="text-gray-600 mb-8">Gestión de Proyectos Navales</p>

                <Link
                    href="/auth/login"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                >
                    Iniciar Sesión
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import FlashMessages from "../Components/FlashMessages.vue";
</script>
