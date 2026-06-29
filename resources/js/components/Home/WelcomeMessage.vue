<template>
    <section class="relative overflow-hidden bg-white py-16">
        <!-- Dekorasi Background -->
        <div
            class="absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-blue-50 opacity-50 blur-3xl"
        ></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-16"
            >
                <!-- Bagian Kiri: Foto Kepala Sekolah -->
                <div class="relative mx-auto w-full max-w-md lg:mx-0">
                    <!-- Bingkai Aksesoris Belakang -->
                    <div
                        class="absolute -top-4 -left-4 h-full w-full rounded-2xl bg-blue-100 transition-transform duration-300"
                    ></div>
                    <div
                        class="absolute -right-4 -bottom-4 h-full w-full rounded-2xl border-2 border-dashed border-blue-600"
                    ></div>

                    <!-- Kontainer Foto -->
                    <div
                        class="group relative overflow-hidden rounded-2xl bg-white shadow-xl shadow-blue-900/10"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Kepala Sekolah"
                            class="aspect-[4/5] w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <!-- Label Nama (Muncul dari bawah) -->
                        <div
                            class="absolute bottom-0 w-full bg-gradient-to-t from-blue-950 via-blue-900/80 to-transparent px-6 pt-16 pb-6"
                        >
                            <h3 class="text-xl font-bold text-white">
                                Drs. Budi Santoso, M.Pd.
                            </h3>
                            <p class="mt-1 text-sm font-medium text-blue-200">
                                Kepala SMP Negeri 1 Lorem Ipsum
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Kanan: Teks Sambutan -->
                <div class="flex flex-col justify-center">
                    <!-- Sub-heading -->
                    <div class="mb-4 inline-flex items-center gap-3">
                        <span class="h-px w-10 bg-blue-600"></span>
                        <span
                            class="text-sm font-bold tracking-widest text-blue-700 uppercase"
                            >Sambutan Kepala Sekolah</span
                        >
                    </div>

                    <!-- Heading -->
                    <h2
                        class="mb-6 text-3xl leading-tight font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Selamat Datang di <br />
                        <span
                            class="bg-gradient-to-r from-blue-600 to-blue-900 bg-clip-text text-transparent"
                            >SMP Negeri 1 Lorem Ipsum</span
                        >
                    </h2>

                    <!-- Paragraf Isi -->
                    <div
                        class="space-y-5 text-justify text-lg leading-relaxed text-gray-600"
                    >
                        <p>
                            Puji syukur kita panjatkan ke hadirat Tuhan Yang
                            Maha Esa atas segala rahmat dan karunia-Nya. Selamat
                            datang di website resmi kami, wadah informasi dan
                            komunikasi bagi seluruh keluarga besar sekolah serta
                            masyarakat luas.
                        </p>
                        <p>
                            Di era digital ini, kami berkomitmen untuk terus
                            berinovasi dalam memberikan layanan pendidikan
                            terbaik. Kami mendidik siswa-siswi bukan hanya agar
                            unggul secara akademik, tetapi juga memiliki
                            karakter yang kuat, berakhlak mulia, dan siap
                            menghadapi tantangan global.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// Tidak ada script khusus yang dibutuhkan untuk komponen statis ini
// Namun Anda bisa mengganti URL gambar atau teks dengan Props (defineProps)
// jika datanya ingin diambil dari database di masa mendatang.
</script>
