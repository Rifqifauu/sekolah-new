<template>
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="mb-12 flex flex-col items-center justify-between gap-4 sm:flex-row md:mb-16"
            >
                <div>
                    <div class="mb-2 inline-flex items-center gap-3">
                        <span class="h-px w-8 bg-yellow-500"></span>
                        <span
                            class="text-sm font-bold tracking-widest text-yellow-600 uppercase"
                            >Informasi Penting</span
                        >
                    </div>
                    <h2
                        class="text-3xl font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Pengumuman Sekolah
                    </h2>
                </div>
                <a
                    href="/pengumuman"
                    class="group inline-flex items-center gap-2 rounded-lg bg-blue-50 px-5 py-2.5 text-sm font-semibold text-blue-700 transition-all hover:bg-blue-600 hover:text-white"
                >
                    Lihat Semua Pengumuman
                    <i
                        class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"
                    ></i>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-8">
                <article
                    v-for="item in announcements"
                    :key="item.id"
                    class="group relative flex items-start gap-5 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/5 sm:p-6"
                >
                    <div
                        class="flex min-w-[5rem] flex-col items-center justify-center rounded-xl bg-gradient-to-b from-blue-50 to-blue-100 px-4 py-3 text-center shadow-inner transition-colors duration-300 group-hover:from-blue-600 group-hover:to-blue-800"
                    >
                        <span
                            class="text-2xl font-black text-blue-700 group-hover:text-white"
                            >{{ item.day }}</span
                        >
                        <span
                            class="text-xs font-bold tracking-wider text-blue-500 uppercase group-hover:text-blue-100"
                            >{{ item.month }}</span
                        >
                        <span
                            class="mt-1 text-[10px] font-semibold text-gray-400 group-hover:text-blue-200"
                            >{{ item.year }}</span
                        >
                    </div>

                    <div class="flex flex-1 flex-col">
                        <div class="mb-2 flex items-center gap-2">
                            <span
                                class="rounded bg-gray-100 px-2 py-0.5 text-[10px] font-bold tracking-wider text-gray-600 uppercase"
                            >
                                {{ item.category }}
                            </span>
                            <span
                                v-if="item.isUrgent"
                                class="flex animate-pulse items-center gap-1 text-[10px] font-bold text-red-500 uppercase"
                            >
                                <i class="fa-solid fa-circle-exclamation"></i>
                                Segera
                            </span>
                        </div>

                        <h3
                            class="mb-2 line-clamp-2 text-lg font-bold text-gray-900 transition-colors group-hover:text-blue-700"
                        >
                            <a :href="item.link">
                                <span class="absolute inset-0"></span>
                                {{ item.title }}
                            </a>
                        </h3>

                        <p class="mb-4 line-clamp-2 text-sm text-gray-600">
                            {{ item.description }}
                        </p>

                        <div
                            class="mt-auto flex items-center justify-between border-t border-gray-50 pt-3"
                        >
                            <div
                                v-if="item.hasAttachment"
                                class="flex items-center gap-1.5 text-xs font-semibold text-gray-500"
                            >
                                <i class="fa-solid fa-paperclip"></i>
                                <span>Ada Lampiran</span>
                            </div>
                            <div v-else></div>
                            <div
                                class="flex items-center gap-1 text-xs font-bold text-blue-600 group-hover:text-blue-800"
                            >
                                Selengkapnya
                                <i
                                    class="fa-solid fa-angle-right transition-transform group-hover:translate-x-1"
                                ></i>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue';

// Dummy data menggunakan props agar mudah diganti dari database nanti
const props = defineProps({
    announcements: {
        type: Array,
        default: () => [
            {
                id: 1,
                title: 'Pengumuman Kelulusan & Pengambilan SKL Siswa Kelas XII Tahun 2026',
                description:
                    'Bagi seluruh siswa kelas XII, Surat Keterangan Lulus (SKL) sudah dapat diambil di ruang Tata Usaha dengan membawa kartu pelajar dan bukti bebas perpustakaan.',
                day: '25',
                month: 'Jun',
                year: '2026',
                category: 'Akademik',
                isUrgent: true,
                hasAttachment: true,
                link: '/pengumuman/pengambilan-skl-2026',
            },
            {
                id: 2,
                title: 'Jadwal Pelaksanaan Daftar Ulang PPDB Jalur Zonasi',
                description:
                    'Calon peserta didik baru yang dinyatakan lulus jalur zonasi diwajibkan melakukan daftar ulang dengan membawa dokumen persyaratan asli dan fotokopi.',
                day: '28',
                month: 'Jun',
                year: '2026',
                category: 'PPDB',
                isUrgent: false,
                hasAttachment: true,
                link: '/pengumuman/daftar-ulang-zonasi',
            },
            {
                id: 3,
                title: 'Undangan Rapat Pleno Wali Murid Kelas X Bersama Komite Sekolah',
                description:
                    'Mengharap kehadiran Bapak/Ibu wali murid kelas X pada acara pemaparan program sekolah dan pembentukan pengurus paguyuban kelas.',
                day: '02',
                month: 'Jul',
                year: '2026',
                category: 'Agenda',
                isUrgent: false,
                hasAttachment: false,
                link: '/pengumuman/rapat-wali-murid',
            },
            {
                id: 4,
                title: 'Pemberitahuan Libur Akhir Semester Genap Tahun Ajaran 2025/2026',
                description:
                    'Libur akhir semester genap akan berlangsung selama 2 minggu. Kegiatan belajar mengajar (KBM) tahun ajaran baru akan dimulai kembali pada pertengahan Juli.',
                day: '10',
                month: 'Jul',
                year: '2026',
                category: 'Informasi',
                isUrgent: false,
                hasAttachment: false,
                link: '/pengumuman/libur-semester-genap',
            },
        ],
    },
});
</script>
