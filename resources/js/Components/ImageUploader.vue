<template>
    <label>{{ label }} </label>
    <div class="mb-1">
        <span class="">
            <input type="file" @input="updateValue" class="form-control border"  />
            <div class="avatar avatar-xl me-1" v-show="imgUrl">
                <img :src="imgUrl" alt="avatar">
            </div>
        </span>
        <span v-if="error" class="error">{{ error }}</span>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: [String, Object],
    label: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
})

let imgUrl = ref(null);

const emit = defineEmits(['update:modelValue'])

const updateValue = (event) => {
    emit('update:modelValue', event.target.files[0])
    imgUrl.value = URL.createObjectURL(event.target.files[0])
}

</script>
