<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 transform translate-y-2"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 transform translate-y-0"
        leave-to-class="opacity-0 transform translate-y-2"
    >
        <div v-if="show" class="mb-6">
            <!-- Success Messages -->
            <div
                v-if="$page.props.flash?.success"
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3"
            >
                <svg
                    class="w-5 h-5 text-green-500 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span>{{ $page.props.flash.success }}</span>
                <button
                    @click="dismiss"
                    class="ml-auto text-green-500 hover:text-green-700"
                >
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>

            <!-- Error Messages -->
            <div
                v-if="$page.props.flash?.error"
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-3"
            >
                <svg
                    class="w-5 h-5 text-red-500 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span>{{ $page.props.flash.error }}</span>
                <button
                    @click="dismiss"
                    class="ml-auto text-red-500 hover:text-red-700"
                >
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>

            <!-- Info/Message Messages -->
            <div
                v-if="$page.props.flash?.message"
                class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg flex items-center gap-3"
            >
                <svg
                    class="w-5 h-5 text-blue-500 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"
                    />
                </svg>
                <span>{{ $page.props.flash.message }}</span>
                <button
                    @click="dismiss"
                    class="ml-auto text-blue-500 hover:text-blue-700"
                >
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>

            <!-- Validation Errors -->
            <div
                v-if="
                    $page.props.errors &&
                    Object.keys($page.props.errors).length > 0
                "
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg"
            >
                <div class="flex items-center gap-3 mb-2">
                    <svg
                        class="w-5 h-5 text-red-500 flex-shrink-0"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <span class="font-medium"
                        >Por favor, corrija los siguientes errores:</span
                    >
                    <button
                        @click="dismiss"
                        class="ml-auto text-red-500 hover:text-red-700"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    <li
                        v-for="(error, field) in $page.props.errors"
                        :key="field"
                    >
                        {{ Array.isArray(error) ? error[0] : error }}
                    </li>
                </ul>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

const show = ref(false);
const page = usePage();

// Show messages when they exist
const checkForMessages = () => {
    const hasFlash =
        page.props.flash &&
        (page.props.flash.success ||
            page.props.flash.error ||
            page.props.flash.message);
    const hasErrors =
        page.props.errors && Object.keys(page.props.errors).length > 0;

    show.value = hasFlash || hasErrors;

    if (page.props.flash?.success) {
        setTimeout(() => {
            show.value = false;
        }, 2000);
    }
};

// Manually dismiss message
const dismiss = () => {
    show.value = false;
};

// Watch for changes in flash messages
watch(() => page.props.flash, checkForMessages, { deep: true });
watch(() => page.props.errors, checkForMessages, { deep: true });

onMounted(checkForMessages);
</script>
