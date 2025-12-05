<script setup>
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    slides: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="slider-container">
        <div class="slider-track">
            <div
                v-for="(slide, index) in [...slides, ...slides]"
                :key="index"
                class="slide-item">
                <ProductCard :info="slide" class="h-100" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.slider-container {
    overflow: hidden;
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
}

.slider-track {
    display: flex;
    flex-wrap: nowrap; /* Ensures all slides stay in one row */
    align-items: center;
    animation: scroll-left 30s linear infinite; /* Fixed duration */
}

.slide-item {
    flex: 0 0 300px; /* Ensures each slide has a fixed width */
    max-width: 300px;
    padding: 0 5px;
}

/* Pause animation on hover */
.slider-container:hover .slider-track {
    animation-play-state: paused;
}

/* Animation with fixed speed */
@keyframes scroll-left {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}
</style>
