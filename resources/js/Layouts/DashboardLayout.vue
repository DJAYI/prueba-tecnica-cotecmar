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
        ? "flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg transition-all"
        : "flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all";
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="flex">
            <!-- Sidebar -->
            <aside
                class="w-64 min-h-screen flex flex-col justify-between bg-white border-r border-gray-200 shadow-sm"
            >
                <div>
                    <div class="px-6 py-6 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md"
                            >
                                <svg
                                    class="w-6 h-6 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                    />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">
                                    Cotecmar
                                </h2>
                                <p class="text-xs text-gray-500">
                                    Administración
                                </p>
                            </div>
                        </div>
                    </div>
                    <nav class="px-3 py-4 space-y-1">
                        <Link href="/admin" :class="linkClass('/admin')">
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
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>
                            Panel de Control
                        </Link>
                        <Link
                            href="/admin/projects"
                            :class="linkClass('/admin/projects')"
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
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
                                />
                            </svg>
                            Proyectos
                        </Link>
                        <Link
                            href="/admin/blocks"
                            :class="linkClass('/admin/blocks')"
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
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                            Bloques
                        </Link>
                        <Link
                            href="/admin/pieces"
                            :class="linkClass('/admin/pieces')"
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
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                />
                            </svg>
                            Piezas
                        </Link>
                        <Link
                            href="/admin/manufacturing"
                            :class="linkClass('/admin/manufacturing')"
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
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                />
                            </svg>
                            Registrar Fabricación
                        </Link>
                        <Link
                            href="/admin/piece-reports"
                            :class="linkClass('/admin/piece-reports')"
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
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            Reportes de Piezas
                        </Link>
                    </nav>
                </div>
                <div class="px-3 pb-4 border-t border-gray-200 pt-4">
                    <Link
                        href="/auth/logout"
                        method="post"
                        as="button"
                        class="flex w-full cursor-pointer items-center gap-3 px-3 py-2.5 text-sm font-medium text-red-700 rounded-lg hover:bg-red-50 transition-all"
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
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                        Cerrar Sesión
                    </Link>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 max-h-screen overflow-auto p-6">
                <slot name="header"> </slot>
                <div
                    class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 mt-4"
                >
                    <slot name="default"></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<style></style>
