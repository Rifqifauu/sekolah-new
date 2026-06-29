<template>
    <footer class="bg-blue-950 pt-16 pb-8 font-sans text-blue-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg shadow-blue-900/20"
                        >
                            <i
                                class="fa-solid fa-school text-xl text-white"
                            ></i>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-xl font-bold tracking-wide text-white"
                            >
                                SMP Negeri 1 Lorem Ipsum
                            </span>
                            <span class="text-xs font-medium text-blue-300">
                                Maju & Berprestasi
                            </span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-blue-200">
                        Mewujudkan generasi penerus bangsa yang unggul dalam
                        prestasi, berkarakter, dan berwawasan lingkungan
                        berlandaskan iman dan takwa.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.href"
                            target="_blank"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-900 text-blue-200 transition-all hover:-translate-y-1 hover:bg-blue-600 hover:text-white"
                        >
                            <i :class="social.icon"></i>
                            <span class="sr-only">{{ social.name }}</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="mb-6 text-lg font-semibold text-white">
                        Tautan Cepat
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="link in quickLinks" :key="link.label">
                            <a
                                :href="link.href"
                                class="group flex items-center text-sm font-medium text-blue-200 transition-colors hover:text-white"
                            >
                                <i
                                    class="fa-solid fa-angle-right mr-2 text-xs text-blue-500 transition-transform group-hover:translate-x-1"
                                ></i>
                                {{ link.label }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-6 text-lg font-semibold text-white">
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-4 text-sm text-blue-200">
                        <li class="flex items-start gap-3">
                            <i
                                class="fa-solid fa-location-dot mt-1 text-blue-500"
                            ></i>
                            <span class="leading-relaxed">
                                Jalan Pendidikan No. 123,<br />
                                Jakarta Selatan, DKI Jakarta<br />
                                Indonesia 12345
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-blue-500"></i>
                            <a
                                href="tel:+62211234567"
                                class="transition-colors hover:text-white"
                            >
                                (021) 1234567
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-blue-500"></i>
                            <a
                                href="mailto:info@smp1Lorem Ipsum.sch.id"
                                class="transition-colors hover:text-white"
                            >
                                info@smpn1Lorem Ipsum.sch.id
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-6 text-lg font-semibold text-white">
                        Lokasi Kami
                    </h3>
                    <div
                        class="overflow-hidden rounded-xl bg-blue-900 ring-1 ring-white/10"
                    >
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24009653198!2d106.7593179!3d-6.2297465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta%20Selatan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                            width="100%"
                            height="200"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale transition-all duration-300 hover:grayscale-0"
                        ></iframe>
                    </div>
                </div>
            </div>

            <div class="my-8 border-t border-blue-900/80"></div>

            <div
                class="flex flex-col items-center justify-between gap-4 md:flex-row"
            >
                <p class="text-center text-sm text-blue-300 md:text-left">
                    &copy; {{ currentYear }} SMP Negeri 1 Lorem Ipsum. Hak Cipta
                    Dilindungi Undang-Undang.
                </p>
                <div class="flex items-center gap-4 text-sm text-blue-300">
                    <a
                        href="/privacy-policy"
                        class="transition-colors hover:text-white"
                        >Kebijakan Privasi</a
                    >
                    <span>&bull;</span>
                    <a href="/terms" class="transition-colors hover:text-white"
                        >Syarat & Ketentuan</a
                    >
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue';

const currentYear = computed(() => new Date().getFullYear());

const socialLinks = [
    { name: 'Facebook', href: '#', icon: 'fa-brands fa-facebook-f' },
    { name: 'Instagram', href: '#', icon: 'fa-brands fa-instagram' },
    { name: 'WhatsApp', href: '#', icon: 'fa-brands fa-whatsapp' },
    { name: 'YouTube', href: '#', icon: 'fa-brands fa-youtube' },
];

const quickLinks = [
    { label: 'Beranda', href: '/' },
    { label: 'Profil Sekolah', href: '/profil' },
    { label: 'Pengumuman', href: '/pengumuman' },
    { label: 'Artikel & Berita', href: '/artikel' },
    { label: 'Galeri Kegiatan', href: '/galeri' },
];
</script>
