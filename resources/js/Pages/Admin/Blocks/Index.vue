<script setup>
import { Form, Link } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";

defineProps({
    blocksByProject: Array,
});
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Bloques</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Gestiona todos los bloques agrupados por proyecto
                    </p>
                </div>
                <Link
                    :href="`/admin/blocks/create`"
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
                    Crear Bloque
                </Link>
            </div>
        </template>
        <template #default>
            <div class="space-y-6">
                <div
                    v-for="group in blocksByProject"
                    :key="group.project.id"
                    class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden"
                >
                    <!-- Project Header -->
                    <div
                        class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm"
                                >
                                    <svg
                                        class="w-5 h-5 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h2
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        {{ group.project.name }}
                                    </h2>
                                    <p class="text-sm text-gray-600">
                                        <span
                                            class="font-mono bg-blue-100 px-2 py-0.5 rounded text-blue-800"
                                        >
                                            {{ group.project.id }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                            >
                                {{ group.blocks.length }}
                                {{
                                    group.blocks.length === 1
                                        ? "Bloque"
                                        : "Bloques"
                                }}
                            </span>
                        </div>
                    </div>

                    <!-- Blocks Table -->
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
                                    v-for="block in group.blocks"
                                    :key="block.id"
                                    class="hover:bg-gray-50 transition-colors"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-gray-900"
                                    >
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-800"
                                        >
                                            {{ block.id }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ block.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm"
                                    >
                                        <div
                                            class="flex items-center justify-end gap-2"
                                        >
                                            <Link
                                                method="get"
                                                :href="`/admin/blocks/${block.id}/edit`"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                                            >
                                                Editar
                                            </Link>
                                            <Form
                                                method="DELETE"
                                                :action="`/admin/blocks/${block.id}`"
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

                <!-- Empty State -->
                <div
                    v-if="!blocksByProject || blocksByProject.length === 0"
                    class="text-center py-12"
                >
                    <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                        />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        No hay bloques
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Comienza creando un nuevo bloque.
                    </p>
                    <div class="mt-6">
                        <Link
                            :href="`/admin/blocks/create`"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
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
                            Crear Bloque
                        </Link>
                    </div>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
