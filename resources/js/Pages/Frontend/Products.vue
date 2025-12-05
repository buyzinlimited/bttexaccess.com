<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";
import {Head, Link} from "@inertiajs/vue3";
import {onMounted, watch, ref} from "vue";
import Pagination from "@/Components/Pagination.vue";
import useAxios from "@/composables/useAxios";

const {loading, error, sendRequest} = useAxios();
const isActive = ref(false);

const props = defineProps({
    products: Array,
    categories: Array,
});

const query = ref({
    category_id: null,
    sub_category_id:null,
});


const getProduct = async() => {
    const response = await sendRequest({
        method:'get',
        url:'/get-all-products',
        data: query.value,
        params:{
            search: props?.search,
        },
    })
    if(response){
        products.value = response?.data;
        isActive.value=false;
    }
}

// watch(query, getProduct, {deep:true});

onMounted(async () => {
    // await getProduct();
});
</script>

<template>
    <Head title="All Product" />
    <AppLayout>
        <section>
            <div class="container product-filter-section">
                <div class="d-flex justify-content-between position-relative mx-0">
                    <div class="links-wrapper shadow p-0 bg-white" :class="{'links-wrapper--toggled' : isActive}">
                        <div>
                            <div class="mb-3">
                                <ul class=" h-100 bg-white shadow">
                                    <li v-for="category in categories" :key="category.id">

                                        <!-- <input
                                            type="radio"
                                            :id="`category-${category.id}`"
                                            :value="category.id"
                                            v-model="query.category_id"
                                            name="category"
                                            hidden
                                            >

                                        <label :for="`category-${category.id}`" class="links-item border-bottom d-flex items-center gap-1"> 
                                            

                                            <img :src="category.image" style="width:25px;height:25px;">
                                            {{ category.name }}</label>-->

                                            <Link href="/products" method="get" :data="{ category: category?.slug}" class="links-item border-bottom d-flex align-items-center gap-1  fw-bold">
                                                <img :src="category?.image" style="width:25px;height:25px;">
                                                {{ category?.name }}
                                            </Link>
                                            <ul>
                                                <li v-for="item in category?.sub_categories">
                                                <Link href="/products" method="get" :data="{ sub_category: item?.slug}" class="links-item border-bottom d-flex align-items-center gap-1 ps-4 fw-semibold  ">
                                                    <img :src="item?.image" style="width:18px;height:18px;">
                                                    {{ item?.name }}
                                                </Link>
                                                    
                                                </li>
                                            </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- <div class="mb-3">
                                <h3 class="mb-2">Brands</h3>
                                <ul class="d-flex flex-column links">
                                    <li class="brand">
                                        <input
                                            type="radio"
                                            id="all"
                                            value="all"
                                            name="brand"
                                            @click="query.brand_id = null"
                                            checked
                                            hidden>
                                        <label for="all" class="shadow links-item  border-bottom d-block w-100 rounded-0" >All</label>
                                    </li>
                                    <li v-for="brand in brands" :key="brand.id" class="brand">
                                        <input
                                            type="radio"
                                            :id="`brand-${brand.id}`"
                                            :value="brand.id"
                                            v-model="query.brand_id"
                                            name="brand"
                                            hidden >
                                        <label :for="`brand-${brand.id}`" class="links-item border-bottom d-block w-100 rounded-0">{{ brand.name }}</label>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    <div class="all-products">
                        <div class="text-end py-2">
                            <button @click="isActive = !isActive" class="d-lg-none z-3 primary-bg pt-1 px-1 rounded" style="top: 20px;right: 10px;">
                                <i class="bi bi-funnel text-white"></i>
                            </button>
                        </div>

                        <div v-if="loading" class="d-flex justify-content-center">
                            <div class="spinner-border primary-color" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        
                        <div v-else class="row row-cols-2 row-cols-lg-4 px-2" >
                            <ProductCard class="px-2 mb-3" v-for="product in products?.data" :info="product" :key="product?.id"/>
                        </div>
                        
                        <h3 v-if="products?.data?.length === 0" class="text-secondary text-center pt-5 text-dark">Product Not Found</h3>

                        <div class="py-4">
                            <Pagination v-if="products?.data?.length > 0" :links="products?.links" :from="products?.from" :to="products?.to"
                        :total="products?.total"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
