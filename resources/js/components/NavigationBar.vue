<template>
    <header class="sticky top-0 z-50 w-full font-sans shadow-sm">
        <div class="bg-blue-900 py-2.5 text-xs text-gray-200 sm:text-sm">
            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <div class="flex items-center space-x-6">
                    <a
                        :href="`mailto:${globalSettings?.site_email ?? 'info@sekolah.sch.id'}`"
                        class="flex items-center gap-2 transition-colors hover:text-blue-300"
                    >
                        <i class="fa-solid fa-envelope"></i>
                        <span class="hidden sm:inline">
                            {{
                                globalSettings?.site_email ??
                                'info@sekolah.sch.id'
                            }}
                        </span>
                    </a>
                    <a
                        :href="`tel:${globalSettings?.site_phone ?? ''}`"
                        class="flex items-center gap-2 transition-colors hover:text-blue-300"
                    >
                        <i class="fa-solid fa-phone"></i>
                        <span>{{
                            globalSettings?.site_phone ?? '(021) 1234567'
                        }}</span>
                    </a>
                </div>
                <div class="hidden items-center text-blue-200 md:flex">
                    <i class="fa-solid fa-location-dot mr-2"></i>
                    <span class="line-clamp-1">
                        {{
                            globalSettings?.site_address ??
                            'Jalan Pendidikan No. 123, Indonesia'
                        }}
                    </span>
                </div>
            </div>
        </div>

        <nav
            class="border-b border-gray-100 bg-white/90 shadow-lg backdrop-blur-md transition-all duration-300"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/" class="group flex items-center gap-3">
                            <div
                                v-if="globalSettings?.school_logo"
                                class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl transition-transform group-hover:scale-105"
                            >
                                <img
                                    :src="
                                        getImageUrl(globalSettings.school_logo)
                                    "
                                    :alt="globalSettings?.school_name"
                                    class="h-full w-full object-contain"
                                />
                            </div>
                            <div
                                v-else
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 shadow-lg shadow-blue-900/20 transition-transform group-hover:scale-105"
                            >
                                <i
                                    class="fa-solid fa-school text-xl text-white"
                                ></i>
                            </div>

                            <div class="flex flex-col">
                                <span
                                    class="line-clamp-1 text-lg font-bold tracking-wide text-gray-900 sm:text-xl"
                                >
                                    {{
                                        globalSettings?.school_name ??
                                        'SMP Negeri Default'
                                    }}
                                </span>
                                <span
                                    class="line-clamp-1 text-xs font-medium text-blue-600"
                                >
                                    {{
                                        globalSettings?.school_slogan ??
                                        'Maju & Berprestasi'
                                    }}
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="hidden lg:flex lg:items-center lg:space-x-2">
                        <template v-for="item in menuItems" :key="item.label">
                            <div
                                v-if="item.subItems"
                                class="group relative px-2 py-2"
                            >
                                <button
                                    class="flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 transition-all hover:bg-blue-50 hover:text-blue-700 focus:outline-none"
                                >
                                    {{ item.label }}
                                    <i
                                        class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 group-hover:rotate-180"
                                    ></i>
                                </button>

                                <div
                                    class="invisible absolute top-full left-0 mt-2 w-60 opacity-0 transition-all duration-300 group-hover:visible group-hover:mt-0 group-hover:opacity-100"
                                >
                                    <div
                                        class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-xl shadow-blue-900/5"
                                    >
                                        <div class="p-2">
                                            <a
                                                v-for="subItem in item.subItems"
                                                :key="subItem.label"
                                                :href="subItem.href"
                                                class="group/item flex items-center rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition-all hover:bg-blue-50 hover:text-blue-700"
                                            >
                                                <i
                                                    class="fa-solid fa-angle-right mr-2 text-blue-600 opacity-0 transition-all group-hover/item:translate-x-1 group-hover/item:opacity-100"
                                                ></i>
                                                {{ subItem.label }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a
                                v-else
                                :href="item.href"
                                :class="[
                                    item.isPrimary
                                        ? 'ml-4 inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-800 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/20 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-600/40'
                                        : 'rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 transition-all hover:bg-blue-50 hover:text-blue-700',
                                ]"
                            >
                                {{ item.label }}
                                <i
                                    v-if="item.isPrimary"
                                    class="fa-solid fa-arrow-right text-xs"
                                ></i>
                            </a>
                        </template>
                    </div>

                    <div class="flex items-center lg:hidden">
                        <button
                            @click="toggleMenu"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-600 transition-colors hover:bg-blue-50 hover:text-blue-700 focus:outline-none"
                        >
                            <span class="sr-only">Buka menu utama</span>
                            <i
                                v-if="!isMenuOpen"
                                class="fa-solid fa-bars text-xl"
                            ></i>
                            <i v-else class="fa-solid fa-xmark text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div
                    v-show="isMenuOpen"
                    class="absolute w-full border-t border-gray-100 bg-white shadow-2xl lg:hidden"
                >
                    <div
                        class="h-[calc(100vh-120px)] space-y-1 overflow-y-auto px-4 pt-2 pb-6"
                    >
                        <template v-for="item in menuItems" :key="item.label">
                            <div v-if="item.subItems" class="py-2">
                                <div
                                    class="px-3 py-2 text-sm font-bold tracking-wider text-gray-400 uppercase"
                                >
                                    {{ item.label }}
                                </div>
                                <div
                                    class="mt-1 ml-3 space-y-1 border-l-2 border-gray-100 pl-3"
                                >
                                    <a
                                        v-for="subItem in item.subItems"
                                        :key="subItem.label"
                                        :href="subItem.href"
                                        class="block rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition-colors hover:bg-blue-50 hover:text-blue-700"
                                    >
                                        {{ subItem.label }}
                                    </a>
                                </div>
                            </div>

                            <a
                                v-else
                                :href="item.href"
                                :class="[
                                    item.isPrimary
                                        ? 'mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-800 px-4 py-3.5 text-base font-semibold text-white shadow-md'
                                        : 'block rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 transition-colors hover:bg-blue-50 hover:text-blue-700',
                                ]"
                            >
                                {{ item.label }}
                                <i
                                    v-if="item.isPrimary"
                                    class="fa-solid fa-arrow-right text-sm"
                                ></i>
                            </a>
                        </template>
                    </div>
                </div>
            </Transition>
        </nav>
    </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3'; // 👈 Import Inertia hook

const isMenuOpen = ref(false);

// 💡 Tangkap global shared props dari Inertia
const page = usePage();
const globalSettings = computed(() => page.props.globalSettings);

// 💡 Helper membaca path Storage Laravel untuk Logo
const getImageUrl = (path) => {
    if (!path) return null;
    if (path.startsWith('http://') || path.startsWith('https://')) return path;
    return `/storage/${path}`;
};

const handleResize = () => {
    if (window.innerWidth >= 1024 && isMenuOpen.value) {
        isMenuOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});

const menuItems = [
    { label: 'Beranda', href: '/' },
    {
        label: 'Tentang Kami',
        href: '#',
        subItems: [
            { label: 'Sejarah Sekolah', href: '/profil/sejarah' },
            { label: 'Visi & Misi', href: '/profil/visi-misi' },
        ],
    },
    {
        label: 'Kepegawaian',
        href: '#',
        subItems: [
            { label: 'Data Guru', href: '/sivitas/data-guru' },
            { label: 'Data Staf', href: '/sivitas/data-staf' },
        ],
    },
    {
        label: 'Kesiswaan',
        href: '#',
        subItems: [
            { label: 'Ekstrakurikuler', href: '/kesiswaan/ekstrakurikuler' },
            { label: 'Prestasi Siswa', href: '/kesiswaan/prestasi' },
            { label: 'Fasilitas', href: '/kesiswaan/fasilitas' },
        ],
    },
    {
        label: 'Pusat Informasi',
        href: '#',
        subItems: [
            { label: 'Pengumuman', href: '/pengumuman' },
            { label: 'Artikel & Berita', href: '/artikel' },
            { label: 'Galeri Kegiatan', href: '/galeri' },
        ],
    },
    { label: 'Hubungi Kami', href: '/contact', isPrimary: true },
];

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>
