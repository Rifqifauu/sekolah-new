<template>
    <Head title="Visi & Misi Sekolah" />

    <AppLayout>
        <section class="min-h-screen bg-gray-50 py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="mb-12 flex flex-col items-center text-center md:mb-16"
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
                        Visi & Misi
                    </h2>
                    <p
                        class="mt-2 max-w-xl text-sm leading-relaxed text-gray-500"
                    >
                        Arah dan tujuan utama kami dalam menyelenggarakan
                        pendidikan yang berkualitas, berkarakter, dan berdaya
                        saing global.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-16"
                >
                    <div class="lg:col-span-5">
                        <div class="sticky top-24">
                            <div class="mb-6">
                                <h3
                                    class="text-xl font-extrabold text-gray-900 sm:text-2xl"
                                >
                                    Visi Sekolah
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Cita-cita utama yang ingin dicapai.
                                </p>
                            </div>

                            <div
                                class="group relative overflow-hidden rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:ring-blue-200 sm:p-8"
                            >
                                <div
                                    class="absolute -top-16 -right-16 h-36 w-36 rounded-full bg-blue-50 opacity-40 blur-2xl"
                                ></div>

                                <p
                                    class="text-xl leading-relaxed font-bold text-gray-900 sm:text-2xl"
                                >
                                    "{{ visiData }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7">
                        <div class="mb-6">
                            <h3
                                class="text-xl font-extrabold text-gray-900 sm:text-2xl"
                            >
                                Misi Sekolah
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Langkah-langkah strategis untuk mewujudkan visi
                                kami.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div
                                v-for="(misi, index) in misiData"
                                :key="index"
                                class="group relative flex items-start gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:ring-blue-200"
                            >
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-600 ring-1 ring-blue-100 transition-colors duration-300 ring-inset group-hover:bg-blue-600 group-hover:text-white"
                                >
                                    {{ String(index + 1).padStart(2, '0') }}
                                </div>

                                <div class="pt-2">
                                    <p
                                        class="text-sm leading-relaxed whitespace-pre-line text-gray-600"
                                    >
                                        {{ misi.description }}
                                    </p>
                                </div>
                            </div>
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

const defaultData = {
    visi: 'Terwujudnya peserta didik yang religius, cerdas, terampil, mandiri, dan berwawasan lingkungan.',
    misi: [
        {
            description:
                'Menanamkan keimanan dan ketakwaan melalui pengamalan ajaran agama.',
        },
        {
            description:
                'Mengoptimalkan proses pembelajaran dan bimbingan secara efektif dan efisien.',
        },
        {
            description:
                'Membina kemandirian peserta didik melalui kegiatan pembiasaan, kewirausahaan, dan pengembangan diri yang terencana.',
        },
        {
            description:
                'Menjalin kerja sama yang harmonis antar warga sekolah dan lembaga terkait.',
        },
        {
            description:
                'Mewujudkan lingkungan sekolah yang bersih, asri, dan nyaman untuk mendukung proses KBM.',
        },
    ],
};

const visiData = computed(
    () => props.settings?.school_vision || defaultData.visi,
);

const misiData = computed(() => {
    let data = props.settings?.school_missions;
    if (typeof data === 'string') {
        try {
            data = JSON.parse(data);
        } catch (e) {
            data = null;
        }
    }
    return data && data.length > 0 ? data : defaultData.misi;
});
</script>
