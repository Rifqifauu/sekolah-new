<template>
    <Head title="Artikel & Berita" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-10 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end md:mb-12"
                >
                    <div>
                        <div class="mb-3 inline-flex items-center gap-3">
                            <span class="h-px w-10 bg-blue-600"></span>
                            <span
                                class="text-sm font-bold tracking-widest text-blue-600 uppercase"
                            >
                                Jendela Sekolah
                            </span>
                        </div>
                        <h2
                            class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl"
                        >
                            Artikel & Berita
                        </h2>
                    </div>
                </div>

                <div class="mb-12 max-w-2xl">
                    <form
                        @submit.prevent="handleSearch"
                        class="flex items-center gap-2"
                    >
                        <div class="relative w-full">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                type="text"
                                v-model="search"
                                class="block w-full rounded-full border-gray-300 bg-white py-3 pr-4 pl-11 text-sm text-gray-900 shadow-sm transition-colors focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Cari judul artikel atau berita..."
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex shrink-0 items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <div
                    v-if="!articles.data || articles.data.length === 0"
                    class="flex flex-col items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-16 text-center shadow-sm"
                >
                    <div class="mb-4 rounded-full bg-gray-50 p-4">
                        <svg
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Artikel Tidak Ditemukan
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Maaf, kami tidak dapat menemukan berita atau artikel
                        yang Anda cari.
                    </p>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="item in articles.data"
                        :key="item.id"
                        class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10 hover:ring-blue-200"
                    >
                        <div
                            class="relative aspect-video w-full overflow-hidden bg-gray-200"
                        >
                            <img
                                v-if="item.image"
                                :src="item.image"
                                :alt="item.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-100 to-blue-50 text-blue-300"
                            >
                                <svg
                                    class="h-12 w-12"
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

                            <div class="absolute top-4 left-4">
                                <span
                                    class="rounded-full bg-blue-600/90 px-3 py-1 text-[10px] font-bold tracking-wider text-white uppercase backdrop-blur-sm"
                                >
                                    {{ item.category || 'Berita' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div
                                class="mb-4 flex items-center gap-4 text-xs font-medium text-gray-500"
                            >
                                <div class="flex items-center gap-1.5">
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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    {{ formatDate(item.created_at) }}
                                </div>
                                <div class="flex items-center gap-1.5">
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
                                    {{ item.author || 'Admin' }}
                                </div>
                            </div>

                            <h3
                                class="mb-3 text-xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-blue-600"
                            >
                                <Link
                                    :href="`/artikel/${item.slug}`"
                                    class="focus:outline-none"
                                >
                                    <span
                                        class="absolute inset-0"
                                        aria-hidden="true"
                                    ></span>
                                    {{ item.title }}
                                </Link>
                            </h3>

                            <p
                                class="mb-6 line-clamp-3 text-sm leading-relaxed text-gray-500"
                            >
                                {{ item.content }}
                            </p>

                            <div
                                class="mt-auto flex items-center font-semibold text-blue-600 transition-colors group-hover:text-blue-800"
                            >
                                <span class="text-sm">Baca Selengkapnya</span>
                                <svg
                                    class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"
                                    />
                                </svg>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="paginationLinks.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <div
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-gray-200 bg-white p-1 shadow-sm"
                    >
                        <template
                            v-for="(link, key) in paginationLinks"
                            :key="key"
                        >
                            <div
                                v-if="link.active"
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full bg-blue-600 px-3 text-sm font-medium text-white shadow-md"
                                v-html="link.label"
                            ></div>

                            <div
                                v-else-if="link.url === null"
                                class="flex h-10 min-w-[2.5rem] items-center justify-center px-3 text-sm text-gray-400"
                                v-html="link.label"
                            ></div>

                            <Link
                                v-else
                                :href="link.url"
                                preserve-scroll
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100"
                                v-html="link.label"
                            ></Link>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'; // Jangan lupa tambahkan computed di import
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    articles: {
        type: Object,
        default: () => ({ data: [], links: [] }), // Default agar tidak error ketika data kosong
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

const search = ref(props.filters?.search || '');

// Computed Property Pagination (Sama persis dengan yang di Pengumuman)
const paginationLinks = computed(() => {
    const links = props.articles?.meta?.links || props.articles?.links || [];

    return links.map((link) => {
        let cleanLabel = String(link.label || '');

        if (
            cleanLabel.includes('pagination.previous') ||
            cleanLabel.includes('Previous')
        ) {
            cleanLabel = '&laquo;';
        } else if (
            cleanLabel.includes('pagination.next') ||
            cleanLabel.includes('Next')
        ) {
            cleanLabel = '&raquo;';
        }

        return {
            ...link,
            label: cleanLabel,
        };
    });
});

const handleSearch = () => {
    router.get(
        '/artikel',
        { search: search.value },
        {
            preserveState: true,
            preserveScroll: true, // Menjaga agar halaman tidak kembali ke atas saat mencari
            replace: true,
        },
    );
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>
