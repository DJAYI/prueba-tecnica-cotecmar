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
                <h1 class="text-2xl font-semibold text-gray-900">
                    Editar Proyecto "{{ project.name }}"
                </h1>
                <Link
                    :href="`/admin/projects`"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150"
                >
                    Volver
                </Link>
            </div>
        </template>
        <template #default>
            <div class="mb-6">
                <p class="mt-1 text-lg text-gray-600">
                    Modifica los detalles del proyecto.
                </p>
            </div>
            <Form
                method="PUT"
                :action="`/admin/projects/${project.id}`"
                class="bg-white rounded-lg border border-gray-200 p-6"
            >
                <input type="hidden" name="_method" value="PUT" />
                <input type="hidden" name="_token" :value="csrf" />
                <div class="mb-4">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1"
                        >Nombre del Proyecto</label
                    >
                    <input
                        type="text"
                        id="name"
                        name="name"
                        v-model="project.name"
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </Form>
        </template>
    </DashboardLayout>
</template>

<style scoped></style>
