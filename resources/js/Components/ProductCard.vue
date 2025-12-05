<script setup>
import { Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const { info, width } = defineProps({
  info: { type: Object, required: false },
  width: { type: String, default: "100%" },
});

const cardText = ref(null);

const adjustTextareaHeight = () => {
  if (cardText.value) {
    cardText.value.style.height = "auto";
    cardText.value.style.height = `${cardText.value.scrollHeight}px`;
  }
};

onMounted(() => {
  adjustTextareaHeight();
});
</script>

<template>
  <div class="col px-0">
    <div
      class="product-card bt-border-dark d-flex flex-column justify-content-between rounded-0 h-100"
    >
      <Link :href="`/product/${info?.slug}`" class="product-card-top w-100">
        <!-- style="min-width: 300px; max-width: 400px" -->
        <img
          class="no-right-click"
          :src="info?.images[0]?.url"
          :alt="info?.title"
        />
      </Link>
      <div class="product-card-body p-0">
        <Link :href="`/product/${info?.slug}`" class="card-link">
          <textarea
            ref="cardText"
            style="line-height: 22px; font-size: 15px"
            readonly
            class="card-text bt-hover-primary"
            role="button"
            :style="{
              '--width': width,
            }"
            >{{ info?.title }}</textarea
          >
        </Link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-text {
  width: var(--width);
  max-width: 300px;
  border: none;
  outline: none;
  text-align: center;
  resize: none;
  height: 100%;
  overflow: hidden;
}
.card-link {
  width: 100%;
  display: block;
  margin-top: 10px;
}
.bt-border-dark {
  border: 0.5px solid #cdc9c9 !important;
}
</style>
