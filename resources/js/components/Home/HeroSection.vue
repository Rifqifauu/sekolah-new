<template>
    <section
        class="relative overflow-hidden bg-slate-50 pt-16 pb-20 lg:pt-24 lg:pb-28"
    >
        <!-- Background Pattern (Subtle) -->
        <div
            class="pointer-events-none absolute inset-0 opacity-5"
            style="
                background-image: radial-gradient(#1e3a8a 1px, transparent 1px);
                background-size: 32px 32px;
            "
        ></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2 lg:gap-12"
            >
                <!-- KIRI: TEKS & CTA -->
                <div class="max-w-2xl text-center lg:text-left">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-100/50 px-4 py-1.5"
                    >
                        <span class="relative flex h-2.5 w-2.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-600 opacity-75"
                            ></span>
                            <span
                                class="relative inline-flex h-2.5 w-2.5 rounded-full bg-blue-600"
                            ></span>
                        </span>
                        <span
                            class="text-sm font-bold tracking-wide text-blue-900"
                            >Selamat Datang di</span
                        >
                    </div>

                    <h1
                        class="text-4xl leading-[1.1] font-extrabold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl"
                    >
                        Website Resmi
                        <br />
                        SMP Negeri
                        <span class="text-blue-700">1 Jelbuk.</span>
                    </h1>

                    <p
                        class="mt-6 text-lg leading-relaxed text-slate-600 sm:text-xl"
                    >
                        Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Ipsa repellat facilis dolorem perferendis, rem
                        officia sequi illo natus saepe quo.
                    </p>

                    <!-- Statistik Sekolah (Lebih cocok dari sekadar checklist) -->
                    <div
                        class="mt-10 grid grid-cols-3 gap-4 border-y border-slate-200 py-6 text-center lg:gap-8 lg:divide-x lg:divide-slate-200 lg:text-left"
                    >
                        <div class="lg:pr-4">
                            <p class="text-3xl font-bold text-blue-700">A</p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Akreditasi
                            </p>
                        </div>
                        <div class="lg:px-4">
                            <p class="text-3xl font-bold text-blue-700">45+</p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Pengajar Ahli
                            </p>
                        </div>
                        <div class="lg:pl-4">
                            <p class="text-3xl font-bold text-blue-700">1.2K</p>
                            <p class="mt-1 text-sm font-medium text-slate-500">
                                Siswa Aktif
                            </p>
                        </div>
                    </div>

                    <div
                        class="mt-8 flex flex-col items-center gap-4 sm:flex-row lg:justify-start"
                    >
                        <a
                            href="/contact"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-8 py-3.5 text-base font-semibold text-white transition-all hover:bg-blue-800 focus:ring-4 focus:ring-blue-100 sm:w-auto"
                        >
                            Hubungi Kami
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a
                            href="/profil"
                            class="group inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-8 py-3.5 text-base font-semibold text-slate-700 transition-all hover:bg-slate-50 sm:w-auto"
                        >
                            <i class="fa-solid fa-play text-blue-600"></i>
                            Video Profil
                        </a>
                    </div>
                </div>

                <!-- KANAN: KOMPOSISI GAMBAR GRID -->
                <div class="relative mx-auto w-full max-w-lg lg:max-w-none">
                    <!-- Ornamen -->
                    <div
                        class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-yellow-400 opacity-50 blur-2xl"
                    ></div>
                    <div
                        class="absolute -bottom-4 -left-4 h-32 w-32 rounded-full bg-blue-600 opacity-20 blur-2xl"
                    ></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <!-- Foto 1 (Portrait) -->
                            <div
                                class="relative overflow-hidden rounded-2xl shadow-lg"
                            >
                                <img
                                    src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop"
                                    alt="Siswa berprestasi"
                                    class="h-64 w-full object-cover transition duration-500 hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"
                                ></div>
                            </div>
                            <!-- Foto 2 (Landscape) -->
                            <div
                                class="relative overflow-hidden rounded-2xl shadow-lg"
                            >
                                <img
                                    src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop"
                                    alt="Kegiatan belajar"
                                    class="h-48 w-full object-cover transition duration-500 hover:scale-105"
                                />
                            </div>
                        </div>
                        <div class="space-y-4 pt-12">
                            <!-- Foto 3 (Portrait panjang) -->
                            <div
                                class="relative overflow-hidden rounded-2xl shadow-lg"
                            >
                                <img
                                    src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop"
                                    alt="Fasilitas sekolah"
                                    class="h-80 w-full object-cover transition duration-500 hover:scale-105"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// Script jadi lebih bersih karena kita tidak memakai complex slider
// Cukup elemen UI statis namun interaktif melalui CSS hover.
</script>

<style scoped>
@keyframes bounce-slow {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
.animate-bounce-slow {
    animation: bounce-slow 4s ease-in-out infinite;
}
</style>
