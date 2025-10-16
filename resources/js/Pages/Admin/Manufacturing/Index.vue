<script setup>
import { Link } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    projects: Array,
});

const selectedProjectId = ref("");
const selectedBlockId = ref("");
const availableBlocks = ref([]);
const availablePieces = ref([]);

// Watch for project selection
watch(selectedProjectId, async (newProjectId) => {
    if (!newProjectId) {
        availableBlocks.value = [];
        selectedBlockId.value = "";
        availablePieces.value = [];
        return;
    }

    try {
        const response = await axios.get(
            `/admin/pieces/api/blocks/${newProjectId}`
        );
        availableBlocks.value = response.data;
        selectedBlockId.value = "";
        availablePieces.value = [];
    } catch (error) {
        console.error("Error loading blocks:", error);
    }
});

// Watch for block selection
watch(selectedBlockId, async (newBlockId) => {
    if (!newBlockId) {
        availablePieces.value = [];
        return;
    }

    try {
        const response = await axios.get(
            `/admin/pieces/api/pieces/${newBlockId}`
        );
        availablePieces.value = response.data;
    } catch (error) {
        console.error("Error loading pieces:", error);
    }
});
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Registrar Fabricación
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Selecciona una pieza pendiente para registrar su
                        fabricación
                    </p>
                </div>
            </div>
        </template>

        <template #default>
            <!-- Filters Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2
                    class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2"
                >
                    <svg
                        class="w-5 h-5 text-blue-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                        />
                    </svg>
                    Filtrar Piezas Pendientes
                </h2>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label
                            for="project_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Proyecto
                        </label>
                        <select
                            id="project_id"
                            v-model="selectedProjectId"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="">Todos los proyectos</option>
                            <option
                                v-for="project in projects"
                                :key="project.id"
                                :value="project.id"
                            >
                                {{ project.id }} - {{ project.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="block_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Bloque
                        </label>
                        <select
                            id="block_id"
                            v-model="selectedBlockId"
                            :disabled="
                                !selectedProjectId ||
                                availableBlocks.length === 0
                            "
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed"
                        >
                            <option value="">Todos los bloques</option>
                            <option
                                v-for="block in availableBlocks"
                                :key="block.id"
                                :value="block.id"
                            >
                                {{ block.id }} - {{ block.name }}
                            </option>
                        </select>
                        <p
                            v-if="
                                selectedProjectId &&
                                availableBlocks.length === 0
                            "
                            class="mt-1 text-xs text-amber-600"
                        >
                            No hay bloques disponibles
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pieces Table -->
            <div
                v-if="availablePieces.length > 0"
                class="bg-white rounded-lg shadow overflow-hidden"
            >
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
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Bloque
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Proyecto
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Peso Teórico
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
                            v-for="piece in availablePieces"
                            :key="piece.id"
                            class="hover:bg-gray-50 transition-colors"
                        >
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900"
                            >
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ piece.id }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ piece.name }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ piece.block?.id }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ piece.block?.project?.name }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ piece.theorical_weight }} kg
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <Link
                                    :href="`/admin/manufacturing/${piece.id}/register`"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                                >
                                    <svg
                                        class="w-4 h-4 mr-1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                        />
                                    </svg>
                                    Registrar
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty state -->
            <div v-else class="bg-white rounded-lg shadow-sm p-12 text-center">
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    {{
                        selectedBlockId
                            ? "No hay piezas pendientes en este bloque"
                            : "Selecciona un proyecto y bloque"
                    }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{
                        selectedBlockId
                            ? "Todas las piezas ya han sido fabricadas."
                            : "Usa los filtros de arriba para ver las piezas pendientes."
                    }}
                </p>
            </div>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
