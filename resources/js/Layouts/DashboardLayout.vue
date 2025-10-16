<script setup>
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const isActive = (path) => {
    // Para el dashboard principal, debe ser exacto
    if (path === "/admin") {
        return page.url === "/admin";
    }
    // Para las demás rutas, verifica que comience con el path
    return page.url.startsWith(path);
};

const linkClass = (path) => {
    return isActive(path)
        ? "flex items-center px-3 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md transition-colors"
        : "flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors";
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="flex">
            <!-- Sidebar -->
            <aside
                class="w-64 min-h-screen flex flex-col justify-between bg-white border-r border-gray-200"
            >
                <div class="px-6 py-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Administración
                    </h2>
                </div>
                <nav class="px-3 space-y-1">
                    <Link href="/admin" :class="linkClass('/admin')">
                        Panel de Control
                    </Link>
                    <Link
                        href="/admin/projects"
                        :class="linkClass('/admin/projects')"
                    >
                        Proyectos
                    </Link>
                    <Link
                        href="/admin/blocks"
                        :class="linkClass('/admin/blocks')"
                    >
                        Bloques
                    </Link>
                    <Link
                        href="/admin/pieces"
                        :class="linkClass('/admin/pieces')"
                    >
                        Piezas
                    </Link>
                    <Link
                        href="/admin/piece-reports"
                        :class="linkClass('/admin/piece-reports')"
                    >
                        Reportes de Piezas
                    </Link>
                </nav>
                <div class="px-3 mt-auto pb-6">
                    <Link
                        href="/auth/logout"
                        method="post"
                        as="button"
                        class="flex w-full cursor-pointer items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors"
                    >
                        Cerrar Sesión
                    </Link>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 max-h-screen overflow-auto p-6">
                <slot name="header"> </slot>
                <div class="bg-white shadow-sm rounded-lg p-6 mt-4">
                    <slot name="default"></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<style></style>
