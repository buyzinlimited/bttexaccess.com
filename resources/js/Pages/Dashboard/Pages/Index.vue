<script setup>
import debounce from "lodash/debounce";
import {computed, onMounted, ref, watch} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from '@inertiajs/vue3'
import moment from "moment";

const props = defineProps({
    pages:[] | null,
    main_url:String | null,
    filters: Object,
});


const FRONTEND_URL = 'https://isoholdings.com'

const search = ref();
const perPage = ref();

watch([search, perPage], debounce(function ([val, val2]) {
    Inertia.get(props.main_url, { search: val, perPage: val2 }, { preserveState: true, replace: true });
}, 300));

computed(() => {
    $sToast.fire({
        icon: 'success',
        title: usePage().props.value.message
    })
});
</script>

<template>
    <Head title="Pages" />
    <AuthenticatedLayout>
        <div>
            <section class="app-user-list">
                <!-- list and filter start -->
                <div class="card rounded-0 px-0 p-3">
                    <div class="card-datatable table-responsive pt-0">
                        <div class="w-100 mb-3 px-3 d-flex align-items-center justify-content-between">
                            <input type="text" class="p-2 border border-secondary rounded w-100 w-lg-25" placeholder="Search Page..">
                            <Link href="/pages/create" class="d-flex align-items-center gap-2 button-primary">
                                <i class="bi bi-plus fs-3"></i>
                                <span>Add New page</span>
                            </Link>
                        </div>

                        <table class="page-list-table table">
                            <thead class="bg-black border-none">
                            <tr class="border-none">
                                <th class="sorting text-white">Id</th>
                                <th class="sorting text-white">title</th>
                                <th class="sorting text-white">Summery</th>
                                <th class="sorting text-white">Created At</th>
                                <th class="sorting text-white">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="page in pages" :key="page.id" @dblclick="copyToClipboard(page.slug)">
                                <td>#_{{ page.id }}</td>
                                <td>
                                    <a :href="`${FRONTEND_URL}/iso/${page.slug}`" target="_blank" class="fs-4 primary-color" >{{ page.title }}</a>
                                </td>
                                <td>
                                    ....
                                </td>
                                <td>
                                    {{ moment(page?.created_at).format('DD MMMM YYYY')}}
                                </td>
                                <td>
                                    <div class="actions d-flex gap-2">
                                        <a :href="`/pages/${page.id}/edit`" class="edit w-auto">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button class="delete w-auto" type="button" v-if="page.is_delete === 1"
                                                @click="deleteItem(props.main_url, page.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
