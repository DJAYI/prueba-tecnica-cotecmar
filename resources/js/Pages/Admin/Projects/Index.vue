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
            <h1 class="text-2xl font-semibold text-gray-900">Proyectos</h1>
        </template>
        <template #default>
            <div class="mb-6">
                <p class="mt-1 text-lg text-gray-600">
                    Gestiona todos los proyectos del sistema.
                </p>
            </div>
            <div
                class="bg-white rounded-lg border border-gray-200 overflow-hidden"
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
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                >
                                    {{ project.id }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                >
                                    {{ project.name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                >
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <Link
                                            method="get"
                                            :href="`/admin/projects/${project.id}/edit`"
                                            class="px-3 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition-colors font-medium"
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
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-colors font-medium cursor-pointer"
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
