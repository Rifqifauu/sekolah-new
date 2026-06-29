<template>
    <Head title="Hubungi Kami" />

    <AppLayout>
        <section class="min-h-screen bg-slate-50/50 py-12 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <div class="mb-2 flex items-center justify-center gap-2">
                        <span class="h-0.5 w-8 rounded-full bg-blue-600"></span>
                        <span
                            class="text-xs font-bold tracking-widest text-blue-600 uppercase"
                            >Informasi & Kontak</span
                        >
                        <span class="h-0.5 w-8 rounded-full bg-blue-600"></span>
                    </div>
                    <h2
                        class="text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl"
                    >
                        Hubungi Kami
                    </h2>
                    <p class="mt-3 text-base text-slate-500">
                        Silakan hubungi kami melalui kontak resmi di bawah ini
                        atau kunjungi langsung lokasi kampus kami pada jam
                        operasional kerja.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-2"
                >
                    <div
                        class="flex flex-col justify-between gap-6 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8"
                    >
                        <div>
                            <h3
                                class="mb-6 flex items-center gap-2 text-xl font-bold text-slate-900"
                            >
                                <i class="fas fa-headset text-blue-600"></i>
                                Layanan Informasi
                            </h3>

                            <div class="flex flex-col gap-6">
                                <div class="flex gap-4">
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-blue-100 bg-blue-50 text-lg text-blue-600"
                                    >
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            Alamat Kampus
                                        </h4>
                                        <p
                                            class="mt-1 text-sm leading-relaxed text-slate-500"
                                        >
                                            Jl. Pendidikan No. 45, Kota Merdeka,
                                            Indonesia
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-blue-100 bg-blue-50 text-lg text-blue-600"
                                    >
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            Nomor Telepon
                                        </h4>
                                        <p class="mt-1 text-sm text-slate-500">
                                            (021) 1234-5678
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-blue-100 bg-blue-50 text-lg text-blue-600"
                                    >
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800"
                                        >
                                            Surel / Email
                                        </h4>
                                        <p class="mt-1 text-sm text-slate-500">
                                            info@sekolahkita.sch.id
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-2 flex gap-4 border-t border-slate-100 pt-6"
                        >
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-emerald-100 bg-emerald-50 text-lg text-emerald-600"
                            >
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">
                                    Jam Operasional
                                </h4>
                                <p class="mt-1 text-sm text-slate-500">
                                    Senin - Jumat:
                                    <span class="font-semibold text-slate-700"
                                        >07:00 - 15:00 WIB</span
                                    >
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400">
                                    Sabtu, Minggu & Hari Libur Nasional: Tutup
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="min-h-[350px] overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-sm lg:min-h-full"
                    >
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.5634786227!2d107.57311641640626!3d-6.9034443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f9c0e3efcd2!2sBandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                            class="h-full min-h-[350px] w-full rounded-xl border-0 lg:h-full"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        >
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/components/AppLayout.vue';
</script>
