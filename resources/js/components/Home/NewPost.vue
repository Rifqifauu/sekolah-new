<script setup>
import { computed } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [], // Default array kosong
    },
});

// Helper untuk format tanggal agar dinamis sesuai data database
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Mengolah data agar memiliki properti yang dibutuhkan template
const processedPosts = computed(() => {
    return props.posts.map((post) => ({
        ...post,
        formattedDate: formatDate(post.created_at),
        link: `/artikel/${post.slug}`, // Sesuaikan dengan route detail artikel Anda
        category: 'Berita', // Atau ambil dari kolom kategori jika ada
        author: post.user?.name || 'Admin', // Mengambil relasi user jika ada
    }));
});

const featuredArticle = computed(() => processedPosts.value[0]);
const otherArticles = computed(() => processedPosts.value.slice(1));
</script>

<template>
    <section class="bg-white py-16" v-if="posts.length > 0">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="mb-12 flex flex-col items-center justify-between gap-4 sm:flex-row md:mb-16"
            >
                <div>
                    <div class="mb-2 inline-flex items-center gap-3">
                        <span class="h-px w-8 bg-yellow-500"></span>
                        <span
                            class="text-sm font-bold tracking-widest text-yellow-600 uppercase"
                            >Informasi Terkini</span
                        >
                    </div>
                    <h2
                        class="text-3xl font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Berita & Artikel
                    </h2>
                </div>
                <a
                    href="/artikel"
                    class="group inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 shadow-sm ring-1 ring-gray-200 transition-all hover:bg-blue-50 hover:ring-blue-200"
                >
                    Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-12">
                <article
                    v-if="featuredArticle"
                    class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl lg:col-span-7 xl:col-span-8"
                >
                    <div
                        class="relative aspect-[16/10] w-full overflow-hidden bg-gray-200"
                    >
                        <img
                            :src="`/storage/${featuredArticle.image}`"
                            :alt="featuredArticle.title"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            class="absolute top-4 left-4 rounded-md bg-blue-600/90 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm"
                        >
                            Berita Utama
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col p-6 sm:p-10">
                        <div
                            class="mb-4 flex items-center gap-4 text-sm text-gray-500"
                        >
                            <span
                                ><i class="fa-regular fa-calendar mr-1"></i>
                                {{ featuredArticle.formattedDate }}</span
                            >
                            <span
                                ><i class="fa-regular fa-user mr-1"></i>
                                {{ featuredArticle.author }}</span
                            >
                        </div>
                        <h3
                            class="mb-4 text-2xl font-extrabold text-gray-900 sm:text-3xl lg:text-4xl"
                        >
                            <a :href="featuredArticle.link"
                                ><span class="absolute inset-0"></span
                                >{{ featuredArticle.title }}</a
                            >
                        </h3>
                        <p class="mb-8 text-gray-600">
                            {{ featuredArticle.content?.substring(0, 150) }}...
                        </p>
                    </div>
                </article>

                <div class="flex flex-col gap-6 lg:col-span-5 xl:col-span-4">
                    <h3
                        class="border-b-2 border-gray-100 pb-3 text-lg font-bold text-gray-900"
                    >
                        Berita Lainnya
                    </h3>
                    <article
                        v-for="item in otherArticles"
                        :key="item.id"
                        class="group relative flex flex-col rounded-xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-lg"
                    >
                        <div
                            class="mb-3 flex justify-between text-xs font-semibold text-blue-600"
                        >
                            <span>Berita</span>
                            <span class="text-gray-400">{{
                                item.formattedDate
                            }}</span>
                        </div>
                        <h4
                            class="mb-2 text-lg font-bold text-gray-900 group-hover:text-blue-700"
                        >
                            <a :href="item.link"
                                ><span class="absolute inset-0"></span
                                >{{ item.title }}</a
                            >
                        </h4>
                    </article>
                </div>
            </div>
        </div>
    </section>
</template>
