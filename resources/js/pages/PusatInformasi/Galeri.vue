<template>
    <Head title="Galeri Kegiatan" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 sm:mb-14">
                    <div class="mb-3 inline-flex items-center gap-3">
                        <span class="h-px w-10 bg-blue-600"></span>
                        <span
                            class="text-sm font-bold tracking-widest text-blue-600 uppercase"
                        >
                            Dokumentasi
                        </span>
                    </div>
                    <h2
                        class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl"
                    >
                        Galeri Kegiatan
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg text-gray-600">
                        Dokumentasi momen berharga dan aktivitas seru di
                        lingkungan sekolah kami.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
                >
                    <div
                        v-for="item in media.data"
                        :key="item.id"
                        @click="openModal(item)"
                        role="button"
                        class="group relative aspect-square cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl"
                    >
                        <img
                            v-if="item.type === 'image'"
                            :src="
                                item.path.startsWith('http')
                                    ? item.path
                                    : `/storage/${item.path}`
                            "
                            alt="Galeri Sekolah"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />

                        <div
                            v-else-if="item.type === 'video'"
                            class="relative h-full w-full"
                        >
                            <video
                                :src="item.path"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                muted
                                loop
                                playsinline
                                @mouseenter="$event.target.play()"
                                @mouseleave="$event.target.pause()"
                            ></video>
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/20 transition-all group-hover:bg-black/40"
                            >
                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-blue-600 shadow-lg backdrop-blur-sm transition-transform group-hover:scale-110"
                                >
                                    <i
                                        class="fa-solid fa-play ml-1 text-xl"
                                    ></i>
                                </div>
                            </div>
                        </div>

                        <div
                            class="absolute inset-0 flex items-center justify-center bg-blue-900/0 opacity-0 transition-all duration-300 group-hover:bg-blue-900/40 group-hover:opacity-100"
                        >
                            <i
                                class="fa-solid fa-magnifying-glass-plus text-3xl text-white"
                            ></i>
                        </div>
                    </div>
                </div>

                <div
                    v-if="paginationLinks.length > 3"
                    class="mt-16 flex justify-center"
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

        <transition name="fade">
            <div
                v-if="selectedItem"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
                @click.self="closeModal"
            >
                <button
                    @click="closeModal"
                    class="absolute top-6 right-6 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:scale-110 hover:bg-white/20"
                >
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>

                <div
                    class="relative max-h-[90vh] max-w-5xl overflow-hidden rounded-lg shadow-2xl"
                >
                    <img
                        v-if="selectedItem.type === 'image'"
                        :src="
                            selectedItem.path.startsWith('http')
                                ? selectedItem.path
                                : `/storage/${selectedItem.path}`
                        "
                        class="max-h-[85vh] w-auto object-contain"
                        alt="Preview"
                    />
                    <video
                        v-else-if="selectedItem.type === 'video'"
                        :src="selectedItem.path"
                        class="max-h-[85vh] w-auto bg-black object-contain"
                        controls
                        autoplay
                    ></video>
                </div>
            </div>
        </transition>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'; // Tambahkan computed
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    media: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
});

const selectedItem = ref(null);

// Computed Property Pagination agar aman dari bug
const paginationLinks = computed(() => {
    const links = props.media?.meta?.links || props.media?.links || [];

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
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    selectedItem.value = null;
    document.body.style.overflow = 'auto';
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
