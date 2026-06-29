<template>
    <Head :title="article.title || 'Detail Artikel'" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <Link
                        href="/artikel"
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
                        Kembali ke Daftar Artikel
                    </Link>
                </div>

                <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">
                    <article
                        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 lg:col-span-2"
                    >
                        <div class="px-6 pt-10 sm:px-10 sm:pt-12">
                            <div class="mb-4">
                                <span
                                    class="inline-block rounded-full bg-blue-50 px-3 py-1 text-xs font-bold tracking-wider text-blue-600 uppercase"
                                >
                                    {{ article.category || 'Berita' }}
                                </span>
                            </div>

                            <h1
                                class="mb-6 text-3xl leading-tight font-extrabold text-gray-900 sm:text-4xl"
                            >
                                {{ article.title }}
                            </h1>

                            <div
                                class="mb-8 flex flex-wrap items-center gap-6 border-b border-gray-100 pb-8 text-sm font-medium text-gray-500"
                            >
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500"
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
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                    </div>
                                    <span
                                        >Oleh
                                        <span class="text-gray-900">{{
                                            article.author || 'Admin'
                                        }}</span></span
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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span>{{
                                        formatDate(article.created_at)
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="relative w-full bg-gray-100 px-6 sm:px-10">
                            <div
                                class="aspect-video w-full overflow-hidden rounded-xl bg-gray-200"
                            >
                                <img
                                    v-if="article.image"
                                    :src="article.image"
                                    :alt="article.title"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-100 to-blue-50 text-blue-300"
                                >
                                    <svg
                                        class="h-20 w-20"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-10 sm:px-10 sm:py-12">
                            <div
                                class="prose prose-blue prose-lg max-w-none text-gray-600"
                                v-html="article.content"
                            ></div>
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
                                    class="h-5 w-1.5 rounded-full bg-blue-600"
                                ></span>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Artikel Rekomendasi
                                </h3>
                            </div>

                            <div
                                v-if="
                                    recommendations &&
                                    recommendations.length > 0
                                "
                                class="flex flex-col gap-6"
                            >
                                <Link
                                    v-for="rec in recommendations"
                                    :key="rec.id"
                                    :href="`/artikel/${rec.slug}`"
                                    class="group flex gap-4"
                                >
                                    <div
                                        class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-100"
                                    >
                                        <img
                                            v-if="rec.image"
                                            :src="rec.image"
                                            :alt="rec.title"
                                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                        />
                                        <div
                                            v-else
                                            class="flex h-full w-full items-center justify-center bg-blue-50 text-blue-200"
                                        >
                                            <svg
                                                class="h-8 w-8"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="flex flex-col justify-center">
                                        <h4
                                            class="line-clamp-2 text-sm leading-snug font-bold text-gray-900 transition-colors group-hover:text-blue-600"
                                        >
                                            {{ rec.title }}
                                        </h4>
                                        <div
                                            class="mt-1.5 flex items-center gap-1.5 text-xs text-gray-500"
                                        >
                                            <svg
                                                class="h-3 w-3"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            {{ formatDate(rec.created_at) }}
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            <div
                                v-else
                                class="py-4 text-center text-sm text-gray-500"
                            >
                                Belum ada artikel rekomendasi.
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
    article: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            content: '',
            category: '',
            image: null,
            author: '',
            created_at: null,
        }),
    },
    // Prop baru untuk menangkap data sidebar
    recommendations: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (dateString) => {
    if (!dateString) return 'Tanggal tidak diketahui';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>
