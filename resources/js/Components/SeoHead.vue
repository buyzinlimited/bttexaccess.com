<script setup>
import { Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
  title: String,
  description: String,
  keywords: {
    type: String,
    default: "",
  },
  image: {
    type: String,
    default: "https://bttexaccess.com/og-image.jpg",
  },
  url: {
    type: String,
    default: () => useRequestURL().href,
  },
});
</script>

<template>
  <Head>
    <!-- SEO Meta -->
    <title>{{ props.title }}</title>
    <meta name="description" :content="props.description" />
    <meta name="keywords" :content="props.keywords" />
    <link rel="canonical" :href="props.url" />

    <!-- Open Graph -->
    <meta property="og:title" :content="props.title" />
    <meta property="og:description" :content="props.description" />
    <meta property="og:image" :content="props.image" />
    <meta property="og:type" content="product" />
    <meta property="og:url" :content="props.url" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="props.title" />
    <meta name="twitter:description" :content="props.description" />
    <meta name="twitter:image" :content="props.image" />

    <!-- Robots & Author -->
    <meta name="robots" content="index, follow" />
    <meta name="author" content="BT Tex Access" />
  </Head>
</template>
