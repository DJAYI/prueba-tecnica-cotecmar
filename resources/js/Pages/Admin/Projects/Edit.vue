<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";

import { ref } from "vue";
import { Form, Link, usePage } from "@inertiajs/vue3";

defineProps({
    project: Object,
});

const csrf = ref(usePage().props.csrf_token);
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Editar Proyecto
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Modifica la información del proyecto "{{
                            project.name
                        }}"
                    </p>
                </div>
                <Link
                    :href="`/admin/projects`"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all"
                >
                    <svg
                        class="w-4 h-4 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                    Cancelar
                </Link>
            </div>
        </template>
        <template #default>
            <Form
                method="PUT"
                :action="`/admin/projects/${project.id}`"
                class="space-y-6"
            >
                <input type="hidden" name="_method" value="PUT" />
                <input type="hidden" name="_token" :value="csrf" />

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label
                            for="id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            ID del Proyecto
                        </label>
                        <input
                            type="text"
                            id="id"
                            :value="project.id"
                            disabled
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed uppercase font-mono"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            El ID no puede ser modificado
                        </p>
                    </div>

                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nombre del Proyecto
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="project.name"
                            required
                            placeholder="Nombre del proyecto"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                    </div>
                </div>

                <div
                    class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200"
                >
                    <Link
                        :href="`/admin/projects`"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </Form>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
