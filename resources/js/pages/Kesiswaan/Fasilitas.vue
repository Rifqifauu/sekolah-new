<template>
    <AppLayout>
        <div class="min-h-screen bg-slate-50 p-6">
            <div class="mx-auto max-w-6xl">
                <div class="mt-4 mb-10 text-center">
                    <h1
                        class="mb-3 bg-gradient-to-r from-blue-800 to-blue-600 bg-clip-text text-4xl font-extrabold text-transparent"
                    >
                        Fasilitas Sekolah
                    </h1>
                    <p class="mx-auto max-w-xl text-base text-slate-600">
                        Kami menyediakan sarana dan prasarana terbaik untuk
                        mendukung kenyamanan belajar, kreativitas, dan
                        perkembangan bakat seluruh siswa.
                    </p>
                </div>

                <div class="mb-10 flex flex-wrap justify-center gap-2">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        @click="selectedCategory = cat"
                        :class="[
                            'rounded-full px-5 py-2.5 text-sm font-bold shadow-sm transition-all duration-300',
                            selectedCategory === cat
                                ? 'bg-gradient-to-r from-blue-700 to-blue-600 text-white shadow-md shadow-blue-200'
                                : 'border border-indigo-50 bg-white text-slate-600 hover:bg-indigo-50 hover:text-indigo-700',
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="(facility, index) in filteredFacilities"
                        :key="index"
                        @click="openModal(facility)"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-2xl border border-indigo-50 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                    >
                        <div class="relative h-48 overflow-hidden bg-slate-200">
                            <img
                                :src="facility.image"
                                :alt="facility.name"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <span
                                class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-indigo-800 shadow-sm backdrop-blur-sm"
                            >
                                {{ facility.category }}
                            </span>
                        </div>

                        <div class="flex flex-grow flex-col p-5">
                            <h3
                                class="mb-2 text-lg font-bold text-slate-800 transition-colors group-hover:text-indigo-700"
                            >
                                {{ facility.name }}
                            </h3>
                            <p
                                class="mb-4 line-clamp-2 flex-grow text-sm text-slate-600"
                            >
                                {{ facility.description }}
                            </p>
                            <div
                                class="flex items-center text-xs font-bold text-blue-600 group-hover:text-blue-700"
                            >
                                Lihat Detail
                                <svg
                                    class="ml-1 h-4 w-4 transform transition-transform group-hover:translate-x-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="filteredFacilities.length === 0"
                    class="py-12 text-center"
                >
                    <p class="font-medium text-slate-500">
                        Fasilitas tidak ditemukan.
                    </p>
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
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                    >
                        <div
                            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                            @click="showModal = false"
                        ></div>

                        <div
                            class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                        >
                            <div
                                class="relative h-64 w-full bg-slate-100 sm:h-72"
                            >
                                <img
                                    :src="selectedFacility.image"
                                    :alt="selectedFacility.name"
                                    class="h-full w-full object-cover"
                                />
                                <button
                                    @click="showModal = false"
                                    class="absolute top-4 right-4 rounded-full bg-slate-900/40 p-2 text-white backdrop-blur-sm transition-colors hover:bg-slate-900/70"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        ></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-6 sm:p-8">
                                <span
                                    class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700"
                                >
                                    {{ selectedFacility.category }}
                                </span>
                                <h2
                                    class="mt-2 mb-4 text-2xl font-bold text-slate-800"
                                >
                                    {{ selectedFacility.name }}
                                </h2>

                                <p
                                    class="mb-6 text-sm leading-relaxed text-slate-600"
                                >
                                    {{ selectedFacility.description }}
                                </p>

                                <div
                                    class="mb-6 grid grid-cols-2 gap-4 rounded-xl border border-indigo-100/50 bg-indigo-50/40 p-4"
                                >
                                    <div>
                                        <p
                                            class="mb-0.5 text-xs font-bold text-indigo-500 uppercase"
                                        >
                                            Kondisi
                                        </p>
                                        <p
                                            class="text-sm font-semibold text-slate-700"
                                        >
                                            Sangat Baik (Premium)
                                        </p>
                                    </div>
                                    <div>
                                        <p
                                            class="mb-0.5 text-xs font-bold text-blue-500 uppercase"
                                        >
                                            Akses Pengguna
                                        </p>
                                        <p
                                            class="text-sm font-semibold text-slate-700"
                                        >
                                            Guru & Siswa
                                        </p>
                                    </div>
                                </div>

                                <button
                                    @click="showModal = false"
                                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 px-4 py-3 font-bold text-white shadow-md transition-all duration-300 hover:from-blue-800 hover:to-blue-700 hover:shadow-lg focus:ring-4 focus:ring-blue-200"
                                >
                                    Kembali ke Daftar
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
import { ref, computed } from 'vue';
import AppLayout from '@/components/AppLayout.vue';

// Pilihan Kategori untuk Filter Tabs
const categories = ['Semua', 'Akademik', 'Olahraga & Seni', 'Fasilitas Umum'];
const selectedCategory = ref('Semua');

const showModal = ref(false);
const selectedFacility = ref(null);

// Data Statis Fasilitas (Silakan ganti URL gambar sesuai aset Anda)
const facilities = [
    {
        name: 'Ruang Kelas Digital',
        category: 'Akademik',
        description:
            'Seluruh ruang kelas telah dilengkapi dengan Interactive Smart Board, Proyektor HD, AC, serta akses internet kecepatan tinggi untuk mendukung pembelajaran interaktif abad 21.',
        image: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Laboratorium Komputer & AI',
        category: 'Akademik',
        description:
            'Laboratorium modern dengan komputer spesifikasi tinggi (Core i7, RAM 16GB) untuk mendukung praktik pemrograman, desain grafis, animasi, ujian CBT, serta riset teknologi.',
        image: 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Perpustakaan & Media Center',
        category: 'Akademik',
        description:
            'Menyediakan ribuan koleksi buku fisik, e-book portal, ruang baca lesehan yang nyaman, serta area iMac terminal untuk mempermudah literasi digital siswa.',
        image: 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Gedung Olahraga (GOR) Indoor',
        category: 'Olahraga & Seni',
        description:
            'Gedung olahraga tertutup serbaguna yang dapat digunakan untuk lapangan basket standar DBL, lapangan futsal, badminton, lengkap dengan tribun penonton.',
        image: 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Studio Musik & Rekaman',
        category: 'Olahraga & Seni',
        description:
            'Studio kedap suara yang dilengkapi instrumen musik lengkap (drum, gitar listrik, keyboard, bas) serta peralatan recording untuk menyalurkan bakat seni musik siswa.',
        image: 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Auditorium Utama',
        category: 'Fasilitas Umum',
        description:
            'Ruang aula besar dengan kapasitas hingga 1000 orang, dilengkapi panggung megah, sistem tata suara profesional (Sound System JBL), dan pencahayaan panggung modern.',
        image: 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Laboratorium Sains (Sains Terpadu)',
        category: 'Akademik',
        description:
            'Laboratorium eksperimen Fisika, Kimia, dan Biologi dengan alat peraga lengkap, mikroskop digital, serta sistem keamanan laboratorium standar industri.',
        image: 'https://images.unsplash.com/photo-1532187863486-abf9d39d6618?auto=format&fit=crop&q=80&w=800',
    },
    {
        name: 'Kantin Sehat & Eco-Green',
        category: 'Fasilitas Umum',
        description:
            'Kantin semi-outdoor yang bersih dan asri, menyajikan makanan higienis bersertifikasi sehat dengan sistem pembayaran non-tunai (cashless).',
        image: 'https://images.unsplash.com/photo-1574966739982-2b7839c05493?auto=format&fit=crop&q=80&w=800',
    },
];

// Logika Filter Menggunakan Computed Property
const filteredFacilities = computed(() => {
    if (selectedCategory.value === 'Semua') {
        return facilities;
    }
    return facilities.filter((f) => f.category === selectedCategory.value);
});

const openModal = (facility) => {
    selectedFacility.value = facility;
    showModal.value = true;
};
</script>
