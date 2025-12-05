<script setup>
import { Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
  product: {
    type: Object,
    default: () => ({}),
  },
});

// // Schema.org
// useSchemaOrg([
//   defineOrganization({
//     name: "Dummy Brand Company",
//     logo: "/images/dummy-logo.png",
//     url: "https://example.com",
//   }),
//   defineWebPage({
//     name: "Dummy Product Page – High Quality Sample Item",
//     description: "This is a dummy product used for SEO testing.",
//     url: "https://example.com/products/dummy-product",
//   }),
//   defineProduct({
//     name: "Dummy Product – High Quality Sample Item",
//     description: "This is a dummy product used for SEO testing.",
//     image: "/images/dummy-product.png",
//     sku: "DUMMY-12345",
//     brand: { name: "Dummy Brand" },
//     offers: {
//       price: 49.99,
//       priceCurrency: "USD",
//       url: "https://example.com/products/dummy-product",
//       availability: "https://schema.org/InStock",
//       itemCondition: "https://schema.org/NewCondition",
//     },
//   }),
// ]);
</script>

<template>
  <Head>
    <!-- SEO Meta -->
    <title>{{ product.metatitle }}</title>
    <meta name="description" :content="product.metadescription" />
    <meta name="keywords" :content="product.metakeyword" />
    <link rel="canonical" :href="product.url" />

    <!-- Open Graph -->
    <meta property="og:title" :content="product.metatitle" />
    <meta property="og:description" :content="product.metadescription" />
    <meta property="og:image" :content="product.image || ''" />
    <meta property="og:type" content="product" />
    <meta property="og:url" :content="product.canonicalurl" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="product.metatitle" />
    <meta name="twitter:description" :content="product.metadescription" />
    <meta name="twitter:image" :content="product.image || ''" />

    <!-- Robots & Author -->
    <meta name="robots" content="index, follow" />
    <meta name="author" content="BT Tex Access" />
  </Head>
</template>
