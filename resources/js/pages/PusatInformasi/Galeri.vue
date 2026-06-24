<template>
    <Head title="Galeri Sekolah" />

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
                                >Dokumentasi</span
                            >
                        </div>
                        <h2
                            class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl"
                        >
                            Galeri Sekolah
                        </h2>
                    </div>
                </div>

                <div
                    class="mb-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <form
                        @submit.prevent="handleSearch"
                        class="flex w-full max-w-md items-center gap-2"
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
                                placeholder="Cari nama galeri..."
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex shrink-0 items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <div
                    v-if="!media.data || media.data.length === 0"
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
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Media Tidak Ditemukan
                    </h3>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <article
                        v-for="item in media.data"
                        :key="item.id"
                        class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                    >
                        <div
                            class="relative aspect-square w-full overflow-hidden bg-gray-200"
                        >
                            <img
                                v-if="item.path && item.path.length > 0"
                                :src="item.path[0]"
                                :alt="item.name"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-80 group-hover:opacity-100"
                            ></div>

                            <div
                                class="absolute top-3 left-3 flex items-center gap-2"
                            >
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold tracking-wider uppercase backdrop-blur-sm"
                                    :class="
                                        item.type === 'video'
                                            ? 'text-red-600'
                                            : 'text-blue-600'
                                    "
                                >
                                    {{
                                        item.type === 'video'
                                            ? 'Video'
                                            : 'Album Foto'
                                    }}
                                </span>
                            </div>

                            <div
                                class="absolute right-0 bottom-0 left-0 p-5 text-white"
                            >
                                <h3
                                    class="mb-1 line-clamp-2 text-lg leading-tight font-bold"
                                >
                                    {{ item.name }}
                                </h3>
                                <p
                                    class="line-clamp-1 text-xs text-gray-300 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                >
                                    {{ item.description }}
                                </p>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="media.links && media.links.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <div
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-gray-200 bg-white p-1 shadow-sm"
                    >
                        <template v-for="(link, key) in media.links" :key="key">
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
    media: {
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
        '/galeri',
        { search: search.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};
</script>
