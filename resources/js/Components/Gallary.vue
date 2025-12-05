<script setup>
import { ref } from "vue";
import "@websitebeaver/vue-magnifier/styles.css";
import "vue-inner-image-zoom/lib/vue-inner-image-zoom.css";
import InnerImageZoom from "vue-inner-image-zoom";

import { Swiper, SwiperSlide } from "swiper/vue";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

const modules = [FreeMode, Navigation, Thumbs];
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};

defineProps({
  product: {
    type: Array,
    required: true,
  },
});
// const currentSlide = ref(0)
// const slideTo = (val)=> {
//     currentSlide.value = val
// }
</script>

<template>
  <div>
    <Swiper
      :style="{
        '--swiper-navigation-color': '#fff',
        '--swiper-pagination-color': '#fff',
      }"
      :loop="true"
      :spaceBetween="10"
      :navigation="true"
      :thumbs="{ swiper: thumbsSwiper }"
      :modules="modules"
      class="mySwiper2"
    >
      <SwiperSlide v-for="slide in product?.images">
        <InnerImageZoom
          :src="slide.url"
          :zoomSrc="slide.url"
          zoomType="hover"
          :zoomPreload="true"
          :alt="product?.alttag"
        />
      </SwiperSlide>
    </Swiper>
    <Swiper
      @swiper="setThumbsSwiper"
      :loop="true"
      :spaceBetween="10"
      :slidesPerView="4"
      :freeMode="true"
      :watchSlidesProgress="true"
      :modules="modules"
      class="swiper"
    >
      <SwiperSlide v-for="slide in product?.images">
        <img :src="slide.url" :alt="product?.title" />
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<style lang="scss" scoped>
#gallery .carousel__item {
  width: 100%;
  height: 400px;
  margin-inline: 20px;
}
#thumbnails .carousel__item {
  width: 100%;
  height: 100%;
  margin: 0 8px;
}

#thumbnails .carousel__item img {
  width: 100px;
  height: 100px;
  object-fit: contain;
  overflow: hidden;
}
#gallery .carousel__item img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
#thumbnails .carousel__track .carousel__item {
  border: 1px solid gray;
  border-right: none;
}
#thumbnails .carousel__track .carousel__item:last-child {
  border-right: 1px solid gray;
}

#thumbnails {
  padding: 0 !important;
}
</style>
