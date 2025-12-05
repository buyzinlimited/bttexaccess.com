<script setup>
    import { ref, onMounted, computed } from 'vue';
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import {  FreeMode, Navigation, Thumbs, Autoplay } from 'swiper/modules';

    // Import Swiper styles
    import 'swiper/css';
    import 'swiper/css/free-mode';
    import 'swiper/css/navigation';
    import 'swiper/css/thumbs';

    const modules = [Autoplay,FreeMode, Navigation, Thumbs];

    const props = defineProps({
        brands: {
            type: Array,
            required: true,
        }
    });

    const sliderContainer = ref(null);
    const sliderSlide = ref(null);

    // Calculate animation duration based on the number of brands
    const animationDuration = computed(() => {
        // Base duration for a single brand is 10 seconds, for example
        const baseDuration = 3;
        return baseDuration * props.brands.length + 's';
    });

    onMounted(() => {
        if (sliderSlide.value && sliderContainer.value) {
            const clonedSlide = sliderSlide.value.cloneNode(true);
            sliderContainer.value.appendChild(clonedSlide);
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
        }"
        :speed="3000"
        :loop="true"
        :allowTouchMove="true"
        :disableOnInteraction="true"
        :modules="modules"
        class="mySwiper"
    >
        <SwiperSlide 
        v-for="brand in brands"
                :key="brand.name">
        <div
                class="d-flex flex-column align-items-center justify-content-between h-100"
                >
                <div class="mb-2">
                    <img
                        :src="brand?.image"
                        :alt="brand?.name"
                        style="width: 170px; height: 50px" />
                </div>
                <h3 class="text-center fs-5 fw-normal">
                    {{ brand?.name }}
                </h3>
            </div>
        </SwiperSlide>
    </Swiper>

    <!-- <div ref="sliderContainer" class="slider-container w-100 d-flex mt-5">
        <div
            ref="sliderSlide"
            class="d-100 d-flex slider-container-slide"
            :style="{
                width: 170 * brands.length + 'px',
                animationDuration: animationDuration,
                '--start': reverse ? '-100%' : '0%',
                '--end': reverse ? '0%' : '-100%',
            }">
            <div
                v-for="brand in brands"
                :key="brand.name"
                class="d-flex flex-column align-items-center justify-content-between h-100"
                style="min-width: 300px">
                <div class="mb-2">
                    <img
                        :src="brand?.image"
                        :alt="brand?.name"
                        style="width: 170px; height: 50px" />
                </div>
                <h3 class="text-center fs-5 fw-normal">
                    {{ brand?.name }}
                </h3>
            </div>
        </div>
    </div> -->
</template>

<style scoped>
    .slider-container {
        overflow: hidden;
        width: 100%;
    }

    .slider-container-slide {
        display: flex;
        white-space: nowrap;
        animation: scroll-left linear infinite;
    }

    .slider-container:hover .slider-container-slide {
        animation-play-state: paused;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(var(--start));
        }
        100% {
            transform: translateX(var(--end));
        }
    }
</style>
