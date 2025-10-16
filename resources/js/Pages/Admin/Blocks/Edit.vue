<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { reactive, ref } from "vue";

const props = defineProps({
    block: Object,
    projects: Array,
});

const form = reactive({
    id: props.block.id,
    name: props.block.name,
    project_id: props.block.project_id,
});

const csrf = ref(usePage().props.csrf_token);
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Editar Bloque
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Modifica la información del bloque
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ block.id }}
                        </span>
                    </p>
                </div>
                <Link
                    :href="`/admin/blocks`"
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
                method="POST"
                :data="form"
                :action="`/admin/blocks/${block.id}`"
                class="space-y-6"
            >
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="_method" value="PUT" />

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label
                            for="id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            ID del Bloque
                        </label>
                        <input
                            type="text"
                            v-model="form.id"
                            id="id"
                            name="id"
                            disabled
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed uppercase"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            El ID no puede modificarse
                        </p>
                    </div>

                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nombre del Bloque
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            maxlength="4"
                            v-model="form.name"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            Máximo 4 caracteres
                        </p>
                    </div>

                    <div>
                        <label
                            for="project_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Proyecto
                        </label>
                        <select
                            id="project_id"
                            name="project_id"
                            v-model="form.project_id"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="" disabled>
                                Selecciona un proyecto
                            </option>
                            <option
                                v-for="project in projects"
                                :key="project.id"
                                :value="project.id"
                            >
                                {{ project.id }} - {{ project.name }}
                            </option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500">
                            Proyecto al que pertenece
                        </p>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between pt-4 border-t border-gray-200"
                >
                    <Form
                        method="POST"
                        :action="`/admin/blocks/${block.id}`"
                        @submit.prevent="$event.target.submit()"
                    >
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="_method" value="DELETE" />
                        <button
                            type="submit"
                            onclick="return confirm('¿Estás seguro de eliminar este bloque?')"
                            class="inline-flex items-center px-4 py-2 border border-red-300 rounded-lg shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all"
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
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>
                            Eliminar
                        </button>
                    </Form>
                    <div class="flex items-center gap-3">
                        <Link
                            :href="`/admin/blocks`"
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
                </div>
            </Form>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
