<template>
    <Head title="Sejarah Sekolah" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-10 flex flex-col items-center text-center md:mb-16"
                >
                    <div class="mb-2 inline-flex items-center gap-2">
                        <span class="h-px w-8 bg-blue-600"></span>
                        <span
                            class="text-xs font-bold tracking-widest text-blue-600 uppercase"
                        >
                            Tentang Kami
                        </span>
                        <span class="h-px w-8 bg-blue-600"></span>
                    </div>
                    <h2
                        class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl md:text-4xl"
                    >
                        Sejarah Sekolah
                    </h2>
                </div>

                <div
                    class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16"
                >
                    <div class="order-2 lg:order-1">
                        <div
                            class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 sm:p-10"
                        >
                            <h3 class="mb-6 text-2xl font-bold text-gray-900">
                                Perjalanan Kami
                            </h3>
                            <p
                                class="text-base leading-relaxed whitespace-pre-line text-gray-600 sm:text-lg"
                            >
                                {{ historyDescription }}
                            </p>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div
                            class="group relative aspect-[4/3] w-full overflow-hidden rounded-3xl bg-gray-200 shadow-sm ring-1 ring-gray-100 sm:aspect-video lg:aspect-[4/3]"
                        >
                            <img
                                v-if="historyImage"
                                :src="historyImage"
                                alt="Foto Sejarah Sekolah"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
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
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900/20 to-transparent"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { computed, defineProps } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({}),
    },
});

// Data Dummy Fallback
const defaultData = {
    image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1000&auto=format&fit=crop',
    description: `SekolahKu didirikan pada tahun 1990 dengan semangat gotong royong masyarakat setempat yang peduli akan pentingnya pendidikan bagi generasi penerus. Di masa awal berdirinya, sekolah ini hanya menempati sebuah bangunan sederhana dengan tiga ruang kelas dan fasilitas yang sangat terbatas.

Seiring berjalannya waktu, dedikasi para tenaga pengajar dan dukungan penuh dari berbagai pihak membuat sekolah ini perlahan berkembang. Pembangunan fasilitas pendidikan yang lebih modern mulai direalisasikan, mulai dari laboratorium sains, perpustakaan yang komprehensif, hingga sarana olahraga.

Kini, dengan mengintegrasikan teknologi dan kurikulum yang adaptif, SekolahKu terus berkomitmen untuk tidak hanya mencetak siswa yang cerdas secara akademik, namun juga memiliki karakter dan akhlak yang mulia.`,
};

// Mengambil data dari props settings jika ada
const historyImage = computed(
    () => props.settings?.history_image || defaultData.image,
);
const historyDescription = computed(
    () => props.settings?.history_description || defaultData.description,
);
</script>
