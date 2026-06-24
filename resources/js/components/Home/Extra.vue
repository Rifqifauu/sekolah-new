<template>
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-12 text-center md:mb-16">
                <div class="mb-3 inline-flex items-center gap-3">
                    <span class="h-px w-8 bg-blue-600"></span>
                    <span
                        class="text-sm font-bold tracking-widest text-blue-700 uppercase"
                    >
                        Pengembangan Diri
                    </span>
                    <span class="h-px w-8 bg-blue-600"></span>
                </div>
                <h2
                    class="mb-4 text-3xl font-extrabold text-gray-900 sm:text-4xl"
                >
                    Ekstrakurikuler Unggulan
                </h2>
                <p class="mx-auto max-w-2xl text-base text-gray-600 sm:text-lg">
                    Kembangkan minat, bakat, dan potensimu melalui berbagai
                    pilihan kegiatan ekstrakurikuler yang aktif dan berprestasi
                    di sekolah kami.
                </p>
            </div>

            <!-- Grid 4 Kolom Ekstrakurikuler -->
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8"
            >
                <article
                    v-for="ekskul in extracurriculars"
                    :key="ekskul.id"
                    class="group relative flex flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-900/20"
                >
                    <!-- Gambar Banner -->
                    <div
                        class="relative aspect-[4/3] w-full overflow-hidden bg-gray-200"
                    >
                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 z-10 bg-gradient-to-t from-gray-900/80 via-gray-900/10 to-transparent opacity-40 transition-opacity duration-500 group-hover:opacity-70"
                        ></div>

                        <img
                            :src="ekskul.image"
                            :alt="ekskul.name"
                            class="h-full w-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110"
                        />

                        <!-- Floating Badge (Muncul saat hover) -->
                        <div
                            class="absolute top-4 right-4 z-20 translate-y-4 opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/30 bg-white/20 text-white backdrop-blur-md"
                            >
                                <i class="fa-solid fa-star text-sm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Konten Teks -->
                    <div
                        class="relative z-20 flex flex-1 flex-col bg-white p-6 pt-8"
                    >
                        <!-- Garis Aksen Dekoratif -->
                        <div
                            class="absolute top-0 left-6 h-1 w-12 rounded-b-md bg-blue-600 transition-all duration-500 group-hover:w-24"
                        ></div>

                        <h3
                            class="mb-3 text-xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-blue-700"
                        >
                            <a :href="ekskul.link" class="focus:outline-none">
                                <span
                                    class="absolute inset-0"
                                    aria-hidden="true"
                                ></span>
                                <!-- Clickable card -->
                                {{ ekskul.name }}
                            </a>
                        </h3>

                        <p
                            class="mb-6 line-clamp-3 text-sm leading-relaxed text-gray-600"
                        >
                            {{ ekskul.description }}
                        </p>

                        <!-- Area Aksi Bawah -->
                        <div
                            class="mt-auto flex items-center justify-between border-t border-gray-100 pt-5"
                        >
                            <span
                                class="text-sm font-semibold text-blue-600 transition-colors group-hover:text-blue-800"
                            >
                                Detail Profil
                            </span>
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-md group-hover:shadow-blue-500/30"
                            >
                                <i
                                    class="fa-solid fa-arrow-right-long -rotate-45 transition-transform duration-300 group-hover:rotate-0"
                                ></i>
                            </span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Tombol Lihat Semua -->
            <div class="mt-14 text-center md:mt-20">
                <a
                    href="/ekstrakurikuler"
                    class="group inline-flex items-center justify-center gap-3 rounded-full bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/40"
                >
                    Lihat Semua Ekstrakurikuler
                    <i
                        class="fa-solid fa-layer-group text-sm transition-transform group-hover:scale-110"
                    ></i>
                </a>
            </div>
        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue';

// Menggunakan props untuk 4 data cuplikan
const props = defineProps({
    extracurriculars: {
        type: Array,
        default: () => [
            {
                id: 1,
                name: 'Praja Muda Karana (Pramuka)',
                description:
                    'Melatih kemandirian, kedisiplinan, dan jiwa kepemimpinan melalui kegiatan kepanduan di alam terbuka.',
                image: 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                link: '/ekstrakurikuler/pramuka',
            },
            {
                id: 2,
                name: 'Pasukan Pengibar Bendera',
                description:
                    'Membentuk karakter disiplin, patriotisme, dan baris-berbaris yang tangguh untuk berbagai upacara resmi.',
                image: 'https://images.unsplash.com/photo-1533036814674-8848db2c90cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                link: '/ekstrakurikuler/paskibra',
            },
            {
                id: 3,
                name: 'Klub Bola Basket',
                description:
                    'Menyalurkan bakat olahraga basket dan membangun kerja sama tim yang solid untuk meraih juara.',
                image: 'https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                link: '/ekstrakurikuler/basket',
            },
            {
                id: 4,
                name: 'Palang Merah Remaja (PMR)',
                description:
                    'Membekali siswa dengan kemampuan pertolongan pertama dan menumbuhkan rasa kepedulian sosial.',
                image: 'https://images.unsplash.com/photo-1584516150909-c43483ebf62d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                link: '/ekstrakurikuler/pmr',
            },
        ],
    },
});
</script>
