<template>
    <Head title="Data Guru" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-8 flex flex-col items-center text-center md:mb-10"
                >
                    <div class="mb-2 inline-flex items-center gap-2">
                        <span class="h-px w-8 bg-blue-600"></span>
                        <span
                            class="text-xs font-bold tracking-widest text-blue-600 uppercase"
                        >
                            Kepegawaian
                        </span>
                        <span class="h-px w-8 bg-blue-600"></span>
                    </div>
                    <h2
                        class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl md:text-4xl"
                    >
                        Direktori Data Guru
                    </h2>
                    <p
                        class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500"
                    >
                        Daftar tenaga pendidik profesional yang berdedikasi
                        membimbing dan mencerdaskan peserta didik.
                    </p>
                </div>

                <div class="mx-auto mb-10 max-w-2xl">
                    <form
                        @submit.prevent="handleSearch"
                        class="flex items-center gap-2"
                    >
                        <div class="relative w-full">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                            >
                                <i
                                    class="fa-solid fa-magnifying-glass text-indigo-400"
                                ></i>
                            </div>
                            <input
                                type="text"
                                v-model="search"
                                class="block w-full rounded-full border-gray-300 bg-white py-3 pr-4 pl-11 text-sm text-gray-900 shadow-sm transition-colors focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Cari nama atau NIP/NUPTK guru..."
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
                    v-if="!teachers.data || teachers.data.length === 0"
                    class="flex flex-col items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-16 text-center shadow-sm"
                >
                    <div class="mb-4 rounded-full bg-gray-50 p-4">
                        <svg
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Data Tidak Ditemukan
                    </h3>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <article
                        v-for="item in teachers.data"
                        :key="item.id"
                        class="group flex h-full flex-col overflow-hidden rounded-xl border border-blue-900 bg-white shadow-sm ring-1 ring-gray-200 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:ring-blue-300"
                    >
                        <div class="flex items-start gap-3 p-4 pb-3">
                            <div
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-md ring-2 ring-blue-50"
                            >
                                <img
                                    :src="
                                        item.image
                                            ? `/storage/${item.image}`
                                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}&background=EFF6FF&color=1D4ED8&size=128`
                                    "
                                    @error="
                                        (e) =>
                                            (e.target.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}&background=EFF6FF&color=1D4ED8&size=128`)
                                    "
                                    :alt="item.name"
                                    class="h-full w-full object-cover"
                                />
                            </div>

                            <div class="min-w-0 flex-1 pt-0.5">
                                <h3
                                    class="truncate text-sm leading-snug font-bold text-gray-900 group-hover:text-blue-700"
                                    :title="item.name"
                                >
                                    {{ item.name }}
                                </h3>
                                <p
                                    class="mt-0.5 truncate text-xs leading-snug font-medium text-blue-600"
                                >
                                    {{
                                        item.id_number ||
                                        'NIP/NUPTK belum diisi'
                                    }}
                                </p>
                                <span
                                    class="mt-2 inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[10px] leading-4 font-bold tracking-wide text-blue-700 uppercase ring-1 ring-blue-600/20"
                                >
                                    {{ item.position }}
                                </span>
                            </div>
                        </div>

                        <div class="mx-4 h-px bg-gray-100"></div>

                        <div
                            class="flex flex-1 flex-col justify-between gap-3 p-4 pt-3 text-xs text-gray-600"
                        >
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2.5">
                                    <i
                                        class="fa-regular fa-envelope w-3.5 shrink-0 text-center text-gray-400"
                                    ></i>
                                    <span
                                        class="truncate font-medium"
                                        :title="item.email"
                                        >{{ item.email || '-' }}</span
                                    >
                                </div>

                                <div class="flex items-center gap-2.5">
                                    <i
                                        class="fa-solid fa-phone w-3.5 shrink-0 text-center text-gray-400"
                                    ></i>
                                    <span
                                        class="truncate font-medium"
                                        :title="item.phone"
                                        >{{ item.phone || '-' }}</span
                                    >
                                </div>
                            </div>

                            <div
                                v-if="item.classroom?.name"
                                class="flex items-center gap-2.5 rounded-lg bg-blue-50/80 px-2.5 py-1.5 font-semibold text-blue-700 ring-1 ring-blue-100 ring-inset"
                            >
                                <i
                                    class="fa-solid fa-chalkboard-user w-3.5 shrink-0 text-center text-blue-500"
                                ></i>
                                <span
                                    class="truncate"
                                    :title="item.classroom.name"
                                    >Wali Kelas: {{ item.classroom.name }}</span
                                >
                            </div>

                            <div
                                v-else-if="item.classroom_id"
                                class="flex items-center gap-2.5 rounded-lg bg-orange-50 px-2.5 py-1.5 font-medium text-orange-600 ring-1 ring-orange-100 ring-inset"
                            >
                                <i
                                    class="fa-solid fa-circle-exclamation w-3.5 shrink-0 text-center text-orange-400"
                                ></i>
                                <span class="truncate text-[11px] italic"
                                    >Data kelas belum diload</span
                                >
                            </div>
                        </div>
                    </article>
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
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full bg-blue-600 px-3 text-sm font-medium text-white shadow-sm"
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
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';

const props = defineProps({
    teachers: { type: Object, default: () => ({ data: [], links: [] }) },
    filters: { type: Object, default: () => ({ search: '' }) },
});

const search = ref(props.filters?.search || '');

const paginationLinks = computed(() => {
    const links = props.teachers?.meta?.links || props.teachers?.links || [];
    return links.map((link) => {
        let label = String(link.label || '');
        if (label.includes('Previous') || label.includes('pagination.previous'))
            label = '&laquo;';
        if (label.includes('Next') || label.includes('pagination.next'))
            label = '&raquo;';
        return { ...link, label };
    });
});

const handleSearch = () => {
    router.get(
        '/sivitas/data-guru',
        { search: search.value },
        { preserveState: true, preserveScroll: true, replace: true },
    );
};
</script>
