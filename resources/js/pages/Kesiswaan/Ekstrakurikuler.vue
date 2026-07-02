<template>
    <Head title="Ekstrakurikuler Sekolah" />

    <AppLayout>
        <section class="min-h-screen bg-slate-50/50 py-12 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between"
                >
                    <div>
                        <div class="mb-2 flex items-center gap-2">
                            <span
                                class="h-0.5 w-8 rounded-full bg-blue-600"
                            ></span>
                            <span
                                class="text-xs font-bold tracking-widest text-blue-600 uppercase"
                            >
                                Kegiatan Siswa
                            </span>
                        </div>
                        <h2
                            class="text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl lg:text-5xl"
                        >
                            Ekstrakurikuler
                        </h2>
                    </div>

                    <form
                        @submit.prevent="handleSearch"
                        class="flex w-full items-center gap-2 md:max-w-md"
                    >
                        <div class="relative w-full">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
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
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </span>
                            <input
                                type="text"
                                v-model="search"
                                class="block w-full rounded-full border-slate-200 bg-white py-3 pr-4 pl-11 text-sm text-slate-900 shadow-sm transition-all focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                                placeholder="Cari ekstrakurikuler..."
                            />
                        </div>
                        <button
                            type="submit"
                            class="rounded-full bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-md shadow-blue-100 transition-all hover:bg-blue-700 hover:shadow-lg focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <div
                    v-if="
                        !extracurriculars.data ||
                        extracurriculars.data.length === 0
                    "
                    class="flex flex-col items-center justify-center rounded-2xl border border-slate-100 bg-white p-16 text-center shadow-sm"
                >
                    <div
                        class="mb-4 rounded-full bg-slate-50 p-4 text-slate-400"
                    >
                        <svg
                            class="h-8 w-8"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-950">
                        Ekstrakurikuler Tidak Ditemukan
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Belum ada data atau kata kunci tidak cocok.
                    </p>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="item in extracurriculars.data"
                        :key="item.id"
                        @click="openModal(item)"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-slate-200 hover:shadow-md"
                    >
                        <div
                            class="relative aspect-[16/10] w-full overflow-hidden bg-slate-100"
                        >
                            <img
                                v-if="item.image"
                                :src="item.image"
                                :alt="item.name"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100 text-blue-200"
                            >
                                <svg
                                    class="h-12 w-12"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
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

                        <div class="flex flex-grow flex-col p-5">
                            <h3
                                class="mb-2 text-xl font-bold text-slate-900 transition-colors group-hover:text-blue-600"
                            >
                                {{ item.name }}
                            </h3>
                            <p
                                class="mb-5 line-clamp-2 flex-grow text-sm leading-relaxed text-slate-500"
                            >
                                {{ item.description }}
                            </p>

                            <div
                                class="flex items-center gap-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-2"
                            >
                                <svg
                                    class="h-4 w-4 shrink-0 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <span
                                    class="truncate text-xs font-semibold text-slate-600"
                                >
                                    {{ item.schedule }}
                                </span>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="paginationLinks.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <nav
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-slate-200 bg-white p-1 shadow-sm"
                    >
                        <template
                            v-for="(link, key) in paginationLinks"
                            :key="key"
                        >
                            <div
                                v-if="link.active"
                                class="flex h-9 min-w-[2.25rem] items-center justify-center rounded-full bg-blue-600 px-3 text-xs font-semibold text-white shadow-md"
                                v-html="link.label"
                            ></div>

                            <div
                                v-else-if="link.url === null"
                                class="flex h-9 min-w-[2.25rem] items-center justify-center px-3 text-xs text-slate-400"
                                v-html="link.label"
                            ></div>

                            <Link
                                v-else
                                :href="link.url"
                                preserve-scroll
                                class="flex h-9 min-w-[2.25rem] items-center justify-center rounded-full px-3 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-50"
                                v-html="link.label"
                            ></Link>
                        </template>
                    </nav>
                </div>
            </div>
        </section>

        <Teleport to="body">
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="isModalOpen"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                >
                    <div
                        class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                        @click="closeModal"
                    ></div>

                    <Transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:scale-95"
                    >
                        <div
                            class="relative w-full max-w-xl overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-2xl"
                        >
                            <button
                                @click="closeModal"
                                class="absolute top-4 right-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-slate-900/40 text-white backdrop-blur-md transition-colors hover:bg-slate-900/60"
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
                                    />
                                </svg>
                            </button>

                            <div class="aspect-video w-full bg-slate-100">
                                <img
                                    v-if="selectedItem?.image"
                                    :src="selectedItem.image"
                                    :alt="selectedItem?.name"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-200"
                                >
                                    <svg
                                        class="h-16 w-16"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
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

                            <div class="p-6">
                                <h2
                                    class="mb-3 text-2xl font-extrabold text-slate-900"
                                >
                                    {{ selectedItem?.name }}
                                </h2>
                                <div
                                    class="mb-4 inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700"
                                >
                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    {{ selectedItem?.schedule }}
                                </div>

                                <div class="border-t border-slate-100 pt-4">
                                    <p
                                        class="text-sm leading-relaxed text-slate-600"
                                    >
                                        {{ selectedItem?.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'; // WAJIB ada computed
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    extracurriculars: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: Object,
});

const isModalOpen = ref(false);
const selectedItem = ref(null);
const search = ref(props.filters?.search || '');

// Computed Property Pagination (Mencegah Error String Includes & Menangani API Resource Meta)
const paginationLinks = computed(() => {
    const links =
        props.extracurriculars?.meta?.links ||
        props.extracurriculars?.links ||
        [];

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

const openModal = (item) => {
    selectedItem.value = item;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = '';
    setTimeout(() => {
        selectedItem.value = null;
    }, 300);
};

const handleSearch = () => {
    router.get(
        '/kesiswaan/ekstrakurikuler',
        { search: search.value },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
};
</script>
