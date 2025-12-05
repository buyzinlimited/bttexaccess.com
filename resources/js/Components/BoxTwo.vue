<script setup>
import ProductCard from '@/Components/ProductCard.vue';
import { watch, ref , onMounted} from 'vue';
import { useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import useAxios from '@/composables/useAxios.js';

const {loading, error, sendRequest} = useAxios();

const isActive = ref(null);
const props = defineProps({
    categories:Array,
    brands:Array,
    name: String
});

const query = ref({
    category_id: null,
    brand_id: null,
})

const extractPage = (url) => {
    if (!url) return 1;

    const match = url.match(/page=(\d+)/);
    return match ? parseInt(match[1]) : 1;
};

const products = ref(null);
const getProduct = async(page) => {
    const response = await sendRequest({
        method:'get',
        url:`/get-box-two-products?page=${page}`,
        params: query.value
    })
    if(response){
        products.value = response.data;
        isActive.value = false;
    }
}

watch(query, getProduct, { deep: true });
onMounted(async () => {
    await getProduct();
});
</script>
<template>
    <section class="home-box home-box--two mb-8">
        <div class="container">
            <div class="home-box__inner">
                <div class="home-box__inner__top-bar bg-secondary">
                    <div class="home-box__inner__top-bar__title">
                        <h3>{{name}}</h3>
                        <button class="d-lg-none" @click="isActive = !isActive">
                            <i class="bi bi-list fs-3 text-white"></i>
                        </button>
                    </div>
                    <div class="home-box__inner__top-bar__brands">
                        <ul class="box-two">
                            <li>
                                <input
                                    type="radio"
                                    id="box-2-all"
                                    name="brand"
                                    :value="null"
                                    v-model="query.brand_id"
                                    checked
                                    hidden>
                                <label for="box-2-all" class="shadow" >All</label>
                            </li>
                            <li v-for="brand in brands" :key="brand.id">
                                <input
                                    type="radio"
                                    :id="`box-2-brand-${brand.id}`"
                                    :value="brand.id"
                                    v-model="query.brand_id"
                                    name="brand"
                                    hidden>
                                <label :for="`box-2-brand-${brand.id}`">{{ brand.name }}</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="home-box__inner__main-content home-box__inner__main-content--box-one">
                    <div class="home-box__inner__main-content__side-bar" :class="{'home-box__inner__main-content__side-bar--active' : isActive}">
                        <ul class="box-two-cats">
                            <li v-for="category in categories" :key="category.id"
                             @click="query.brand_id = null"
                            >
                                <input
                                    type="radio"
                                    :id="`box-2-category-${category.id}`"
                                    :value="category.id"
                                    v-model="query.category_id"
                                    name="category"
                                    hidden>
                                <label :for="`box-2-category-${category.id}`">
                                    <img :src="category?.image" >
                                    {{ category?.name }}
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="home-box__inner__main-content__products p-3">
                        <div v-if="loading" class="loading">
                            <div class="spinner-border primary-color" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div v-if="products?.data?.length !== 0" class="row row-cols-2 row-cols-lg-4">
                            <ProductCard class="px-2 mb-3"  v-for="product in products?.data" :info="product" :key="product.id"/>
                        </div>
                        <div v-else>
                            <h3 class="text-center fs-2">Product Not Found!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center py-5">
            <div class="pagination">
                <div class="pagination__right">
                    <ul class="pagination__right__list">
                        <li
                            class="pagination__right__list__item"
                            v-for="link in products?.links"
                            :class="{ 'pagination__right__list__item--active' : link.active }"
                        >
                            <button 
                                @click="getProduct(extractPage(link.url))" 
                                class="pagination__right__list__item__link" 
                                v-html="link.label">
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section> 
</template>