<script setup>
    import { ref, onMounted } from 'vue';

    // Define props for accepting the slides array
    const props = defineProps({
        slides: {
            type: Array,
            required: true,
        },
    });

    const sliderContainer = ref(null);
    const sliderSlide = ref(null);

    onMounted(() => {
        if (sliderSlide.value && sliderContainer.value) {
            const clonedSlide = sliderSlide.value.cloneNode(true);
            sliderContainer.value.appendChild(clonedSlide);
        }
    });
</script>

<template>
    <div ref="sliderContainer" class="slider-container d-100">
        <!-- Main slider element -->
        <div
            ref="sliderSlide"
            class="slider-container-slide d-100"
            :style="{ '--length': 250 * slides.length + 'px' }">
            <a
                :href="slide?.url"
                class="mb-2"
                v-for="(slide, index) in [...slides, ...slides]"
                :key="index">
                <img
                    :src="slide?.image"
                    alt="Image"
                    style="width: 100%; height: 250px" />
    </a>
        </div>
    </div>
</template>

<style scoped>
    .slider-container {
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        max-height: 500px;
        overflow: hidden;
    }

    .slider-container-slide {
        display: flex;
        flex-direction: column;
        white-space: nowrap;
        animation: scroll-up 80s linear infinite;
        height: var(--length);
    }

    .slider-container-slide img {
        min-height: 250px;
        width: 100%;
    }

    @media (max-width: 1300px) {
        .slider-container-slide img {
            min-width: 300px !important;
        }
        .slider-container-slide {
            flex-direction: row;
            animation: scroll-left 80s linear infinite;
            height: auto;
            width: var(--length);
        }

        .slider-container {
            flex-direction: row;
        }
    }
    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    .slider-container:hover .slider-container-slide {
        animation-play-state: paused;
    }

    @keyframes scroll-up {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-100%);
        }
    }
</style>

<!-- <script setup>
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import { Autoplay } from 'swiper/modules';

    const modules = [Autoplay];

    const props = defineProps({
        slides: Array
    });
</script>

<template>
    <Swiper 
    :modules="modules" 
    :direction="'vertical'"
    :slidesPerView="2"
    :spaceBetween="10"
    :speed=2500
    :autoplay="{
        delay: 2000,
        disableOnInteraction: false,
        }"
    class="mySwiper header-height d-none d-lg-block"
    >
    <SwiperSlide v-for="slide in slides" :key="slide?.id">
        <a class="d-block w-100 h-100 " :href="slide?.url">
            <img :src="slide?.image" alt="">
        </a>
        </SwiperSlide>
    </Swiper>
    <Swiper 
    :modules="modules" 
    :slidesPerView="2"
    :spaceBetween="10"
    :speed=2500
    :autoplay="{
        delay: 2000,
        disableOnInteraction: false,
        reverseDirection: true,
    }"
    class="mySwiper d-lg-none"
    >
    <SwiperSlide v-for="slide in slides" :key="slide?.id">
        <a class="d-block w-100 h-100 " :href="slide?.url">
            <img :src="slide?.image" alt="">
        </a>
        </SwiperSlide>
    </Swiper>
</template>

<style scoped>
    .swiper {
        padding: 0 !important;
        img {
            width: 100%;
            height: 100% !important;
        }
    }
</style> -->
