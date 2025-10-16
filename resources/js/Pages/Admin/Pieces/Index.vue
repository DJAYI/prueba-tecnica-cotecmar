<script setup>
import { Link } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { ref, computed } from "vue";

const props = defineProps({
    piecesByStatus: Object,
    projects: Array,
});

const activeTab = ref("pending");

const currentPieces = computed(() => {
    return props.piecesByStatus[activeTab.value] || [];
});

const getStatusBadgeClass = (status) => {
    return status === "pending"
        ? "bg-yellow-100 text-yellow-800"
        : "bg-green-100 text-green-800";
};

const getStatusText = (status) => {
    return status === "pending" ? "Pendiente" : "Fabricada";
};
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Piezas</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Gestiona las piezas del sistema
                    </p>
                </div>
                <Link
                    :href="`/admin/pieces/create`"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
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
                    Nueva Pieza
                </Link>
            </div>
        </template>

        <template #default>
            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button
                        @click="activeTab = 'pending'"
                        :class="[
                            activeTab === 'pending'
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all',
                        ]"
                    >
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Pendientes
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                            >
                                {{ piecesByStatus.pending.length }}
                            </span>
                        </div>
                    </button>

                    <button
                        @click="activeTab = 'manufactured'"
                        :class="[
                            activeTab === 'manufactured'
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all',
                        ]"
                    >
                        <div class="flex items-center gap-2">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            Fabricadas
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                            >
                                {{ piecesByStatus.manufactured.length }}
                            </span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Table -->
            <div
                v-if="currentPieces.length > 0"
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
                                v-if="activeTab === 'manufactured'"
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Peso Real
                            </th>
                            <th
                                v-if="activeTab === 'manufactured'"
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Diferencia
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Estado
                            </th>
                            <th
                                v-if="activeTab === 'manufactured'"
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Manufacturado por
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
                            v-for="piece in currentPieces"
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
                                v-if="activeTab === 'manufactured'"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ piece.real_weight }} kg
                            </td>
                            <td
                                v-if="activeTab === 'manufactured'"
                                class="px-6 py-4 whitespace-nowrap text-sm"
                                :class="
                                    (parseFloat(piece.real_weight) -
                                        parseFloat(piece.theorical_weight) ||
                                        0) > 0
                                        ? 'text-red-600'
                                        : (parseFloat(piece.real_weight) -
                                              parseFloat(
                                                  piece.theorical_weight
                                              ) || 0) < 0
                                        ? 'text-green-600'
                                        : 'text-gray-900'
                                "
                            >
                                {{
                                    (parseFloat(piece.real_weight) -
                                        parseFloat(piece.theorical_weight) ||
                                        0) > 0
                                        ? "+"
                                        : ""
                                }}{{
                                    (
                                        parseFloat(piece.real_weight) -
                                            parseFloat(
                                                piece.theorical_weight
                                            ) || 0
                                    ).toFixed(2)
                                }}
                                kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="getStatusBadgeClass(piece.status)"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                >
                                    {{ getStatusText(piece.status) }}
                                </span>
                            </td>
                            <td
                                v-if="activeTab === 'manufactured'"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ piece.user.name || "N/A" }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end gap-2"
                                >
                                    <Link
                                        v-if="activeTab === 'pending'"
                                        :href="`/admin/pieces/${piece.id}/edit`"
                                        class="text-gray-600 hover:text-gray-900 transition-colors"
                                        title="Editar pieza"
                                    >
                                        <svg
                                            class="w-5 h-5 inline"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                    </Link>
                                    <Link
                                        v-if="activeTab === 'pending'"
                                        :href="`/admin/manufacturing/${piece.id}/register`"
                                        class="text-blue-600 hover:text-blue-900 transition-colors"
                                        title="Registrar fabricación"
                                    >
                                        <svg
                                            class="w-5 h-5 inline"
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
                                    </Link>
                                    <span
                                        v-if="activeTab === 'manufactured'"
                                        class="text-gray-400"
                                        title="No se puede editar piezas fabricadas"
                                    >
                                        <svg
                                            class="w-5 h-5 inline"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                            />
                                        </svg>
                                    </span>
                                </div>
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
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No hay piezas
                    {{ activeTab === "pending" ? "pendientes" : "fabricadas" }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Comienza creando una nueva pieza.
                </p>
                <div class="mt-6">
                    <Link
                        :href="`/admin/pieces/create`"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
                        Nueva Pieza
                    </Link>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
