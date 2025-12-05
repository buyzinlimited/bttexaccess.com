<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import { Autoplay } from "swiper/modules";
import HeaderSlider from "@/Components/HeaderSlider.vue";
import AdvertiseSlider from "@/Components/AdvertiseSlider.vue";
import BoxOne from "@/Components/BoxOne.vue";
import BoxTwo from "@/Components/BoxTwo.vue";
import { Vue3Marquee } from "vue3-marquee";
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

const modules = [Autoplay];
const props = defineProps({
  products: Array,
  navCats: Array,
  categories: Array,
  boxOneCats: Array,
  boxTwoCats: Array,
  boxOneBrands: Array,
  boxTwoBrands: Array,
  topSellingProducts: Array,
  featuredProducts: Array,
  brands: Array,
  clients: Array,
  bSettings: Array,
  boxOne: String,
  boxTwo: String,
  sliders: Array,
  advertises: Array,
});

import FeaturedProductSlider from "@/Components/FeaturedProductSlider.vue";
import TopSellingProductSlider from "@/Components/TopSellingProductSlider.vue";
import BrandsSlider from "./BrandsSlider.vue";
import ClientSlider from "./ClientSlider.vue";
</script>

<template>
  <Head title="B.T. TEX. ACCESS" />
  <AppLayout>
    <section>
      <div class="container">
        <div class="row">
          <div
            class="d-none d-lg-block"
            style="width: 290px; margin-right: 20px"
          >
            <div class="d-none d-lg-block">
              <ul class="header-links shadow header-height">
                <li v-for="category in navCats" :key="category.id">
                  <Link
                    :href="`/category/${category?.slug}`"
                    class="header-links-item border-bottom d-flex align-items-center gap-2 fs-5 fw-semibold"
                    preserve-scroll
                  >
                    <img
                      :src="category.image"
                      style="width: 20px; height: 20px"
                    />
                    {{ category.name }}

                    <div
                      class="dropDown shadow"
                      v-if="category?.sub_categories?.length > 0"
                    >
                      <ul class="dropDownItem">
                        <li v-for="item in category.sub_categories">
                          <Link
                            :href="`/category/${category?.slug}/${item?.slug}`"
                            method="get"
                            class="fs-5 header-links-item border-bottom d-flex align-items-center gap-2"
                            preserve-scroll
                          >
                            <img
                              :src="item.image"
                              style="width: 20px; height: 20px"
                            />
                            {{ item.name }}
                          </Link>
                        </li>
                      </ul>
                    </div>
                  </Link>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-lg-6 pe-lg-0 mb-3 mb-lg-0">
            <HeaderSlider :slides="sliders" />
          </div>
          <div class="col-12 col-lg-3 advertise-slider">
            <AdvertiseSlider :slides="advertises" />
          </div>
        </div>
      </div>
    </section>

    <section class="my-lg-2 py-5">
      <div class="container p-5">
        <div class="text-center pb-5">
          <div class="bt-title">
            <h2>Why Choose US</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 mb-3 mb-lg-0">
            <div class="icon-box">
              <div class="icon">
                <i class="bi bi-star-fill"></i>
              </div>
              <div>
                <h4>HIGHEST QUALITY</h4>
                <p>
                  Guaranteed Excellence We ensure 100% quality with products.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-3 mb-lg-0">
            <div class="icon-box">
              <div class="icon">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div>
                <h4>CUSTOMER SUPPORT</h4>
                <p>
                  Dedicated Service Team Our team is available from 9.30am to
                  7pm
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-3 mb-lg-0">
            <div class="icon-box">
              <div class="icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="32"
                  height="32"
                  viewBox="0 0 24 24"
                >
                  <g fill="none">
                    <path
                      d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"
                    />
                    <path
                      fill="currentColor"
                      d="M15 4a2 2 0 0 1 2 2v1h1.52a2 2 0 0 1 1.561.75l1.48 1.851a2 2 0 0 1 .439 1.25V15a2 2 0 0 1-2 2h-1a3 3 0 1 1-6 0h-3a3 3 0 1 1-6 0a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zM7 16a1 1 0 1 0 0 2a1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2a1 1 0 0 0 0-2m2.52-7H17v4h3v-2.15z"
                    />
                  </g>
                </svg>
              </div>
              <div>
                <h4>DELIVERY</h4>
                <p>
                  Fastest Delivery across Bangladesh Fast delivery within 2-48
                  hours
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mb-3 mb-lg-0">
            <div class="icon-box">
              <div class="icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="32"
                  height="32"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="M4 20v-2h2.75l-.4-.35q-1.3-1.15-1.825-2.625T4 12.05q0-2.775 1.662-4.938T10 4.25v2.1Q8.2 7 7.1 8.563T6 12.05q0 1.125.425 2.188T7.75 16.2l.25.25V14h2v6zm10-.25v-2.1q1.8-.65 2.9-2.212T18 11.95q0-1.125-.425-2.187T16.25 7.8L16 7.55V10h-2V4h6v2h-2.75l.4.35q1.225 1.225 1.788 2.663T20 11.95q0 2.775-1.662 4.938T14 19.75"
                  />
                </svg>
              </div>
              <div>
                <h4>EASY RETURN & REFUND</h4>
                <p>
                  Easy Retrun & Refund You Will Get a Return and Refund within 7
                  Days
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="category-section pt-0 py-5">
      <div class="container">
        <div class="text-center pb-5">
          <div class="bt-title">
            <h2>Categories</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>
        <div class="row row-cols-2 row-cols-lg-6">
          <div
            class="col mb-3"
            v-for="category in categories"
            :key="category?.id"
          >
            <Link
              :href="`/category/${category?.slug}`"
              class="category-section-card h-100 bg-white w-100 mx-2 overflow-hidden"
            >
              <div class="mb-2">
                <img :src="category?.image" :alt="category?.name" />
              </div>
              <div>
                <h3 class="text-center">
                  {{ category?.name }}
                </h3>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 index">
      <div class="container slider-image">
        <div class="text-center pb-2 mb-4">
          <div class="bt-title">
            <h2>Featured Products</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>

        <FeaturedProductSlider :slides="featuredProducts" />
      </div>
    </section>

    <section class="py-5 index">
      <div class="container slider-image">
        <div class="text-center pb-2 mb-4">
          <div class="bt-title">
            <h2>Top Selling Products</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>
        <TopSellingProductSlider :slides="topSellingProducts" />
      </div>
    </section>

    <BoxOne :name="boxOne" :categories="boxOneCats" :brands="boxOneBrands" />
    <BoxTwo :name="boxTwo" :categories="boxTwoCats" :brands="boxTwoBrands" />
    <section class="py-5">
      <div class="container index">
        <div class="text-center pb-2">
          <div class="bt-title">
            <h2>Our Brands</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>

        <!-- Brands -->
        <BrandsSlider :brands="brands" />
      </div>
    </section>
    <section class="py-5 index">
      <div class="container">
        <div class="text-center pb-2">
          <div class="bt-title">
            <h2>Our Clients</h2>
            <div
              class="d-flex align-items-center justify-content-center gap-2 mt-2"
            >
              <span style="background-color: red"></span>
              <span style="background-color: green"></span>
              <span style="background-color: yellow"></span>
            </div>
          </div>
        </div>
        <ClientSlider :clients="clients" />
      </div>
    </section>
    <section class="py-5">
      <div class="container editor_content">
        <div v-html="bSettings?.seo_content"></div>
      </div>
    </section>
  </AppLayout>
</template>
<style lang="scss" scoped>
@media (max-width: 1300px) {
  .advertise-slider {
    width: 100% !important;
  }
}

.swiper-slide {
  height: unset !important;
}

.product-item {
  flex: 1 1 20%; /* 5 items for desktop (100% / 5 = 20%) */
}

@media (max-width: 768px) {
  .product-item {
    flex: 1 1 50%; /* 2 items for mobile (100% / 2 = 50%) */
  }
}

.product-item {
  display: inline-block;
  padding: 10px;
}
</style>
