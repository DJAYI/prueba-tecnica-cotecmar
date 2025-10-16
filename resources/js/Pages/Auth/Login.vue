<script setup>
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";

defineProps({
    errors: Object,
});

let form = reactive({
    email: "",
    password: "",
});

const submit = () => {
    router.post("/auth/login", form, { preserveState: true, replace: true });
};
</script>

<template>
    <div class="grid h-screen px-4 place-items-center max-w-2xl mx-auto border">
        <form
            @submit.prevent="submit"
            class="flex flex-col gap-4 w-full max-w-md"
        >
            <h1 class="text-4xl font-medium mb-8">Inicio de Sesion</h1>
            <div class="flex flex-col gap-2">
                <label for="email" class="text-lg font-medium">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    name="email"
                    required
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label for="password" class="text-lg font-medium"
                    >Password</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <button
                type="submit"
                class="mt-4 px-4 py-2 text-lg bg-black text-white rounded-md cursor-pointer hover:bg-gray-800 group inline relative ring-0 hover:ring-4 transition hover:ring-gray-300"
            >
                Login
            </button>

            <div v-if="errors" class="text-red-600">
                <ul>
                    <li v-for="(error, index) in errors" :key="index">
                        {{ error }}
                    </li>
                </ul>
            </div>
        </form>
    </div>
</template>
