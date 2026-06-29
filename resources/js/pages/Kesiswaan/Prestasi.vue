<template>
    <AppLayout>
        <div class="min-h-screen bg-slate-50 p-6">
            <div class="mx-auto max-w-6xl">
                <!-- Judul dengan efek gradien teks -->
                <div class="mt-4 mb-10 text-center">
                    <h1
                        class="mb-3 bg-gradient-to-r from-blue-800 to-blue-600 bg-clip-text text-4xl font-extrabold text-transparent"
                    >
                        Daftar Prestasi
                    </h1>
                    <p class="mx-auto max-w-2xl text-base text-slate-600">
                        Jejak langkah dan pencapaian membanggakan dari
                        siswa-siswi terbaik kami di berbagai ajang kompetisi.
                    </p>
                </div>

                <!-- Input Pencarian dengan Ikon FontAwesome -->
                <div class="relative mx-auto mb-10 max-w-xl">
                    <label for="search" class="sr-only">Cari prestasi</label>
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                    >
                        <i
                            class="fa-solid fa-magnifying-glass text-indigo-400"
                        ></i>
                    </div>
                    <input
                        id="search"
                        v-model="search"
                        @input="handleSearch"
                        type="text"
                        placeholder="Cari prestasi, kategori, atau level..."
                        class="w-full rounded-full border border-indigo-100 bg-white py-3.5 pr-4 pl-12 text-slate-700 shadow-sm transition-all outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                    />
                </div>

                <!-- Empty State (Jika Data Tidak Ditemukan) -->
                <div
                    v-if="!achievements.data || achievements.data.length === 0"
                    class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white py-20 text-center shadow-sm"
                >
                    <div class="mb-4 rounded-full bg-slate-50 p-5">
                        <i
                            class="fa-solid fa-medal text-5xl text-slate-300"
                        ></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">
                        Prestasi tidak ditemukan
                    </h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Coba sesuaikan kata kunci pencarian Anda.
                    </p>
                </div>

                <!-- Grid Prestasi -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3"
                >
                    <div
                        v-for="item in achievements.data"
                        :key="item.id"
                        role="button"
                        tabindex="0"
                        class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-indigo-50 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        @click="openModal(item)"
                        @keydown.enter="openModal(item)"
                    >
                        <!-- Garis gradien dekoratif di atas card yang muncul saat di-hover -->
                        <div
                            class="absolute top-0 left-0 h-1.5 w-full bg-gradient-to-r from-blue-600 to-blue-500 opacity-0 transition-opacity group-hover:opacity-100"
                        ></div>

                        <div class="mb-4 flex items-center justify-between">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-500 transition-colors group-hover:bg-indigo-500 group-hover:text-white"
                            >
                                <i class="fa-solid fa-trophy"></i>
                            </div>
                            <span
                                class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700"
                            >
                                {{ item.year }}
                            </span>
                        </div>

                        <h3
                            class="mb-3 line-clamp-2 text-lg font-bold text-slate-800 transition-colors group-hover:text-indigo-700"
                        >
                            {{ item.title }}
                        </h3>

                        <div class="mt-auto flex flex-wrap items-center gap-2">
                            <span
                                class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700"
                            >
                                {{ item.category }}
                            </span>
                            <span
                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600"
                            >
                                {{ item.level }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Paginasi (Jika menggunakan pagination dari Laravel) -->
                <div
                    v-if="achievements.links && achievements.links.length > 3"
                    class="mt-10 flex justify-center"
                >
                    <!-- Anda bisa menggunakan komponen Pagination bawaan Jetstream/Breeze di sini -->
                </div>

                <!-- Modal Animasi -->
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
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                    >
                        <!-- Latar belakang gelap dengan efek blur -->
                        <div
                            class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"
                            @click="closeModal"
                        ></div>

                        <!-- Konten Modal -->
                        <div
                            class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                        >
                            <!-- Tombol Silang (X) FontAwesome -->
                            <button
                                @click="closeModal"
                                class="absolute top-4 right-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition-colors hover:bg-rose-500 hover:text-white focus:ring-2 focus:ring-rose-400 focus:outline-none"
                                aria-label="Tutup modal"
                            >
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>

                            <div class="p-6 sm:p-8" v-if="selectedItem">
                                <h2
                                    class="mb-5 pr-8 text-2xl font-bold text-slate-800"
                                >
                                    {{ selectedItem.title }}
                                </h2>

                                <div
                                    v-if="selectedItem.image"
                                    class="mb-6 overflow-hidden rounded-xl border border-slate-100 shadow-sm"
                                >
                                    <img
                                        :src="`/storage/${selectedItem.image}`"
                                        :alt="selectedItem.title"
                                        class="h-56 w-full object-cover transition-transform duration-500 hover:scale-105"
                                    />
                                </div>

                                <!-- Detail Data (Grid Box) dengan Ikon FontAwesome -->
                                <div class="mb-8 grid grid-cols-2 gap-4">
                                    <div
                                        class="rounded-lg border border-indigo-100/50 bg-indigo-50/50 p-4"
                                    >
                                        <p
                                            class="mb-1 text-xs font-bold text-indigo-500 uppercase"
                                        >
                                            <i
                                                class="fa-solid fa-tags mr-1"
                                            ></i>
                                            Kategori
                                        </p>
                                        <p class="font-semibold text-slate-700">
                                            {{ selectedItem.category }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-lg border border-blue-100/50 bg-blue-50/50 p-4"
                                    >
                                        <p
                                            class="mb-1 text-xs font-bold text-blue-500 uppercase"
                                        >
                                            <i
                                                class="fa-solid fa-layer-group mr-1"
                                            ></i>
                                            Level
                                        </p>
                                        <p class="font-semibold text-slate-700">
                                            {{ selectedItem.level }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-lg border border-indigo-100/50 bg-indigo-50/50 p-4"
                                    >
                                        <p
                                            class="mb-1 text-xs font-bold text-indigo-500 uppercase"
                                        >
                                            <i
                                                class="fa-solid fa-medal mr-1"
                                            ></i>
                                            Peringkat
                                        </p>
                                        <p class="font-semibold text-slate-700">
                                            {{ selectedItem.rank }}
                                        </p>
                                    </div>
                                    <div
                                        class="rounded-lg border border-blue-100/50 bg-blue-50/50 p-4"
                                    >
                                        <p
                                            class="mb-1 text-xs font-bold text-blue-500 uppercase"
                                        >
                                            <i
                                                class="fa-regular fa-calendar-days mr-1"
                                            ></i>
                                            Tahun
                                        </p>
                                        <p class="font-semibold text-slate-700">
                                            {{ selectedItem.year }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Tombol Tutup -->
                                <button
                                    @click="closeModal"
                                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 px-4 py-3.5 font-bold text-white shadow-md transition-all duration-300 hover:from-blue-800 hover:to-blue-700 hover:shadow-lg focus:ring-4 focus:ring-blue-200 focus:outline-none"
                                >
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import AppLayout from '@/components/AppLayout.vue'; // Hapus ini jika Anda tidak menggunakan AppLayout

// Definisikan nilai default agar tidak error "undefined props"
const props = defineProps({
    achievements: {
        type: Object,
        default: () => ({ data: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

const search = ref(props.filters?.search || '');
const showModal = ref(false);
const selectedItem = ref(null);

const openModal = (item) => {
    selectedItem.value = item;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    // Beri sedikit jeda sebelum mengosongkan item agar transisi tutup modal smooth
    setTimeout(() => {
        selectedItem.value = null;
    }, 200);
};

// Menutup modal dengan tombol Escape
const handleEscape = (e) => {
    if (e.key === 'Escape' && showModal.value) {
        closeModal();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
});

// Fitur debounce pencarian
const handleSearch = debounce(() => {
    router.get(
        '/kesiswaan/prestasi', // Sesuaikan dengan route name / path Anda
        { search: search.value },
        { preserveState: true, replace: true },
    );
}, 300);
</script>
