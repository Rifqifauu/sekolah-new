<template>
    <Head title="Pengumuman Sekolah" />

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
                                >Pusat Informasi</span
                            >
                        </div>
                        <h2
                            class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl"
                        >
                            Pengumuman Sekolah
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
                                placeholder="Cari judul atau isi pengumuman..."
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
                    v-if="
                        !announcements.data || announcements.data.length === 0
                    "
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
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Pengumuman Tidak Ditemukan
                    </h3>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:gap-8"
                >
                    <article
                        v-for="item in announcements.data"
                        :key="item.id"
                        class="group relative flex flex-col items-start gap-5 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-900/10 hover:ring-blue-200 sm:flex-row sm:p-6"
                    >
                        <div
                            class="flex w-full shrink-0 flex-row items-center justify-between rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 px-4 py-3 text-center shadow-inner transition-transform duration-300 group-hover:scale-105 sm:w-20 sm:min-w-[5rem] sm:flex-col sm:justify-center sm:py-4"
                        >
                            <span
                                class="text-xs font-bold tracking-wider text-blue-200 uppercase"
                                >{{ getDateInfo(item.created_at).month }}</span
                            >
                            <span
                                class="my-0 text-2xl font-black text-white sm:my-1 sm:text-3xl"
                                >{{ getDateInfo(item.created_at).day }}</span
                            >
                            <span
                                class="text-[10px] font-semibold text-blue-300"
                                >{{ getDateInfo(item.created_at).year }}</span
                            >
                        </div>

                        <div class="flex h-full w-full flex-1 flex-col">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-md bg-gray-100 px-2.5 py-1 text-[10px] font-bold tracking-wider text-gray-600 uppercase"
                                    >Informasi</span
                                >
                                <span
                                    v-if="item.isUrgent"
                                    class="inline-flex animate-pulse items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-[10px] font-bold text-red-600 uppercase ring-1 ring-red-500/10 ring-inset"
                                    >Segera</span
                                >
                            </div>

                            <h3
                                class="mb-2 text-xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-blue-600"
                            >
                                <Link
                                    :href="`/pengumuman/${item.slug}`"
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
                                class="mb-5 line-clamp-2 text-sm leading-relaxed text-gray-500"
                            >
                                {{ item.content }}
                            </p>

                            <div
                                class="mt-auto flex items-center justify-between border-t border-gray-100 pt-4"
                            >
                                <div
                                    v-if="item.image"
                                    class="flex items-center gap-1.5 text-xs font-medium text-gray-400"
                                >
                                    <span>Ada Lampiran</span>
                                </div>
                                <div v-else></div>
                                <div
                                    class="flex items-center gap-1 text-sm font-semibold text-blue-600 transition-colors group-hover:text-blue-800"
                                >
                                    Selengkapnya →
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="announcements.links && announcements.links.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <div
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-gray-200 bg-white p-1 shadow-sm"
                    >
                        <template
                            v-for="(link, key) in announcements.links"
                            :key="key"
                        >
                            <div
                                v-if="link.url === null"
                                class="flex h-10 min-w-[2.5rem] items-center justify-center px-3 text-sm text-gray-400"
                                v-html="link.label"
                            ></div>
                            <Link
                                v-else
                                :href="link.url"
                                preserve-scroll
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm font-medium transition-colors"
                                :class="
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : 'text-gray-600 hover:bg-gray-100'
                                "
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
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    announcements: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

const search = ref(props.filters?.search || '');

const handleSearch = () => {
    router.get(
        '/pengumuman',
        { search: search.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

const getDateInfo = (dateString) => {
    const date = new Date(dateString);
    return {
        day: date.toLocaleDateString('id-ID', { day: '2-digit' }),
        month: date.toLocaleDateString('id-ID', { month: 'short' }),
        year: date.getFullYear(),
    };
};
</script>
