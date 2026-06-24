<template>
    <Head title="Ekstrakurikuler Sekolah" />

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
                                Kegiatan Siswa
                            </span>
                        </div>
                        <h2
                            class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl"
                        >
                            Ekstrakurikuler
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
                                placeholder="Cari ekstrakurikuler..."
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
                    v-if="displayedExtracurriculars.data.length === 0"
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
                                d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Ekstrakurikuler Tidak Ditemukan
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Belum ada data ekstrakurikuler yang ditambahkan.
                    </p>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="item in displayedExtracurriculars.data"
                        :key="item.id"
                        @click="openModal(item)"
                        class="group relative flex cursor-pointer flex-col overflow-hidden rounded-3xl bg-white p-2 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-blue-900/10 hover:ring-blue-200"
                    >
                        <div
                            class="relative aspect-[4/3] w-full overflow-hidden rounded-2xl bg-gray-100"
                        >
                            <img
                                v-if="item.image"
                                :src="item.image"
                                :alt="item.name"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50"
                            >
                                <svg
                                    class="h-16 w-16 text-blue-200"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>

                            <div
                                class="absolute inset-0 flex items-center justify-center bg-blue-900/40 opacity-0 backdrop-blur-[2px] transition-opacity duration-300 group-hover:opacity-100"
                            >
                                <span
                                    class="flex items-center gap-2 rounded-full bg-white/90 px-4 py-2 text-sm font-bold text-blue-700 shadow-lg"
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
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                    Lihat Detail
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col px-4 py-5">
                            <h3
                                class="mb-2 text-xl font-bold text-gray-900 transition-colors group-hover:text-blue-600"
                            >
                                {{ item.name }}
                            </h3>
                            <p
                                class="mb-4 line-clamp-2 flex-1 text-sm leading-relaxed text-gray-500"
                            >
                                {{ item.description }}
                            </p>

                            <div
                                class="mt-auto flex items-center gap-2 rounded-xl bg-gray-50 p-3 ring-1 ring-gray-100 ring-inset"
                            >
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-blue-600 shadow-sm"
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
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <span
                                    class="truncate text-xs font-semibold text-gray-700"
                                    >{{ item.schedule }}</span
                                >
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="
                        displayedExtracurriculars.links &&
                        displayedExtracurriculars.links.length > 3
                    "
                    class="mt-12 flex justify-center"
                >
                    <div
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-gray-200 bg-white p-1 shadow-sm"
                    >
                        <template
                            v-for="(
                                link, key
                            ) in displayedExtracurriculars.links"
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
                    class="fixed inset-0 z-100 flex items-center justify-center p-4 sm:p-6"
                >
                    <div
                        class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
                        @click="closeModal"
                    ></div>

                    <Transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-if="isModalOpen"
                            class="relative w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5"
                        >
                            <button
                                @click="closeModal"
                                class="absolute top-4 right-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/20 text-white backdrop-blur-md transition-colors hover:bg-black/40 focus:outline-none"
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
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>

                            <div
                                class="relative aspect-video w-full bg-gray-100 sm:aspect-[21/9]"
                            >
                                <img
                                    v-if="selectedItem?.image"
                                    :src="selectedItem.image"
                                    :alt="selectedItem?.name"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100"
                                >
                                    <svg
                                        class="h-20 w-20 text-blue-200"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8">
                                <h2
                                    class="mb-4 text-2xl font-extrabold text-gray-900 sm:text-3xl"
                                >
                                    {{ selectedItem?.name }}
                                </h2>

                                <div
                                    class="mb-6 flex flex-wrap items-center gap-3"
                                >
                                    <div
                                        class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-700 ring-1 ring-blue-600/10 ring-inset"
                                    >
                                        <svg
                                            class="h-4 w-4 shrink-0 text-blue-500"
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
                                        {{ selectedItem?.schedule }}
                                    </div>
                                </div>

                                <div class="prose prose-blue max-w-none">
                                    <h4
                                        class="text-sm font-bold tracking-wider text-gray-400 uppercase"
                                    >
                                        Deskripsi Kegiatan
                                    </h4>
                                    <p
                                        class="mt-2 text-base leading-relaxed text-gray-600"
                                    >
                                        {{ selectedItem?.description }}
                                    </p>
                                </div>

                                <div class="mt-8 flex justify-end">
                                    <button
                                        @click="closeModal"
                                        class="rounded-full bg-gray-100 px-6 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-200"
                                    >
                                        Tutup
                                    </button>
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
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    extracurriculars: Object,
    filters: Object,
});

// State untuk Modal
const isModalOpen = ref(false);
const selectedItem = ref(null);

// Fungsi membuka modal
const openModal = (item) => {
    selectedItem.value = item;
    isModalOpen.value = true;
    // Mengunci scroll di background saat modal terbuka
    document.body.style.overflow = 'hidden';
};

// Fungsi menutup modal
const closeModal = () => {
    isModalOpen.value = false;
    // Menghapus data terpilih setelah animasi modal selesai (300ms)
    setTimeout(() => {
        selectedItem.value = null;
    }, 300);
    // Membuka kembali scroll
    document.body.style.overflow = 'auto';
};

// Data Dummy Fallback khusus untuk Ekstrakurikuler
const dummyData = {
    data: [
        {
            id: 1,
            name: 'Pramuka',
            description:
                'Ekstrakurikuler wajib yang melatih kemandirian, kedisiplinan, kerja sama tim, dan kepemimpinan melalui berbagai kegiatan kepanduan di alam terbuka. Kegiatan ini juga membekali siswa dengan keterampilan bertahan hidup (survival skills) dan cinta lingkungan.',
            image: 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=600&auto=format&fit=crop',
            schedule: 'Jumat, 15:00 - 17:00 WIB',
        },
        {
            id: 2,
            name: 'PMR (Palang Merah Remaja)',
            description:
                'Wadah pembinaan generasi muda untuk meningkatkan kepedulian sosial, keterampilan pertolongan pertama, dan kesehatan lingkungan sekolah. Anggota PMR dipersiapkan menjadi relawan siaga medis dalam setiap acara sekolah.',
            image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=600&auto=format&fit=crop',
            schedule: 'Rabu, 15:30 - 17:00 WIB',
        },
        {
            id: 3,
            name: 'Klub Robotik',
            description:
                'Mengembangkan bakat siswa dalam bidang teknologi, pemrograman, dan rekayasa melalui pembuatan robot sederhana hingga tingkat kompetisi nasional. Siswa diajarkan dasar-dasar mikrokontroler (Arduino) dan Internet of Things (IoT).',
            image: 'https://images.unsplash.com/photo-1561557944-6e7860d1a7eb?q=80&w=600&auto=format&fit=crop',
            schedule: 'Selasa & Kamis, 14:00 - 16:00 WIB',
        },
        {
            id: 4,
            name: 'Futsal',
            description:
                'Ekskul olahraga yang bertujuan menyalurkan hobi sepak bola dalam ruangan, melatih sportivitas, strategi, kerja sama tim, dan menjaga kebugaran jasmani. Tim futsal sekolah sering mewakili pada turnamen antar pelajar.',
            image: 'https://images.unsplash.com/photo-1534011546717-407bcea4d512?q=80&w=600&auto=format&fit=crop',
            schedule: 'Senin & Kamis, 15:30 - 17:30 WIB',
        },
        {
            id: 5,
            name: 'Tari Tradisional',
            description:
                'Melestarikan kebudayaan bangsa dengan mempelajari berbagai macam tarian daerah nusantara. Anggota ekskul ini selalu mendapat kehormatan untuk tampil dalam acara perpisahan, penyambutan tamu resmi, dan lomba seni tingkat provinsi.',
            image: 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=600&auto=format&fit=crop',
            schedule: 'Sabtu, 09:00 - 11:30 WIB',
        },
        {
            id: 6,
            name: 'English Club',
            description:
                'Fokus pada peningkatan kemampuan berbicara (speaking), berdebat (debate), bercerita (story telling), dan pidato (speech) dalam bahasa Inggris. Lingkungan yang diciptakan mewajibkan peserta untuk berkomunikasi full in English selama sesi berlangsung.',
            image: null,
            schedule: 'Selasa, 15:00 - 16:30 WIB',
        },
    ],
    links: [
        { url: null, label: '&laquo; Previous', active: false },
        { url: '/ekstrakurikuler?page=1', label: '1', active: true },
        { url: '/ekstrakurikuler?page=2', label: '2', active: false },
        {
            url: '/ekstrakurikuler?page=2',
            label: 'Next &raquo;',
            active: false,
        },
    ],
};

const displayedExtracurriculars =
    props.extracurriculars?.data?.length > 0
        ? props.extracurriculars
        : dummyData;

const search = ref(props.filters?.search || '');

const handleSearch = () => {
    router.get(
        '/ekstrakurikuler',
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>
