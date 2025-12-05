<script setup>
    import { ref, onMounted } from 'vue';
    import ProductCard from '@/Components/ProductCard.vue';
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
    <div ref="sliderContainer" class="slider-container d-100 d-flex">
        <div
            class="d-100 d-flex slider-container-slide"
            :style="{ width: 300 * slides.length + 'px' }">
            <div
                v-for="(slide, index) in slides"
                :key="index"
                class="px-1"
                style="width: 400px; max-width: 400px">
                <ProductCard :info="slide" class="h-100" />
            </div>
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
        animation: scroll-left 40s linear infinite;
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
