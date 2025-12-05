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
    <div
        ref="sliderContainer"
        class="slider-container d-100"
        style="display: flex">
        <!-- Main slider element -->
        <div
            ref="sliderSlide"
            class="slider-container-slide d-100"
            :style="{ width: 600 * slides.length + 'px' }">
            <a
                :href="slide?.url"
                    v-for="(slide, index) in [...slides, ...slides]"
                :key="index">
                <img :src="slide?.image" alt="Image" />
            </a>
        </div>
    </div>
</template>

<style scoped>
    .slider-container {
        overflow: hidden;
        width: 100%;
    }

    .slider-container-slide {
        display: flex;
        white-space: nowrap;
        animation: scroll-left 80s linear infinite;
    }

    .slider-container-slide img {
        min-width: 700px !important;
        height: 500px;
    }

    @media (max-width: 900px) {
        .slider-container-slide img {
            height: 300px;
        }
    }

    .slider-container:hover .slider-container-slide {
        animation-play-state: paused;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }
</style>

<!-- <p class="s-text">Image - {{ index + 1 }}</p> -->
<!-- 
<script setup>
    const props = defineProps({
        slides: Array,
    });
</script>
<template>
    <div class="slider-container">
        <div class="slider-container-slide">
            <img
                v-for="(slide, index) in slides"
                :key="index"
                :src="slide?.image"
                alt=""
                style="width: 100%; height: 100%" />
        </div>
    </div>
</template> -->

<!--
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/navigation';
    import { Navigation, Autoplay } from 'swiper/modules';
    const modules = [Navigation, Autoplay];
    <h1>Header Slider {{ slides.length }}</h1>
     <Swiper
        :navigation="true"
        :modules="modules"
        class="mySwiper"
        :loop="true"
        :speed="2500"
        :autoplay="{
            delay: 2000,
            disableOnInteraction: false,
        }">
        <SwiperSlide v-for="slide in slides" :key="slide?.id">
            <a class="d-block w-100 h-100 header-height" :href="slide?.url">
                <img :src="slide?.image" alt="" />
            </a>
        </SwiperSlide>
    </Swiper> -->
