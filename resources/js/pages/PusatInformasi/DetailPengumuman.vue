<template>
    <Head :title="announcement.title || 'Detail Pengumuman'" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <Link
                        href="/pengumuman"
                        class="group inline-flex items-center gap-2 text-sm font-semibold text-gray-500 transition-colors hover:text-blue-600"
                    >
                        <svg
                            class="h-5 w-5 transition-transform group-hover:-translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali ke Daftar Pengumuman
                    </Link>
                </div>

                <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">
                    <article
                        class="relative overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 lg:col-span-2"
                    >
                        <div
                            class="absolute inset-x-0 top-0 h-1.5 bg-blue-600"
                        ></div>

                        <div class="px-6 pt-10 sm:px-10 sm:pt-12">
                            <div class="mb-4 flex flex-wrap items-center gap-3">
                                <span
                                    class="inline-block rounded-md bg-gray-100 px-2.5 py-1 text-xs font-bold tracking-wider text-gray-600 uppercase"
                                >
                                    {{ announcement.category || 'Informasi' }}
                                </span>
                            </div>

                            <h1
                                class="mb-6 text-2xl leading-tight font-extrabold text-gray-900 sm:text-3xl md:text-4xl"
                            >
                                {{ announcement.title }}
                            </h1>

                            <div
                                class="mb-8 flex flex-wrap items-center gap-6 border-b border-gray-100 pb-8 text-sm font-medium text-gray-500"
                            >
                                <div class="flex items-center gap-2">
                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        >Diterbitkan pada
                                        {{
                                            formatDate(announcement.created_at)
                                        }}</span
                                    >
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                    <span
                                        >Oleh
                                        <span class="text-gray-900">{{
                                            announcement.author || 'Tata Usaha'
                                        }}</span></span
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="px-6 pb-10 sm:px-10">
                            <div
                                class="prose prose-blue prose-lg max-w-none text-gray-600"
                                v-html="announcement.content"
                            ></div>
                        </div>

                        <div
                            v-if="
                                announcement.has_attachment ||
                                announcement.attachment_url
                            "
                            class="border-t border-gray-100 bg-gray-50 px-6 py-6 sm:px-10"
                        >
                            <div
                                class="flex flex-col gap-4 rounded-xl border border-blue-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between"
                            >
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                                    >
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-gray-900"
                                        >
                                            Dokumen Lampiran
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            Silakan unduh dokumen untuk
                                            informasi lebih rinci.
                                        </p>
                                    </div>
                                </div>
                                <a
                                    :href="announcement.attachment_url || '#'"
                                    target="_blank"
                                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Unduh File
                                </a>
                            </div>
                        </div>
                    </article>

                    <aside class="sticky top-8 lg:col-span-1">
                        <div
                            class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100"
                        >
                            <div
                                class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4"
                            >
                                <span
                                    class="h-5 w-1.5 rounded-full bg-yellow-500"
                                ></span>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Pengumuman Terbaru
                                </h3>
                            </div>

                            <div
                                v-if="
                                    recentAnnouncements &&
                                    recentAnnouncements.length > 0
                                "
                                class="flex flex-col gap-5"
                            >
                                <Link
                                    v-for="item in recentAnnouncements"
                                    :key="item.id"
                                    :href="`/pengumuman/${item.slug}`"
                                    class="group flex gap-4"
                                >
                                    <div
                                        class="flex h-14 w-12 shrink-0 flex-col items-center justify-center rounded-lg border border-gray-100 bg-gray-50 transition-colors group-hover:border-blue-200 group-hover:bg-blue-50"
                                    >
                                        <span
                                            class="text-lg font-black text-blue-600"
                                            >{{ getDay(item.created_at) }}</span
                                        >
                                        <span
                                            class="text-[10px] font-bold text-gray-500 uppercase"
                                            >{{
                                                getMonth(item.created_at)
                                            }}</span
                                        >
                                    </div>

                                    <div
                                        class="flex flex-col justify-start pt-1"
                                    >
                                        <h4
                                            class="line-clamp-2 text-sm leading-snug font-bold text-gray-900 transition-colors group-hover:text-blue-600"
                                        >
                                            {{ item.title }}
                                        </h4>
                                    </div>
                                </Link>
                            </div>

                            <div
                                v-else
                                class="py-4 text-center text-sm text-gray-500"
                            >
                                Belum ada pengumuman lain.
                            </div>

                            <div
                                class="mt-6 border-t border-gray-100 pt-6 text-center"
                            >
                                <Link
                                    href="/pengumuman"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                >
                                    Lihat Semua Pengumuman &rarr;
                                </Link>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    announcement: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            content: '',
            category: '',
            has_attachment: false,
            attachment_url: null,
            author: '',
            created_at: null,
        }),
    },
    // Prop dari controller untuk sidebar
    recentAnnouncements: {
        type: Array,
        default: () => [],
    },
});

// Helper Format Tanggal Penuh
const formatDate = (dateString) => {
    if (!dateString) return 'Tanggal tidak diketahui';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Helper Ambil Tanggal (Angka) untuk sidebar kalender
const getDay = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).getDate().toString().padStart(2, '0');
};

// Helper Ambil Bulan (Singkatan) untuk sidebar kalender
const getMonth = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', { month: 'short' });
};
</script>
