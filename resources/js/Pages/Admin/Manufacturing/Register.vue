<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { reactive, ref, computed } from "vue";

const props = defineProps({
    piece: Object,
    projects: Array,
    blocks: Array,
});

const form = reactive({
    real_weight: "",
});

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
    if (form.real_weight && props.piece.theorical_weight) {
        return (
            parseFloat(form.real_weight) -
            parseFloat(props.piece.theorical_weight)
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
                        Registra los datos de fabricación de la pieza
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-1"
                        >
                            {{ piece.id }}
                        </span>
                    </p>
                </div>
                <Link
                    :href="`/admin/manufacturing`"
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
            <!-- Piece Info (Read-only) -->
            <div
                class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 mb-6 border border-blue-200"
            >
                <h2
                    class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2"
                >
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
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Información de la Pieza
                </h2>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label
                            class="block text-xs font-medium text-blue-700 mb-1"
                            >Proyecto</label
                        >
                        <input
                            type="text"
                            :value="piece.block?.project?.name"
                            readonly
                            disabled
                            class="w-full px-3 py-2 text-sm border border-blue-200 rounded-lg bg-white text-gray-700 cursor-not-allowed"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-medium text-blue-700 mb-1"
                            >Bloque</label
                        >
                        <input
                            type="text"
                            :value="`${piece.block?.id} - ${piece.block?.name}`"
                            readonly
                            disabled
                            class="w-full px-3 py-2 text-sm border border-blue-200 rounded-lg bg-white text-gray-700 cursor-not-allowed"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-medium text-blue-700 mb-1"
                            >Pieza</label
                        >
                        <input
                            type="text"
                            :value="`${piece.id} - ${piece.name}`"
                            readonly
                            disabled
                            class="w-full px-3 py-2 text-sm border border-blue-200 rounded-lg bg-white text-gray-700 cursor-not-allowed"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-xs font-medium text-blue-700 mb-1"
                            >Peso Teórico</label
                        >
                        <input
                            type="text"
                            :value="`${piece.theorical_weight} kg`"
                            readonly
                            disabled
                            class="w-full px-3 py-2 text-sm border border-blue-200 rounded-lg bg-white text-gray-700 cursor-not-allowed"
                        />
                    </div>
                </div>
            </div>

            <!-- Manufacturing Form -->
            <Form
                method="POST"
                :data="form"
                :action="`/admin/manufacturing/${piece.id}/complete`"
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
                    <!-- Read-only: Theoretical Weight (repeated for context) -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Peso Teórico (kg)
                        </label>
                        <input
                            type="text"
                            :value="piece.theorical_weight"
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
                                $page.props.auth?.user?.name || 'Usuario Actual'
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
                    class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200"
                >
                    <Link
                        :href="`/admin/manufacturing`"
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
            </Form>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
