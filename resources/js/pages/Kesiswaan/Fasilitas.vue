<template>
    <Head title="Fasilitas Sekolah" />

    <AppLayout>
        <div class="min-h-screen bg-slate-50 p-6 sm:py-16">
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
                        @click="filterCategory(cat)"
                        :class="[
                            'rounded-full px-5 py-2.5 text-sm font-bold shadow-sm transition-all duration-300',
                            isActiveCategory(cat)
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
                        v-for="facility in facilities.data"
                        :key="facility.id"
                        @click="openModal(facility)"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-2xl border border-indigo-50 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                    >
                        <div class="relative h-48 overflow-hidden bg-slate-200">
                            <img
                                :src="
                                    facility.image &&
                                    facility.image.startsWith('http')
                                        ? facility.image
                                        : `/storage/${facility.image}`
                                "
                                :alt="facility.name"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                @error="
                                    (e) =>
                                        (e.target.src =
                                            '/images/placeholder.jpg')
                                "
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
                    v-if="facilities.data.length === 0"
                    class="py-12 text-center"
                >
                    <div class="mb-4 inline-flex rounded-full bg-slate-100 p-4">
                        <svg
                            class="h-8 w-8 text-slate-400"
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
                    <p class="font-medium text-slate-500">
                        Fasilitas tidak ditemukan.
                    </p>
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
                        class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                    >
                        <div
                            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                            @click="closeModal"
                        ></div>

                        <div
                            class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                        >
                            <div
                                class="relative h-64 w-full bg-slate-100 sm:h-72"
                            >
                                <img
                                    :src="
                                        selectedFacility.image &&
                                        selectedFacility.image.startsWith(
                                            'http',
                                        )
                                            ? selectedFacility.image
                                            : `/storage/${selectedFacility.image}`
                                    "
                                    :alt="selectedFacility.name"
                                    class="h-full w-full object-cover"
                                />
                                <button
                                    @click="closeModal"
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
                                <button
                                    @click="closeModal"
                                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 px-4 py-3 font-bold text-white shadow-md transition-all duration-300 hover:from-blue-800 hover:to-blue-700 hover:shadow-lg focus:ring-4 focus:ring-blue-200"
                                >
                                    Tutup Detail
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
import { ref, computed } from 'vue'; // WAJIB tambahkan computed di sini
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    facilities: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: '' }),
    },
});

// Daftar Kategori
const categories = ['Semua', 'Akademik', 'Olahraga', 'Seni', 'Umum'];

// Mengecek kategori aktif
const isActiveCategory = (cat) => {
    if (cat === 'Semua' && !props.filters.search) return true;
    return props.filters.search === cat;
};

// Logika Filter Kategori
const filterCategory = (cat) => {
    const query = cat === 'Semua' ? '' : cat;
    router.get(
        '/kesiswaan/fasilitas',
        { search: query },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
};

// Logika Modal
const showModal = ref(false);
const selectedFacility = ref(null);

const openModal = (facility) => {
    selectedFacility.value = facility;
    showModal.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    selectedFacility.value = null;
    showModal.value = false;
    document.body.style.overflow = 'auto';
};

// Logika Computed Property untuk Pagination (Mencegah Bug Laravel)
const paginationLinks = computed(() => {
    const links =
        props.facilities?.meta?.links || props.facilities?.links || [];

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
</script>
