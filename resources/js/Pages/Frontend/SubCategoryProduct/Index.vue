<script setup>
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {Head, Link} from "@inertiajs/vue3";
    import {ref} from 'vue'
    import ProductCard from "@/Components/ProductCard.vue";
    import Pagination from "@/Components/Pagination.vue";
    const props = defineProps({
        category:Object,
        products: Array,
        categories: Array,
    })


    const isActive = ref(false);
</script>

<template>
    <Head>
        <title>{{ category?.metatitle || category?.name }}</title>
        <meta name="description" :content="category?.metadescription || category?.description || ''">
        <meta name="keywords" :content="category?.metakeyword || ''">
    </Head>
    <AppLayout>
        <section>
            <div class="container position-relative product-filter-section" style="min-height:400px">
                <div class="d-flex">
                    
                    <div class="links-wrapper" :class="{'links-wrapper--toggled' : isActive}">
                        <ul class="bg-white shadow h-100">
                            <li v-for="category in  categories">
                                <Link :href="`/category/${category?.slug}`" class="links-item fs-5  fw-bold  py-2 px-2 border-bottom d-flex align-items-center gap-2">
                                    <img :src="category?.image" :alt="category.name" style="width: 20px;height: 20px">
                                    {{category.name}}
                                </Link>
                                <ul>
                                    <li v-for="item in category?.sub_categories">
                                        <Link  :href="`/category/${category?.slug}/${item?.slug}`" class="links-item fs-5 ps-4  py-2 px-2 border-bottom d-flex align-items-center gap-2">
                                          <img :src="item?.image" :alt="item.name" style="width: 20px;height: 20px">
                                            {{item?.name}}
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="ps-lg-3 all-products  pb-lg-5">
                        <div class="category-banner mb-5 pb-3">
                            <p class="fs-2 fw-bold">{{category?.name}}</p> 
                        </div>
                        <div class="d-flex justify-content-end pb-4 d-lg-none">
                            <button @click="isActive = !isActive">
                                <i class="bi fs-2" :class="isActive ? 'bi-x-lg' : 'bi-list'"></i>
                            </button>
                        </div>
                        <div class="row row-cols-2 row-cols-lg-4" v-if="products?.data?.length > 0">
                            <ProductCard class="px-2 mb-3" v-for="product in products?.data" :info="product" />
                        </div>
                        <h3 v-else class="text-secondary text-center pt-5 text-dark"> <span class="primary-color">{{ category?.name }}</span> Product Not Found !</h3>

                        <Pagination v-if="products?.data?.length > 0" :links="products.links" :from="products.from" :to="products.to"
                        :total="products.total"/>
                        <div class="category-banner mb-5">
                            <p v-html="category?.description" class="mt-2"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
