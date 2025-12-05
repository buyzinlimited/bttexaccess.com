<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
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
    errors:Array,
})
const iconImg = ref(null);
const iconEditImage = ref(null);
const loading  = ref(null);


const form = useForm({
    name: null,
    image:null,
    slug:null,
    metatitle:null,
    metakeyword:null,
    metadescription:null,
    description:null,
})


const image = (image) => {
    const file = image.target.files[0];
    form.image = file;
    iconImg.value = URL.createObjectURL(file);
}


const editImage = (iconImage) => {
    const file = iconImage.target.files[0];
    newCategory.image = file;
    iconEditImage.value = URL.createObjectURL(file);
}

const addNewCategory = () => {
    document.getElementById('addCategory').$vb.modal.show()
}

const addCategory = () =>
{
    router.post('/categories', {...form}, {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            form.reset()
            iconImg.value = null;
            document.getElementById('addCategory').$vb.modal.hide()
        },
        onFinish: () => {
            loading.value = false;
        }
    })
}
const newCategory = useForm({
    id: null,
    name: null,
    image:null,
    slug:null,
    metatitle:null,
    metakeyword:null,
    metadescription:null,
    description:null,
});
const editCategory = (category) => {
    document.getElementById('editCategory').$vb.modal.show()
    newCategory.id = category.id;
    newCategory.name = category.name;
    newCategory.slug = category.slug;
    newCategory.metatitle = category.metatitle;
    newCategory.metakeyword = category.metakeyword;
    newCategory.metadescription = category.metadescription;
    newCategory.description = category.description;
    newCategory.image = category.image;
    iconEditImage.value = category.image;
}

const updateCategory = (id) => {
    router.post(`/update-category/${id}`, {...newCategory}, {
        onSuccess: () => {
            newCategory.reset();
            iconEditImage.value = null;
            document.getElementById('editCategory').$vb.modal.hide()
        }
    });
}

// 💥 ADD SEARCH FEATURE HERE
const searchQuery = ref('');

const filteredCategories = computed(() => {
    if (!searchQuery.value) return props.categories;
    return props.categories.filter(category =>
        category.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

</script>

<template>
    <Head title="Categories" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">
            <!-- list and filter start -->
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ categories?.length}} Categories</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <input
                                type="text"
                                class="p-2 border border-secondary rounded w-100 w-lg-25"
                                placeholder="Search Category.."
                                v-model="searchQuery"
                            >
                            <button  class="button-primary" @click="addNewCategory">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Category
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
                         <!-- 💥 Use filteredCategories here -->
                        <tr v-for="category in filteredCategories" :key="category.id">
                            <td>
                                <img :src="category?.image" alt="" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ category?.name }}
                                </Link>
                            </td>
                            <td>
                                {{ moment(category?.created_at).format('DD MMMM YYYY') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editCategory(category)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/categories/${category.id}`" method="delete" class="delete" preserve-scroll style="width:30px;height:30px;">
                                        <i class="bi bi-trash"></i>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
        <Modal id="addCategory" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add new Category</h2>
                <form @submit.prevent="addCategory">
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
                                <img v-if="iconImg" :src="iconImg">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="description"
                            value="Category Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.description" />
                        <InputError :message="errors.description" />
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
                            value="Category Meta Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.metadescription" />
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="loading">
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
                                <img v-if="iconEditImage" :src="iconEditImage" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="slug"
                            value="Category URL"
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
                            value="Category Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.description" />
                        <InputError :message="errors.description" />
                    </div>
                    <div class="mb-3">
                        <InputLabel
                            for="metatitle"
                            value="Category Meta Title"
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
                            value="Category Meta Keyword"
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
                            value="Category Meta Description"
                            class="d-block mb-2"
                        />

                        <Editor v-model="newCategory.metadescription" />
                        <InputError :message="errors.metadescription" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Update Category</PrimaryButton>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
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
