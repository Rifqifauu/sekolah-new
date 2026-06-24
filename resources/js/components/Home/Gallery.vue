<template>
    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center sm:mb-14">
                <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    Galeri Kegiatan
                </h2>
                <p class="mt-4 text-lg text-slate-600">
                    Dokumentasi momen berharga dan aktivitas seru di lingkungan
                    sekolah kami.
                </p>
            </div>

            <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
            >
                <div
                    v-for="(item, index) in displayedGallery"
                    :key="index"
                    @click="openModal(item)"
                    class="group relative aspect-square cursor-pointer overflow-hidden rounded-xl bg-slate-200 shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl"
                >
                    <img
                        v-if="item.type === 'image'"
                        :src="item.path"
                        alt="Galeri Sekolah"
                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                    />

                    <div
                        v-else-if="item.type === 'video'"
                        class="h-full w-full"
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
                                <i class="fa-solid fa-play ml-1 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="item.type === 'image'"
                        class="absolute inset-0 flex items-center justify-center bg-blue-900/0 opacity-0 transition-all duration-300 group-hover:bg-blue-900/40 group-hover:opacity-100"
                    >
                        <i
                            class="fa-solid fa-magnifying-glass-plus text-3xl text-white"
                        ></i>
                    </div>
                </div>
            </div>

            <div v-if="visibleCount < gallery.length" class="mt-12 text-center">
                <button
                    @click="loadMore"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-blue-600 px-8 py-3.5 text-base font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-600/30"
                >
                    Lihat Lebih Banyak
                    <i class="fa-solid fa-arrow-down text-sm"></i>
                </button>
            </div>
        </div>

        <transition name="fade">
            <div
                v-if="selectedItem"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4 backdrop-blur-sm"
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
                        :src="selectedItem.path"
                        class="max-h-[85vh] w-auto object-contain"
                        alt="Preview Galeri"
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
    </section>
</template>

<script setup>
import { ref, computed } from 'vue';

// State untuk membatasi jumlah item yang tampil di awal (4 item)
const visibleCount = ref(4);
const selectedItem = ref(null);

// Data Asli Array Galeri (Berisi 8 item dummy)
const gallery = ref([
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop',
    },
    { type: 'video', path: 'https://www.w3schools.com/html/mov_bbb.mp4' },
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800&auto=format&fit=crop',
    },
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop',
    },
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop',
    },
    {
        type: 'video',
        path: 'https://cdn.pixabay.com/video/2020/05/25/40156-424810777_tiny.mp4',
    },
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop',
    },
    {
        type: 'image',
        path: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
    },
]);

// Computed property: Memotong array galeri sesuai angka visibleCount
const displayedGallery = computed(() => {
    return gallery.value.slice(0, visibleCount.value);
});

// Fungsi untuk menambah jumlah item yang tampil saat tombol ditekan (+4 item)
const loadMore = () => {
    visibleCount.value += 4;
};

// Fungsi Modal
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
