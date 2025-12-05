
<script setup>
import { defineProps, defineEmits, ref } from "vue";
import {onClickOutside} from '@vueuse/core'

const props = defineProps({
    isOpen: Boolean,
});
const emit = defineEmits(["modal-close"]);
const target = ref(null)
onClickOutside(target, ()=>emit('modal-close'))
</script>
<template>
    <div style="width: 1000px;height: 500px;" class="bg-primary d-flex align-items-center justify-content-center" v-if="isOpen" ref="target">
        <button class="button-primary"  @click.stop="emit('modal-close')">close</button>
    </div>
</template>



<!-- parent component code -->
<!-- const isModalOpened = ref(false);
const openModal = () => {
    isModalOpened.value = true;
};
const closeModal = () => {
    isModalOpened.value = false;
}; -->

<!-- <button @click="openModal" class="button-primary">open</button>
<Test :isOpen="isModalOpened" @modal-close="closeModal" /> -->
