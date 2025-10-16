<script setup>
import { Form, Link, usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { reactive, ref } from "vue";

defineProps({
    blocks: Array,
});

const form = reactive({
    name: "",
    theorical_weight: "",
    block_id: "",
});

const csrf = ref(usePage().props.csrf_token);
</script>

<template>
    <DashboardLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Crear Pieza
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Crea una nueva pieza en estado pendiente
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
                    Cancelar
                </Link>
            </div>
        </template>
        <template #default>
            <Form
                method="POST"
                :data="form"
                :action="`/admin/pieces`"
                class="space-y-6"
            >
                <input type="hidden" name="_token" :value="csrf" />

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nombre de la Pieza
                        </label>
                        <input
                            type="text"
                            id="name"
                            placeholder="ABC"
                            name="name"
                            maxlength="3"
                            v-model="form.name"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition uppercase"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            Máximo 3 caracteres
                        </p>
                    </div>

                    <div>
                        <label
                            for="theorical_weight"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Peso Teórico (kg)
                        </label>
                        <input
                            type="number"
                            id="theorical_weight"
                            placeholder="1500.50"
                            name="theorical_weight"
                            step="0.01"
                            min="0"
                            v-model="form.theorical_weight"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            Peso esperado de la pieza
                        </p>
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
                            name="block_id"
                            v-model="form.block_id"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="" disabled>
                                Selecciona un bloque
                            </option>
                            <option
                                v-for="block in blocks"
                                :key="block.id"
                                :value="block.id"
                            >
                                {{ block.id }} -
                                {{ block.project?.name || "N/A" }}
                            </option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500">
                            Bloque al que pertenece
                        </p>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200"
                >
                    <Link
                        :href="`/admin/pieces`"
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
                        Crear Pieza
                    </button>
                </div>
            </Form>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
