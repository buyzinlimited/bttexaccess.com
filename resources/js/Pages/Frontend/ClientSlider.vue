<script setup>
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import {  FreeMode, Navigation, Thumbs, Autoplay } from 'swiper/modules';

    // Import Swiper styles
    import 'swiper/css';
    import 'swiper/css/free-mode';
    import 'swiper/css/navigation';
    import 'swiper/css/thumbs';

    const modules = [Autoplay,FreeMode, Navigation, Thumbs];

    const props = defineProps({
        clients: {
            type: Array,
            required: true,
        }
    });
</script>

<template>
    <Swiper
    :breakpoints="{
            '300': {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            '768': {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            '1024': {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        }"
        :freeMode="true"
        :freeModeMomentum="false"
        :freeModeMomentumBounce="false"
        :grabCursor="true"
        :autoplay="{
            delay: 0,
            disableOnInteraction: true,
            reverseDirection: true,
        }"
        :speed="3000"
        :loop="true"
        :allowTouchMove="true"
        :disableOnInteraction="true"
        :modules="modules"
        class="mySwiper"
    >
        <SwiperSlide 
        v-for="client in clients">
        <div
                class="d-flex flex-column align-items-center justify-content-between h-100"
                >
                <div class="mb-2">
                    <img
                        :src="client?.image"
                        :alt="client?.name"
                        style="width: 170px; height: 50px" />
                </div>
                <h3 class="text-center fs-5 fw-normal">
                    {{ client?.name }}
                </h3>
            </div>
        </SwiperSlide>
    </Swiper>
</template>