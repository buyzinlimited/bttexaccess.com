<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useCartStore } from '@/stores/useCartStore.js';
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import useAxios from '@/composables/useAxios.js';

const {loading, error, sendRequest} = useAxios();

const cartStore = useCartStore();
cartStore.initCart();


const form = ref({
    name: null,
    phone: null,
    email: null,
    delivery_location: null,
    products: cartStore?.getCartItems
});


const sendMessage = async() => {
  const response = await sendRequest({
    method:'post',
    url:'/inquiry-message',
    data:form.value
  });
  if(response){
    $toast.success('Inquiry Message Send Successfully');
    resetForm();
  }
}
const resetForm = () => {
    form.name= '',
    form.phone= '',
    form.email= '',
    form.quantity= 1,
    form.delivery_location= ''
}
</script>

<template>
    <Head title="Send Inquiry" />
    <AppLayout>
        <section class="py-8">
            <div class="container px-0 px-lg-8">
                <h2 class="mb-4 text-uppercase">Products ({{ cartStore?.getCartItems?.length }})</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex gap-3 mb-3 bg-white shadow p-2 rounded" v-for="item in cartStore.getCartItems" :key="item.id">
                            <div>
                                <img :src="item?.images[0].url" style="min-width: 150px;height:120px" class="rounded">
                            </div>
                            <div>
                                <h3>{{ item?.title }}</h3>
                                <p>Quantity: {{item?.quantity}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-white shadow p-4">

                            <h2 class="mb-4 text-uppercase text-center">Send Inquiry</h2>
                            <div v-if="error" class="my-2 text-danger p-2 border border-danger rounded d-flex align-items-center justify-content-between">
                              <span>{{error?.message}}</span>
                              <i class="bi bi-exclamation-circle"></i>
                            </div>
                            <div>
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="text-dark mb-1">Name</label>
                                        <input
                                            type="text"
                                            class="p-2 bt-border rounded-1 w-100"
                                            v-model="form.name"
                                            required
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="text-dark mb-1">Phone</label>
                                        <input type="text"
                                               class="p-2  rounded w-100 bt-border"
                                               v-model="form.phone"
                                               required
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="text-dark mb-1">Email</label>
                                        <input type="email"
                                               class="p-2 rounded w-100 bt-border"
                                               v-model="form.email"
                                               required
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="text-dark mb-1">Delivery Location</label>
                                        <input type="text"
                                               class="p-2 rounded w-100 bt-border"
                                               v-model="form.delivery_location"
                                               required
                                        >
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start mt-4 gap-2">
                                        <button v-if="loading" class="btn primary-bg text-white" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                            <span role="status" class="test-white">Sending...</span>
                                        </button>
                                        <button v-else type="button" class="button-primary" @click="sendMessage">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
