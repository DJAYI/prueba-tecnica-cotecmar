<script setup>
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
</script>

<template>
    <DashboardLayout>
        <template #header>
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        </template>
        <template #default>
            <p>
                Welcome to the admin dashboard. Use the sidebar to navigate
                through different sections.
            </p>
        </template>
    </DashboardLayout>
</template>
