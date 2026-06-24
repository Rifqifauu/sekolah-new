<script setup lang="ts">
import NavigationBar from '@/components/NavigationBar.vue';
import Footer from './Footer.vue';
</script>

<template>
    <div>
        <NavigationBar />
        <main>
            <slot />
        </main>
        <Footer />
    </div>
</template>
