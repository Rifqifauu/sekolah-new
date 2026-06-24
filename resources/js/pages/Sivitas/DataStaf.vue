<template>
    <Head title="Data Staf" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-10 flex flex-col items-center text-center md:mb-12"
                >
                    <div class="mb-2 inline-flex items-center gap-2">
                        <span class="h-px w-8 bg-blue-600"></span>
                        <span
                            class="text-xs font-bold tracking-widest text-blue-600 uppercase"
                            >Kepegawaian</span
                        >
                        <span class="h-px w-8 bg-blue-600"></span>
                    </div>
                    <h2
                        class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl md:text-4xl"
                    >
                        Direktori Data Staf
                    </h2>
                    <p
                        class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500"
                    >
                        Daftar tenaga kependidikan profesional yang mendukung
                        kelancaran operasional sekolah.
                    </p>
                </div>

                <div class="mx-auto mb-12 max-w-2xl">
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
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
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
                                placeholder="Cari nama atau NIP/NUPTK staf..."
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex shrink-0 items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus:ring-2 focus:ring-blue-500"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <div
                    v-if="!staff.data || staff.data.length === 0"
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
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <article
                        v-for="item in staff.data"
                        :key="item.id"
                        class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:ring-blue-200"
                    >
                        <div
                            class="h-20 w-full bg-gradient-to-r from-blue-500 to-blue-600"
                        ></div>

                        <div
                            class="relative flex flex-col items-center px-5 pb-5"
                        >
                            <div
                                class="-mt-10 mb-3 overflow-hidden rounded-full border-4 border-white bg-white shadow-sm"
                            >
                                <img
                                    :src="`https://ui-avatars.com/api/?name=${item.name.replace(/ /g, '+')}&background=ecfdf5&color=000000&size=128&bold=true`"
                                    :alt="item.name"
                                    class="h-20 w-20 object-cover"
                                />
                            </div>

                            <h3
                                class="line-clamp-1 text-center text-lg font-bold text-gray-900"
                            >
                                {{ item.name }}
                            </h3>
                            <p
                                class="mt-0.5 text-center text-xs font-semibold tracking-wider text-blue-600 uppercase"
                            >
                                {{ item.id_number || 'NIP/NUPTK Belum Diisi' }}
                            </p>

                            <div class="mt-3">
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold tracking-wider text-blue-700 uppercase ring-1 ring-blue-200 ring-inset"
                                >
                                    {{
                                        item.role === 'staff'
                                            ? 'Staf Kependidikan'
                                            : item.role
                                    }}
                                </span>
                            </div>

                            <div class="my-4 h-px w-full bg-gray-100"></div>

                            <div class="w-full space-y-2.5">
                                <div
                                    class="flex items-center gap-2.5 text-sm text-gray-600"
                                >
                                    <svg
                                        class="h-4 w-4 shrink-0 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span class="truncate">{{
                                        item.email || '-'
                                    }}</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 text-sm text-gray-600"
                                >
                                    <svg
                                        class="h-4 w-4 shrink-0 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        />
                                    </svg>
                                    <span class="truncate">{{
                                        item.phone || '-'
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-if="staff.links && staff.links.length > 3"
                    class="mt-12 flex justify-center"
                >
                    <div
                        class="inline-flex shrink-0 items-center gap-1 rounded-full border border-gray-200 bg-white p-1 shadow-sm"
                    >
                        <template
                            v-for="(link, index) in staff.links"
                            :key="index"
                        >
                            <div
                                v-if="link.url === null"
                                class="flex h-10 min-w-[2.5rem] items-center justify-center px-3 text-sm text-gray-400"
                                v-html="link.label"
                            ></div>
                            <div
                                v-else-if="link.active"
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full bg-blue-600 px-3 text-sm font-medium text-white shadow-sm"
                                v-html="link.label"
                            ></div>
                            <Link
                                v-else
                                :href="link.url"
                                preserve-scroll
                                class="flex h-10 min-w-[2.5rem] items-center justify-center rounded-full px-3 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100"
                            >
                                <span v-html="link.label"></span>
                            </Link>
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
    staff: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');

const handleSearch = () => {
    router.get(
        '/sivitas/data-staf', // Sesuaikan dengan route Anda
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>
