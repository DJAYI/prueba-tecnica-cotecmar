<script setup>
import { Form, Link } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";

defineProps({
    projects: Array,
});
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Proyectos</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Gestiona todos los proyectos del sistema
                    </p>
                </div>
                <Link
                    :href="`/admin/projects/create`"
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Crear Proyecto
                </Link>
            </div>
        </template>
        <template #default>
            <div
                class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden"
            >
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    ID
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Nombre
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="project in projects"
                                :key="project.id"
                                class="hover:bg-gray-50 transition-colors"
                            >
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-gray-900"
                                >
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-800"
                                    >
                                        {{ project.id }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    {{ project.name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm"
                                >
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Link
                                            method="get"
                                            :href="`/admin/projects/${project.id}/edit`"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                                        >
                                            Editar
                                        </Link>
                                        <Form
                                            method="DELETE"
                                            :action="`/admin/projects/${project.id}`"
                                            class="inline"
                                        >
                                            <button
                                                type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer transition-all"
                                            >
                                                Eliminar
                                            </button>
                                        </Form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>
