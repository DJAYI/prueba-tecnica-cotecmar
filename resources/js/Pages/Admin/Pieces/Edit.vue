<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { reactive, ref, computed, watch } from "vue";
import axios from "axios";

const props = defineProps({
    piece: Object,
    projects: Array,
    blocks: Array,
});

// Form state
const form = reactive({
    real_weight: props.piece.real_weight || "",
    status: "manufactured",
});

// Filter state
const selectedProjectId = ref("");
const selectedBlockId = ref("");
const selectedPieceId = ref(props.piece.id);

const availableBlocks = ref([]);
const availablePieces = ref([]);
const selectedPiece = ref(props.piece);

const csrf = ref(usePage().props.csrf_token);
const currentDateTime = ref(
    new Date().toLocaleString("es-CO", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    })
);

// Computed properties
const difference = computed(() => {
    if (form.real_weight && selectedPiece.value?.theorical_weight) {
        return (
            parseFloat(form.real_weight) -
            parseFloat(selectedPiece.value.theorical_weight)
        ).toFixed(2);
    }
    return "0.00";
});

const differenceClass = computed(() => {
    const diff = parseFloat(difference.value);
    if (diff > 0) return "text-red-600 bg-red-50";
    if (diff < 0) return "text-green-600 bg-green-50";
    return "text-gray-900 bg-gray-50";
});

// Watch for project selection
watch(selectedProjectId, async (newProjectId) => {
    if (!newProjectId) {
        availableBlocks.value = [];
        selectedBlockId.value = "";
        return;
    }

    try {
        const response = await axios.get(
            `/admin/pieces/api/blocks/${newProjectId}`
        );
        availableBlocks.value = response.data;
        selectedBlockId.value = "";
        selectedPieceId.value = "";
        availablePieces.value = [];
    } catch (error) {
        console.error("Error loading blocks:", error);
    }
});

// Watch for block selection
watch(selectedBlockId, async (newBlockId) => {
    if (!newBlockId) {
        availablePieces.value = [];
        selectedPieceId.value = "";
        return;
    }

    try {
        const response = await axios.get(
            `/admin/pieces/api/pieces/${newBlockId}`
        );
        availablePieces.value = response.data;
        selectedPieceId.value = "";
    } catch (error) {
        console.error("Error loading pieces:", error);
    }
});

// Watch for piece selection
watch(selectedPieceId, (newPieceId) => {
    if (!newPieceId) {
        selectedPiece.value = null;
        form.real_weight = "";
        return;
    }

    const piece = availablePieces.value.find((p) => p.id === newPieceId);
    if (piece) {
        selectedPiece.value = piece;
        form.real_weight = "";
    }
});

// Initialize with current piece data
if (props.piece.block) {
    selectedProjectId.value = props.piece.block.project_id;
    selectedBlockId.value = props.piece.block_id;
    selectedPieceId.value = props.piece.id;
}
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
                        Registra los datos de fabricación de una pieza pendiente
                    </p>
                </div>
                <Link
                    :href="`/admin/pieces`"
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
                    Volver
                </Link>
            </div>
        </template>

        <template #default>
            <div class="space-y-6">
                <!-- Filters Section -->
                <div class="bg-white rounded-lg shadow-sm p-6">
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
                        Seleccionar Pieza
                    </h2>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
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
                                <option value="">Selecciona un proyecto</option>
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
                                <option value="">Selecciona un bloque</option>
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

                        <div>
                            <label
                                for="piece_id"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Pieza (Solo Pendientes)
                            </label>
                            <select
                                id="piece_id"
                                v-model="selectedPieceId"
                                :disabled="
                                    !selectedBlockId ||
                                    availablePieces.length === 0
                                "
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed"
                            >
                                <option value="">Selecciona una pieza</option>
                                <option
                                    v-for="piece in availablePieces"
                                    :key="piece.id"
                                    :value="piece.id"
                                >
                                    {{ piece.id }} - {{ piece.name }} ({{
                                        piece.theorical_weight
                                    }}
                                    kg)
                                </option>
                            </select>
                            <p
                                v-if="
                                    selectedBlockId &&
                                    availablePieces.length === 0
                                "
                                class="mt-1 text-xs text-amber-600"
                            >
                                No hay piezas pendientes
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <Form
                    v-if="selectedPiece"
                    method="POST"
                    :data="form"
                    :action="`/admin/pieces/${selectedPieceId}`"
                    class="bg-white rounded-lg shadow-sm p-6 space-y-6"
                >
                    <input type="hidden" name="_token" :value="csrf" />
                    <input type="hidden" name="_method" value="PUT" />

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
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        Datos de Fabricación
                    </h2>

                    <div
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <!-- Read-only: Theoretical Weight -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Peso Teórico (kg)
                            </label>
                            <input
                                type="text"
                                :value="selectedPiece.theorical_weight"
                                readonly
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-700 cursor-not-allowed"
                            />
                            <p class="mt-2 text-xs text-gray-500">
                                <svg
                                    class="w-3 h-3 inline"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Cargado automáticamente
                            </p>
                        </div>

                        <!-- Editable: Real Weight -->
                        <div>
                            <label
                                for="real_weight"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Peso Real (kg) *
                            </label>
                            <input
                                type="number"
                                id="real_weight"
                                name="real_weight"
                                placeholder="1450.75"
                                step="0.01"
                                min="0"
                                v-model="form.real_weight"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            />
                            <p class="mt-2 text-xs text-gray-500">
                                Peso real medido
                            </p>
                        </div>

                        <!-- Read-only: Calculated Difference -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Diferencia (kg)
                            </label>
                            <input
                                type="text"
                                :value="difference"
                                readonly
                                :class="[
                                    differenceClass,
                                    'w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm font-semibold cursor-not-allowed',
                                ]"
                            />
                            <p class="mt-2 text-xs text-gray-500">
                                <svg
                                    class="w-3 h-3 inline"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                    />
                                </svg>
                                Calculado automáticamente
                            </p>
                        </div>

                        <!-- Read-only: Manufacturing DateTime -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Fecha y Hora de Registro
                            </label>
                            <input
                                type="text"
                                :value="currentDateTime"
                                readonly
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-700 cursor-not-allowed"
                            />
                            <p class="mt-2 text-xs text-gray-500">
                                <svg
                                    class="w-3 h-3 inline"
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
                                Hora del sistema
                            </p>
                        </div>

                        <!-- Read-only: Current User -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Usuario que Registra
                            </label>
                            <input
                                type="text"
                                :value="
                                    $page.props.auth?.user?.name ||
                                    'Usuario Actual'
                                "
                                readonly
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-700 cursor-not-allowed"
                            />
                            <p class="mt-2 text-xs text-gray-500">
                                <svg
                                    class="w-3 h-3 inline"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                Usuario logueado
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between pt-4 border-t border-gray-200"
                    >
                        <Form
                            method="POST"
                            :action="`/admin/pieces/${selectedPieceId}`"
                            @submit.prevent="$event.target.submit()"
                        >
                            <input type="hidden" name="_token" :value="csrf" />
                            <input
                                type="hidden"
                                name="_method"
                                value="DELETE"
                            />
                            <button
                                type="submit"
                                onclick="return confirm('¿Estás seguro de eliminar esta pieza?')"
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
                                :href="`/admin/pieces`"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition"
                            >
                                Cancelar
                            </Link>
                            <button
                                type="submit"
                                :disabled="!form.real_weight"
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
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
                                Registrar Fabricación
                            </button>
                        </div>
                    </div>
                </Form>

                <!-- No Selection State -->
                <div
                    v-else
                    class="bg-white rounded-lg shadow-sm p-12 text-center"
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
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                        />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        Selecciona una pieza pendiente
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Usa los filtros de arriba para seleccionar el proyecto,
                        bloque y pieza que deseas registrar.
                    </p>
                </div>
            </div>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
