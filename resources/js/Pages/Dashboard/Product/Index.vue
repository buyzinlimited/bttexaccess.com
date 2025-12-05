<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import moment from "moment";
import { ref, computed, watch } from "vue";

const props = defineProps({
    products: Array
});

const searchQuery = ref("");
const currentPage = ref(1);
const perPage = 50;

const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products;
    return props.products.filter(p =>
        (p.title && p.title.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
        (p.category?.name && p.category.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
        (p.brand?.name && p.brand.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
});

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    return filteredProducts.value.slice(start, start + perPage);
});

const totalPages = computed(() => Math.ceil(filteredProducts.value.length / perPage));

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

// ✅ Watch searchQuery and reset page to 1 when it changes
watch(searchQuery, () => {
    currentPage.value = 1;
});
</script>



<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ filteredProducts.length }} products</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- ✅ Search input -->
                            <input
                                type="text"
                                class="p-2 border border-secondary rounded w-100 w-lg-25"
                                placeholder="Search by name, category, or brand..."
                                v-model="searchQuery"
                            >
                            <Link href="/dashboard/add-product" class="button-primary">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Product
                            </Link>
                        </div>
                    </div>

                    <table class="page-list-table table p-0">
                        <thead class="bg-black border-none">
                        <tr class="border-none">
                            <th class="sorting text-white">Image</th>
                            <th class="sorting text-white">Name</th>
                            <th class="sorting text-white">Category</th>
                            <th class="sorting text-white">Brand</th>
                            <th class="sorting text-white">Created At</th>
                            <th class="sorting text-white">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in paginatedProducts" :key="product.id">
                            <td>
                                <img :src="product?.images[0]?.url" alt="" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ product?.title.substring(0, 20) }}
                                </Link>
                            </td>
                            <td>
                                {{ product?.category?.name }}
                            </td>
                            <td>
                                {{ product?.brand?.name }}
                            </td>
                            <td>
                                {{ moment(product?.created_at).format('DD MMMM YYYY') }}
                            </td>
                            <td>
                                <ul class="d-flex align-items-center justify-content-end gap-2 actions">
                                    <li>
                                        <Link :href="`/dashboard/edit-product/${product.slug}`" class="edit" methods="get">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="`/delete-product/${product.id}`" method="get" class="delete" preserve-scroll>
                                            <i class="bi bi-trash"></i>
                                        </Link>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- ✅ Pagination controls -->
                    <div class="p-3 bg-white d-flex align-items-center justify-content-between flex-wrap">
                        <p>
                            Showing {{ (currentPage - 1) * perPage + 1 }} -
                            {{ Math.min(currentPage * perPage, filteredProducts.length) }} of
                            {{ filteredProducts.length }} products
                        </p>
                        <div class="d-flex gap-1 flex-wrap">
                            <button class="btn btn-sm btn-secondary" @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">
                                « Prev
                            </button>
                            <button
                                v-for="page in totalPages"
                                :key="page"
                                class="btn btn-sm"
                                :class="page === currentPage ? 'btn-primary' : 'btn-outline-secondary'"
                                @click="goToPage(page)"
                            >
                                {{ page }}
                            </button>
                            <button class="btn btn-sm btn-secondary" @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">
                                Next »
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>


