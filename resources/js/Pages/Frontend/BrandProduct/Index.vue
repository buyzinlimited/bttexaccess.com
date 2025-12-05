<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import Pagination  from "@/Components/Pagination.vue";
import {ref} from "vue";

const props = defineProps({
    brand:Object,
    brands: Array,
    products: Array
})
const isActive = ref(false);
</script>

<template>
    <Head>
        <title>{{ brand?.metatitle || brand?.name }}</title>
        <meta name="description" :content="brand?.metadescription || brand?.description || ''">
        <meta name="keywords" :content="brand?.metakeyword || ''">
    </Head>
    <AppLayout>
        <section>
            <div class="container position-relative product-filter-section" style="min-height:400px">
                <div class="d-flex">
                    <div class="links-wrapper" :class="{'links-wrapper--toggled' : isActive}">
                        <ul class="bg-white shadow h-100">
                            <li v-for="brand in  brands">
                                <Link :href="`/brand/${brand?.slug}`" class="links-item border-bottom d-flex align-items-center gap-2  fw-semibold">
                                    <img :src="brand?.image" alt="" style="width: 20px;height: 20px">
                                   {{brand.name}}
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div class="ps-lg-3 all-products pb-lg-5">
                        <div class="category-banner mb-5">
                            <p class="fs-2 fw-semibold">{{brand?.name}}</p>
                        </div>
                        <div class="d-flex justify-content-end pb-4 d-lg-none">
                            <button @click="isActive = !isActive">
                                <i class="bi fs-2" :class="isActive ? 'bi-x-lg' : 'bi-list'"></i>
                            </button>
                        </div>
                        <div class="row row-cols-2 row-cols-lg-4" v-if="products?.data?.length > 0">
                            <ProductCard class="px-2 mb-3" v-for="product in products?.data" :info="product" />
                        </div>
                        <div v-else>
                            <h3  class="text-secondary text-center pt-5 text-dark"> <span class="primary-color">{{ brand?.name }}</span> Product Not Found !</h3>
                        </div>
                        <Pagination v-if="products?.data?.length > 0" :links="products?.links" :from="products?.from" :to="products?.to"
                            :total="products?.total"/>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
