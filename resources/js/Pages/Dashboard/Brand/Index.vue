<script setup>
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { ref, computed, watch } from "vue";
import moment from "moment";
import Editor from '@/Components/Editor.vue';



const props = defineProps({
    brands:Array,
    errors: Array,
})
const url = ref(null);
const newUrl = ref(null);

// ✅ search state
const searchQuery = ref("");
const filteredBrands = computed(() => {
    if (!searchQuery.value) return props.brands;
    return props.brands.filter(brand =>
        brand.name && brand.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const form = useForm({
    name: null,
    image:null
})
const onFileChange = (e) => {
    const file = e.target.files[0];
    form.image = file;
    newBrand.image = file;
    url.value = URL.createObjectURL(file);
    newUrl.value = URL.createObjectURL(file);
}

const addNewBrand = () => {
    document.getElementById('addBrand').$vb.modal.show()
}

function addBrand()
{
    router.post('/brands', {...form})
    form.reset()
    url.value = null
}


const newBrand = useForm({
    id: null,
    name: null,
    image:null,
    slug:null,
    metatitle:null,
    metakeyword:null,
    metadescription:null,
});
const editBrand = (category) => {
    document.getElementById('editBrand').$vb.modal.show()
    newBrand.id = category.id,
    newBrand.name = category.name,
    newBrand.slug = category.slug,
    newBrand.metatitle = category.metatitle,
    newBrand.metakeyword = category.metakeyword,
    newBrand.metadescription = category.metadescription,
    newBrand.image = category.image,
    newUrl.value = category.image
}

const updateBrand = (id) => {
    url.value = null;
    newUrl.value = null;
    router.post(`/update-brand/${id}`, newBrand);
    newBrand.reset();
    document.getElementById('editBrand').$vb.modal.hide()

}
</script>

<template>
    <Head title="Brands" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">
            <!-- list and filter start -->
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ brands?.length}} Brands</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- ✅ search input -->
                            <input
                                type="text"
                                class="p-2 border border-secondary rounded w-100 w-lg-25"
                                placeholder="Search Brand..."
                                v-model="searchQuery"
                            >
                            <button  class="button-primary" @click="addNewBrand">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Brand
                            </button>
                        </div>
                    </div>

                    <table class="page-list-table table p-0">
                        <thead class="bg-black border-none">
                        <tr class="border-none">
                            <th class="sorting text-white">Image</th>
                            <th class="sorting text-white">Name</th>
                            <th class="sorting text-white">Created At</th>
                            <th class="sorting text-white">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="brand in filteredBrands" :key="brand.id">
                            <td>
                                <img :src="brand?.image" alt="" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ brand?.name }}
                                </Link>
                            </td>
                            <td>
                                {{ moment(brand?.created_at).format('DD MMMM YYYY') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editBrand(brand)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/brands/${brand.id}`" method="delete" class="delete" preserve-scroll style="width:30px;height:30px;">
                                        <i class="bi bi-trash"></i>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="p-5 bg-white d-flex align-items-center justify-content-between">
                        <p>Showing 10 Products in 10000</p>
                    </div>
                </div>
            </div>
        </section>

        <Modal id="addBrand" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add new Brand</h2>
                <form @submit.prevent="addBrand">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Brand Name"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="form.name"
                        />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="mb-4">
                        <InputLabel
                            for="name"
                            value="Add Image"
                            class="d-block mb-2"
                        />
                        <div class="category-image">
                            <label for="category-image">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                                <TextInput
                                    type="file"
                                    id="category-image"

                                    @change="onFileChange"
                                />
                            </label>
                            <div class="category-image-preview">
                                <img v-if="url" :src="url" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metatitle"
                            value="Brand Meta Title"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="form.metatitle"
                        />
                        <InputError :message="errors.metatitle" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metakeyword"
                            value="Brand Meta Keyword"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="form.metakeyword"
                        />
                        <InputError :message="errors.metakeyword" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metadescription"
                            value="Brand Meta Description"
                            class="d-block mb-2"
                        />
                        <Editor v-model="newBrand.metadescription" />
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Add Brand</PrimaryButton>
                </form>
            </div>
        </Modal>
        <Modal id="editBrand" v-vb-is:modal>
            <div class="category-add">
                <h2 class="mb-4">Update Brand</h2>
                <form @submit.prevent="updateBrand(newBrand.id)">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Brand Name"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newBrand.name"
                        />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="mb-4">
                        <InputLabel
                            for="name"
                            value="Add Image"
                            class="d-block mb-2"
                        />
                        <div class="category-image">
                            <label for="category-image">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                                <TextInput
                                    type="file"
                                    id="category-image"

                                    @change="onFileChange"
                                />
                            </label>
                            <div class="category-image-preview">
                                <img v-if="newUrl" :src="newUrl" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="slug"
                            value="Brand URL"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newBrand.slug"
                        />
                        <InputError :message="errors.slug" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metatitle"
                            value="Brand Meta Title"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newBrand.metatitle"
                        />
                        <InputError :message="errors.metatitle" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metakeyword"
                            value="Brand Meta Keyword"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newBrand.metakeyword"
                        />
                        <InputError :message="errors.metakeyword" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metadescription"
                            value="Brand Meta Description"
                            class="d-block mb-2"
                        />
                        <Editor v-model="newBrand.metadescription" />                        
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Submit Brand</PrimaryButton>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
