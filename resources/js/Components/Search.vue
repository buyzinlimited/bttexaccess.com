<script setup>
import {Link,router, useForm} from "@inertiajs/vue3";
import {watch, ref, onMounted, onBeforeUnmount} from "vue";
import useAxios from "@/composables/useAxios";
import {inject} from "vue";
const setting = inject('setting');

const {loading, error, sendRequest} = useAxios();

const isPreview = ref(false);
const handleClickOutside = (event) => {
    const searchPreview = document.querySelector('#search-preview');

    if (searchPreview && !searchPreview.contains(event.target)) {
        isPreview.value = true;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

const form = ref({
    query: null,
});
const products = ref(null);
const getAllProduct = async () => {
    const response = await sendRequest({
        method:'get',
        url:'/search',
        params: form.value,
    })
    if(response){
        products.value = response.data;
    }
}
const text = ref(true);
watch(
    () => form.value.query,
    (newVal) => {
      if (newVal?.length > 0) {
        isPreview.value = false;
        text.value = false;
      } else {
        isPreview.value = true;
        text.value = true;
      }
    }
);


const hoverProduct = ref(null)

const getProduct = (product) => {
    hoverProduct.value = product
}
const search = () => {
    router.get(`/products?name=${form.value.query}`)
}
watch(form, getAllProduct, {deep:true})
</script>

<template>
    <div class="search">
        <div class="d-flex align-items-center position-relative bg-white">
            <span v-if="text" class="text_1">{{ setting?.setting?.search_text }}</span>
            <input type="text"  v-model="form.query" @keydown.enter="search">
            <button @click="search" class="primary-bg rounded-0 text-white d-block" >Search</button>
        </div>

        <div class="search-preview shadow" :class="{'d-none' : isPreview}" id="search-preview" v-if="products?.length > 0">
            <div v-if="loading">
              <ul class="search-preview-list">
                <li v-for="product in 5" class="d-flex gap-1">
                    <div class="placeholder-glow">
                      <div class="placeholder placeholder rounded bg-secondary" style="width:70px;height:70px;"></div>
                    </div>
                    <div class="col-6 mt-2">
                      <h5 class="w-100  placeholder-glow">
                        <span class="placeholder d-block w-100 rounded bg-secondary"  style="height:20px"></span>
                      </h5>
                    </div>
                </li>
              </ul>
            </div>
            <div v-else class="d-flex">
                <div :class="{'col-lg-6' : hoverProduct?.length > 0}">
                    <ul class="search-preview-list">
                        <li v-for="product in products" :key="product.id">
                            <Link :href="`/product/${product?.slug}`" class="search-preview-list-item" @mouseover="getProduct(product)">
                                <div>
                                    <img :src="product.images[0].url" alt="">
                                </div>
                                <div>
                                    <h4>
                                        <Link  class="fw-normal" :href="`/product/${product?.slug}`">{{ product?.title}}</Link>
                                    </h4>
                                </div>
                            </Link>
                        </li>
                    </ul>
                </div>
                <div class="col-6" v-if="hoverProduct !== null">
                    <div class="search-preview-single p-3">
                        <Link to="" class="p-1 mb-2">
                            <img :src="hoverProduct?.images[0].url" alt="">
                        </Link>
                        <h3 class="mb-4">
                            <Link class="fw-normal" :href="`/product/${hoverProduct?.slug}`">{{  hoverProduct?.title}}</Link>
                        </h3>
                        <p class="editor_content" v-html="hoverProduct?.short_description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
