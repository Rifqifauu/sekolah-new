<template>
    <section class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Bagian Header Section -->
            <div
                class="mb-12 flex flex-col items-center justify-between gap-4 sm:flex-row md:mb-16"
            >
                <div>
                    <div class="mb-2 inline-flex items-center gap-3">
                        <span class="h-px w-8 bg-blue-600"></span>
                        <span
                            class="text-sm font-bold tracking-widest text-blue-700 uppercase"
                            >Informasi Terkini</span
                        >
                    </div>
                    <h2
                        class="text-3xl font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Berita & Artikel
                    </h2>
                </div>
                <a
                    href="/berita"
                    class="group inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 shadow-sm ring-1 ring-gray-200 transition-all ring-inset hover:bg-blue-50 hover:ring-blue-200"
                >
                    Lihat Semua Berita
                    <i
                        class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"
                    ></i>
                </a>
            </div>

            <!-- Main Layout: Grid Kiri (Headline) & Kanan (List) -->
            <div
                v-if="post.length > 0"
                class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-12"
            >
                <!-- KIRI: Headline Article (Berita Utama) -->
                <!-- Mengambil 7 kolom di desktop -->
                <article
                    v-if="featuredArticle"
                    class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl lg:col-span-7 xl:col-span-8"
                >
                    <!-- Gambar Besar -->
                    <div
                        class="relative aspect-[16/10] w-full overflow-hidden bg-gray-200 xl:aspect-video"
                    >
                        <img
                            :src="featuredArticle.image"
                            :alt="featuredArticle.title"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute top-4 left-4 rounded-md bg-blue-600/90 px-3 py-1 text-xs font-semibold text-white shadow-sm backdrop-blur-sm"
                        >
                            Berita Utama • {{ featuredArticle.category }}
                        </div>
                    </div>

                    <!-- Konten Headline -->
                    <div class="flex flex-1 flex-col p-6 sm:p-8 md:p-10">
                        <div
                            class="mb-4 flex items-center gap-4 text-sm font-medium text-gray-500"
                        >
                            <div class="flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar"></i>
                                <time :datetime="featuredArticle.date">{{
                                    featuredArticle.formattedDate
                                }}</time>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="fa-regular fa-user"></i>
                                <span>{{ featuredArticle.author }}</span>
                            </div>
                        </div>

                        <h3
                            class="mb-4 text-2xl font-extrabold text-gray-900 transition-colors group-hover:text-blue-700 sm:text-3xl lg:text-4xl"
                        >
                            <a :href="featuredArticle.link">
                                <span class="absolute inset-0"></span>
                                {{ featuredArticle.title }}
                            </a>
                        </h3>

                        <p
                            class="mb-8 text-base leading-relaxed text-gray-600 sm:text-lg"
                        >
                            {{ featuredArticle.excerpt }}
                        </p>

                        <div
                            class="mt-auto inline-flex items-center gap-2 text-base font-bold text-blue-600"
                        >
                            Baca selengkapnya
                            <i
                                class="fa-solid fa-arrow-right-long transition-transform duration-300 group-hover:translate-x-2"
                            ></i>
                        </div>
                    </div>
                </article>

                <!-- KANAN: List Article (Berita Lainnya) -->
                <!-- Mengambil 5 kolom di desktop -->
                <div class="flex flex-col gap-6 lg:col-span-5 xl:col-span-4">
                    <h3
                        class="border-b-2 border-gray-100 pb-3 text-lg font-bold text-gray-900"
                    >
                        Berita Lainnya
                    </h3>

                    <article
                        v-for="item in otherArticles"
                        :key="item.id"
                        class="group relative flex flex-col rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-100 hover:shadow-lg"
                    >
                        <!-- Kategori & Tanggal -->
                        <div
                            class="mb-3 flex items-center justify-between text-xs font-semibold"
                        >
                            <span class="text-blue-600">{{
                                item.category
                            }}</span>
                            <span class="text-gray-400">{{
                                item.formattedDate
                            }}</span>
                        </div>

                        <!-- Judul -->
                        <h4
                            class="mb-2 line-clamp-2 text-lg font-bold text-gray-900 transition-colors group-hover:text-blue-700"
                        >
                            <a :href="item.link">
                                <span class="absolute inset-0"></span>
                                {{ item.title }}
                            </a>
                        </h4>

                        <!-- Cuplikan (Deskripsi Pendek) -->
                        <p class="mb-4 line-clamp-2 text-sm text-gray-600">
                            {{ item.excerpt }}
                        </p>

                        <!-- Link -->
                        <div
                            class="mt-auto flex items-center gap-1 text-xs font-bold text-gray-400 transition-colors group-hover:text-blue-600"
                        >
                            Baca selengkapnya
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    post: {
        type: Array,
        default: () => [
            {
                id: 1,
                title: 'Tim Robotik SMAN 1 Berhasil Meraih Juara 1 Tingkat Nasional',
                excerpt:
                    'Prestasi membanggakan kembali ditorehkan oleh siswa-siswi SMAN 1. Tim robotik sekolah berhasil mengalahkan puluhan sekolah lain dalam kompetisi robotik nasional yang diselenggarakan di Jakarta. Kemenangan ini membawa mereka melaju ke tingkat internasional bulan depan.',
                image: 'https://images.unsplash.com/photo-1561557944-6e7860d1a7eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                category: 'Prestasi',
                date: '2026-06-20',
                formattedDate: '20 Juni 2026',
                author: 'Humas SMAN 1',
                link: '/berita/tim-robotik-juara-1',
            },
            {
                id: 2,
                title: 'Pelaksanaan Ujian Akhir Semester Berbasis Komputer (CBT)',
                excerpt:
                    'Untuk mendukung digitalisasi pendidikan, SMAN 1 tahun ini melaksanakan Ujian Akhir Semester secara penuh menggunakan sistem Computer Based Test (CBT) yang terintegrasi langsung dengan server pusat sekolah.',
                image: '', // Tidak butuh gambar untuk list samping
                category: 'Akademik',
                date: '2026-06-18',
                formattedDate: '18 Juni 2026',
                author: 'Panitia Ujian',
                link: '/berita/pelaksanaan-ujian-cbt',
            },
            {
                id: 3,
                title: 'Kegiatan Perkemahan Jumat Sabtu Minggu (Perjusami) Ekstrakurikuler Pramuka',
                excerpt:
                    'Dalam rangka melatih kemandirian dan kedisiplinan siswa, ekstrakurikuler Pramuka SMAN 1 mengadakan kegiatan Perjusami di bumi perkemahan yang diikuti oleh seluruh siswa kelas X dengan antusias.',
                image: '',
                category: 'Kegiatan',
                date: '2026-06-15',
                formattedDate: '15 Juni 2026',
                author: 'Pembina Pramuka',
                link: '/berita/kegiatan-perjusami-pramuka',
            },
            {
                id: 4,
                title: 'Sosialisasi Program Kampus Merdeka Bersama Alumni',
                excerpt:
                    'Sekolah mengundang para alumni yang telah sukses menembus perguruan tinggi negeri untuk memberikan motivasi dan kiat-kiat sukses jalur SNBP dan SNBT kepada siswa kelas XII.',
                image: '',
                category: 'Info Kampus',
                date: '2026-06-10',
                formattedDate: '10 Juni 2026',
                author: 'Guru BK',
                link: '/berita/sosialisasi-kampus-merdeka',
            },
        ],
    },
});

// Memisahkan data: Index 0 untuk Headline, sisanya untuk List (Berita Lainnya)
const featuredArticle = computed(() => props.post[0]);
const otherArticles = computed(() => props.post.slice(1));
</script>
