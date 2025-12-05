<template>
    <div class="counter">
        <button
            @click="store.decrementQty(props.productId)"
            :disabled="
                store.cart.find((item) => item.id === props.productId)
                    ?.quantity === 1
            "
            type="button"
            class="primary-bg rounded">
            <i class="bi bi-dash"></i>
        </button>
        <input
            type="number"
            :value="
                store.cart.find((item) => item.id === props.productId)?.quantity
            "
            :max="
                store.cart.find((item) => item.id === props.productId)?.quantity
            "
            :min="1"
            readonly
            class="bt-border rounded" />
        <button
            @click="store.incrementQty(props.productId)"
            :disabled="
                store.cart.find((item) => item.id === props.productId)
                    ?.quantity >= props.maxQty
            "
            type="button"
            class="primary-bg rounded">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>
</template>

<script setup>
    import { useCartStore } from '@/stores/useCartStore.js';

    const props = defineProps({
        productId: {
            type: Number,
            required: true,
        },
        maxQty: {
            type: Number,
            required: true,
        },
    });
    const store = useCartStore();
</script>

<style scoped>
    .counter {
        /* border: 1px solid black; */
        width: 120px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 30px;
        i {
            color: #fff;
        }
    }
    input {
        border: 0;
        height: 100%;
        width: 30px;
        height: 30px;
        text-align: center;
    }
</style>

<!--<script setup>-->
<!--    import { ref } from 'vue'-->

<!--    const emit = defineEmits(['update:modelValue'])-->
<!--    const decrement =  () => emit('update:modelValue', quantity.value&#45;&#45;)-->
<!--    const increment =  () => emit('update:modelValue', quantity.value++)-->

<!--    const props = defineProps({-->
<!--        modelValue:Number-->
<!--    })-->

<!--    const quantity = ref(props.modelValue)-->

<!--</script>-->

<!--<template>-->
<!--    <div class="quantity">-->
<!--        <button @click.prevent="decrement" :disabled="quantity <= 0">&mdash;</button>-->
<!--        <input type="text" :value="props.modelValue" readonly>-->
<!--        <button @click.prevent="increment">&#xff0b;</button>-->
<!--    </div>-->
<!--</template>-->

<!--<style lang="scss" scoped>-->
<!--    .quantity {-->
<!--        display: inline-flex;-->
<!--        align-items: center;-->
<!--        border: 1px solid black;-->
<!--        width: 150px;-->
<!--        button {-->
<!--            width: 33.33%;-->
<!--        }-->
<!--        input {-->
<!--            text-align: center;-->
<!--            width: 33.33%;-->
<!--            height: 44px;-->
<!--            border: none;-->
<!--            border-inline: 1px solid black;-->
<!--        }-->
<!--    }-->
<!--</style>-->
