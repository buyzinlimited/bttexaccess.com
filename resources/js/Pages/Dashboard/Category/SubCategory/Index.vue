<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head } from '@inertiajs/vue3'
import { useForm } from "@inertiajs/vue3"
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import moment from 'moment'
import Editor from '@/Components/Editor.vue';

const props = defineProps({
    categories:Array,
    subCategories:Array,
    errors:Array,
})

const iconImg = ref(null);
const iconEditImg = ref(null);
const loading = ref(false);
const parentIdError = ref(false);

const searchQuery = ref('')

const filteredSubCategories = computed(() => {
    if (!searchQuery.value) return props.subCategories
    return props.subCategories.filter(subCat =>
        (subCat.name && subCat.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
        (subCat.category && subCat.category.name && subCat.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
})

const form = useForm({
    name: null,
    image:null,
    slug:null,
    metatitle:null,
    metakeyword:null,
    metadescription:null,
    description:null,
    category_id:null,
})

const image = (image) => {
    const file = image.target.files[0];
    form.image = file;
    iconImg.value = URL.createObjectURL(file);
}




const addNewCategory = () => {
    document.getElementById('addCategory').$vb.modal.show()
}

const addCategory = () =>
{
    if(form.category_id == null) {
        parentIdError.value = "The Parent Category Field is Required.";
    }else {
        router.post('/sub-categories', {...form}, {
            onStart: () => {
                loading.value = true;
            },
            onSuccess: () => {
                form.reset()
                iconImg.value = null
                parentIdError.value = null;
                document.getElementById('addCategory').$vb.modal.hide();
            },
            onFinish: () => {
                loading.value = false;
            }
        })
    }
}

const editImage = (iconImage) => {
    const file = iconImage.target.files[0];
    newCategory.image = file;
    iconEditImg.value = URL.createObjectURL(file);
}

const newCategory = useForm({
    id: null,
    name: null,
    image:null,
    category_id:null,
    slug:null,
    metatitle:null,
    metakeyword:null,
    metadescription:null,
    description:null,
});
const editCategory = (category) => {
    document.getElementById('editCategory').$vb.modal.show()
    newCategory.id = category.id;
    newCategory.category_id = category.category_id;
    newCategory.name = category.name;
    newCategory.slug = category.slug;
    newCategory.metatitle = category.metatitle;
    newCategory.metakeyword = category.metakeyword;
    newCategory.metadescription = category.metadescription;
    newCategory.description = category.description;
    iconEditImg.value = category.image;
}

const updateCategory = (id) => {
    if(newCategory.parent_id === null){
        parentIdError.value = "The Parent Category Field is Required.";
    }else {
        router.post(`/update-sub-category/${id}`, {...newCategory}, {
            onStart: () => {
                loading.value = true;
            },
            onSuccess : () => {
                iconEditImg.value = null;
                newCategory.reset();
                document.getElementById('editCategory').$vb.modal.hide()
            },
            onFinish: () => {
                loading.value = false;
            }
        });
    }
}
</script>

<template>
    <Head title="Sub Categories" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">
            <!-- list and filter start -->
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ subCategories?.length}} Sub Categories</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <input
                                type="text"
                                class="p-2 border border-secondary rounded w-100 w-lg-25"
                                placeholder="Search Sub Category.."
                                v-model="searchQuery"
                            >
                            <button  class="button-primary" @click="addNewCategory">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Sub Category
                            </button>
                        </div>
                    </div>

                    <table class="page-list-table table p-0">
                        <thead class="bg-black border-none">
                        <tr class="border-none">
                            <th class="sorting text-white">Image</th>
                            <th class="sorting text-white">Name</th>
                            <th class="sorting text-white">Parent Category</th>
                            <th class="sorting text-white">Created At</th>
                            <th class="sorting text-white">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- 💥 LOOP OVER FILTERED RESULTS -->
                        <tr v-for="category in filteredSubCategories" :key="category.id">
                            <td>
                                <img :src="category?.image" alt="" width="80" />
                            </td>
                            <td>
                                {{ category?.name }}
                            </td>
                            <td>
                                {{ category?.category?.name }}
                            </td>
                            <td>
                                {{ moment(category?.created_at).format('DD MMMM YYYY') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editCategory(category)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/sub-categories/${category.id}`" method="delete" class="delete" preserve-scroll style="width:30px;height:30px;">
                                        <i class="bi bi-trash"></i>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="p-5 bg-white d-flex align-items-center justify-content-between">
                        <p>Showing {{ filteredSubCategories.length }} Sub Categories</p>
                    </div>
                </div>
            </div>
        </section>

        <Modal id="addCategory" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add new Category</h2>
                <form @submit.prevent="addCategory">
                    <div class="mb-3">
                        <InputLabel
                            for="Parent Category"
                            value="Parent Category"
                            class="d-block mb-2"
                        />

                        <v-select
                            label="name"
                            v-model="form.category_id"
                            :reduce="category => category.id"
                            :options="categories"
                            :searchable="false"
                            return-object
                            class="bt-border-color"
                        ></v-select>
                        <InputError v-if="parentIdError" :message="parentIdError" />

                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Category Name"
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

                                    @change="image"
                                />
                            </label>
                            <div class="category-image-preview">
                                <img v-if="iconImg" :src="iconImg" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="description"
                            value="Sub Category Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.description" />
                        <InputError :message="errors.description" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metatitle"
                            value="Sub Category Meta Title"
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
                            value="Sub Category Meta Keyword"
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
                            value="Sub Category Meta Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.metadescription" />
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">
                        <div v-if="loading" class="spinner-border pinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-else>Add Category</span>
                    </PrimaryButton>
                </form>
            </div>
        </Modal>
        <Modal id="editCategory" v-vb-is:modal>
            <div class="category-add">
                <h2 class="mb-4">Update Category</h2>
                <form @submit.prevent="updateCategory(newCategory.id)">
                    <div class="mb-3">

                        <InputLabel
                            for="Parent Category"
                            value="Parent Category"
                            class="d-block mb-2"
                        />

                        <v-select
                            label="name"
                            v-model="newCategory.category_id"
                            :reduce="category => category.id"
                            :options="categories"
                            :searchable="false"
                            return-object
                            class="bt-border-color"
                        ></v-select>

                        <InputError v-if="parentIdError" :message="parentIdError" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Category Name"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newCategory.name"

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
                            <label for="category-edit-image">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Upload Image</span>
                                <TextInput
                                    type="file"
                                    id="category-edit-image"
                                    @change="editImage"
                                />
                            </label>
                            <div class="category-image-preview">
                                <img v-if="iconEditImg" :src="iconEditImg" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="slug"
                            value="Sub Category URL"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newCategory.slug"
                        />
                        <InputError :message="errors.slug" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="description"
                            value="Sub Category Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.description" />
                        <InputError :message="errors.description" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metatitle"
                            value="Sub Category Meta Title"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newCategory.metatitle"
                        />
                        <InputError :message="errors.metatitle" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metakeyword"
                            value="Sub Category Meta Keyword"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newCategory.metakeyword"
                        />
                        <InputError :message="errors.metakeyword" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metadescription"
                            value="Sub Category Meta Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.metadescription" />
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">
                        <div v-if="loading" class="spinner-border pinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-else>Update Category</span>
                    </PrimaryButton>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>

    <Modal id="editCategory" v-vb-is:modal>
        <h3>Edit Category</h3>
    </Modal>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
