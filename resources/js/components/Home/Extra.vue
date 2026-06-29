<template>
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center md:mb-16">
                <div class="mb-3 inline-flex items-center gap-3">
                    <span class="h-px w-8 bg-blue-600"></span>
                    <span
                        class="text-sm font-bold tracking-widest text-blue-700 uppercase"
                        >Pengembangan Diri</span
                    >
                    <span class="h-px w-8 bg-blue-600"></span>
                </div>
                <h2
                    class="mb-4 text-3xl font-extrabold text-gray-900 sm:text-4xl"
                >
                    Ekstrakurikuler Unggulan
                </h2>
            </div>

            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8"
            >
                <article
                    v-for="ekskul in extracurriculars"
                    :key="ekskul.id"
                    @click="openModal(ekskul)"
                    class="group relative flex cursor-pointer flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl"
                >
                    <div
                        class="relative aspect-[4/3] w-full overflow-hidden bg-gray-200"
                    >
                        <img
                            :src="ekskul.image"
                            :alt="ekskul.name"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                    </div>
                    <div class="flex flex-1 flex-col p-6 pt-8">
                        <h3
                            class="mb-3 text-xl font-bold text-gray-900 group-hover:text-blue-700"
                        >
                            {{ ekskul.name }}
                        </h3>
                        <p class="mb-6 line-clamp-3 text-sm text-gray-600">
                            {{ ekskul.description }}
                        </p>
                        <div
                            class="mt-auto flex items-center justify-between border-t border-gray-100 pt-5"
                        >
                            <span class="text-sm font-semibold text-blue-600"
                                >Lihat Detail</span
                            >
                            <i
                                class="fa-solid fa-arrow-right-long -rotate-45 text-blue-600"
                            ></i>
                        </div>
                    </div>
                </article>
            </div>

            <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="showModal"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                >
                    <div
                        class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
                        @click="closeModal"
                    ></div>
                    <div
                        class="relative w-full max-w-lg rounded-3xl bg-white p-8 shadow-2xl"
                    >
                        <button
                            @click="closeModal"
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        >
                            <i class="fa-solid fa-xmark text-2xl"></i>
                        </button>
                        <img
                            :src="selectedEkskul.image"
                            class="mb-6 h-64 w-full rounded-2xl object-cover"
                        />
                        <h2 class="mb-4 text-2xl font-bold">
                            {{ selectedEkskul.name }}
                        </h2>
                        <p class="leading-relaxed text-gray-600">
                            {{ selectedEkskul.description }}
                        </p>
                    </div>
                </div>
            </transition>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    extracurriculars: {
        type: Array,
        default: () => [], // Default array kosong
    },
});

const showModal = ref(false);
const selectedEkskul = ref(null);

const openModal = (ekskul) => {
    selectedEkskul.value = ekskul;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedEkskul.value = null;
};
</script>
