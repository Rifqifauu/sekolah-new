<script setup lang="ts">
import AppLayout from '@/components/AppLayout.vue';
import Announcement from '@/components/Home/Announcement.vue';
import Extra from '@/components/Home/Extra.vue';
import Gallery from '@/components/Home/Gallery.vue';
import HeroSection from '@/components/Home/HeroSection.vue';
import NewPost from '@/components/Home/NewPost.vue';
import WelcomeMessage from '@/components/Home/WelcomeMessage.vue';
</script>

<template>
    <AppLayout>
        <HeroSection />
        <WelcomeMessage />
        <NewPost />
        <Announcement />
        <Gallery />
        <Extra />
    </AppLayout>
</template>
