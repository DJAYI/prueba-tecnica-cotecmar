<script setup>
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";

defineProps({
    errors: Object,
});

let form = reactive({
    email: "",
    password: "",
});

const submit = () => {
    router.post("/auth/login", form, { preserveState: true, replace: true });
};
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center px-4 py-12"
    >
        <div class="w-full max-w-md">
            <div
                class="bg-white rounded-xl shadow-lg border border-gray-200 p-8"
            >
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Iniciar Sesión
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Ingresa tus credenciales para acceder al sistema
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Correo Electrónico
                        </label>
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            name="email"
                            required
                            placeholder="correo@ejemplo.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Contraseña
                        </label>
                        <input
                            v-model="form.password"
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                    </div>

                    <div
                        v-if="errors && Object.keys(errors).length > 0"
                        class="rounded-lg bg-red-50 border border-red-200 p-4"
                    >
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-5 w-5 text-red-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Error al iniciar sesión
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li
                                            v-for="(error, index) in errors"
                                            :key="index"
                                        >
                                            {{ error }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                    >
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
