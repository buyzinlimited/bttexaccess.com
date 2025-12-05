<script setup>
import { ref, computed } from 'vue'
import { router, useForm, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Editor from '@/Components/Editor.vue';



const loading = ref(null);

const props = defineProps({
    categories: Array,
    brands: Array,
    errors: Array
})


const handleFileChange = (event) => {
    for (let i = 0; i < event.target.files.length; i++) {
        form.images.push({
            url: URL.createObjectURL(event.target.files[i]),
            file: event.target.files[i],
        });
    }

};

const removeMedia = (index) => {
    let removedImage = form.images[index];
    if (removedImage.url.startsWith('blob:')) {
        URL.revokeObjectURL(removedImage.url);
    }
    form.images.splice(index, 1);
};


const selectedCat = ref(null);

const form = useForm({
    title: null,
    short_description: null,
    description: null,
    spacification: null,
    category_id: computed(() => selectedCat.value?.id || null), 
    sub_category_id: null,
    brand_id: null,
    warranty: null,
    slug: null,
    metatitle: null,
    metakeyword: null,
    metadescription: null,
    images: [],
})

function addProduct()
{
    router.post('/store-product', {...form}, {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            form.reset;
        },
        onFinish: () => {
            loading.value = false;
        }
    });
}

const resetForm = () => {
    form.brand_id = null,
    form.title = null,
    form.short_description = null,
    form.description = null,
    form.category_id = null,
    form.spacification = null,
    form.warranty = null
    form.slug = null
    form.metatitle = null
    form.metakeyword = null
    form.metadescription = null
}
</script>


<template>
    <Head title="Add Product" />
    <AuthenticatedLayout>
        <div class="row product-create-tab">
            <div class="col-lg-3">
                <div class="nav flex-column nav-pills bg-white shadow" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-td-tab" data-bs-toggle="pill" data-bs-target="#v-pills-td" type="button" role="tab" aria-controls="v-pills-td" aria-selected="true">Title & Short Description</button>
                    <button class="nav-link" id="v-pills-bg-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bg" type="button" role="tab" aria-controls="v-pills-bg" aria-selected="false">Brand & Category</button>
                    <button class="nav-link" id="v-pills-image-tab" data-bs-toggle="pill" data-bs-target="#v-pills-image" type="button" role="tab" aria-controls="v-pills-image" aria-selected="false">Image</button>
                    <button class="nav-link" id="v-pills-description-tab" data-bs-toggle="pill" data-bs-target="#v-pills-description" type="button" role="tab" aria-controls="v-pills-description" aria-selected="false">Description</button>
                    <button class="nav-link" id="v-pills-spaci-tab" data-bs-toggle="pill" data-bs-target="#v-pills-spaci" type="button" role="tab" aria-controls="v-pills-spaci" aria-selected="false">Spacification</button>
                    <button class="nav-link" id="v-pills-warranty-tab" data-bs-toggle="pill" data-bs-target="#v-pills-warranty" type="button" role="tab" aria-controls="v-pills-warranty" aria-selected="false">Warranty</button>
                </div>

            </div>
            <div class="col-lg-9">
                <div class="bg-white shadow d-flex align-items-center justify-content-between gap-3 py-2 px-1 mb-3">
                    <div>
                        <p v-for="error in errors" class="text-danger">{{ error }}</p>
                    </div>
                    <div class=" d-flex align-items-center gap-2">
                        <button class="button-primary button-primary--outline" @click="resetForm">Cencel</button>
                        <button class="button-primary" @click="addProduct">
                            <div v-if="loading" class="spinner-border pinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span v-else>Save Product</span>
                        </button>
                    </div>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-td" role="tabpanel" aria-labelledby="v-pills-td-tab" tabindex="0">
                        <div class="p-4 bg-white shadow mb-4">
                            
                            <div class="mb-4">
                                <InputLabel value="Title"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    class="d-block w-100 p-2 bt-border-color" />


                            </div>
                            
                            <div class="editor_content">
                                <InputLabel
                                value="Add Product Short Description"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                                <Editor v-model="form.short_description" />
                            </div>
                            <div class="mb-4">
                                <InputLabel value="Meta Title"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                                <TextInput
                                    id="metatitle"
                                    v-model="form.metatitle"
                                    class="d-block w-100 p-2 bt-border-color" />


                            </div>
                            <div class="mb-4">
                                <InputLabel value="Meta Keyword"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                                <TextInput
                                    id="metatitle"
                                    v-model="form.metakeyword"
                                    class="d-block w-100 p-2 bt-border-color" />


                            </div>
                            <div class="editor_content">
                                <InputLabel
                                value="Add Product Meta Description"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                                <Editor v-model="form.metadescription" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-bg" role="tabpanel" aria-labelledby="v-pills-bg-tab" tabindex="0">
                        <div class="bg-white w-100 p-4 shadow">
                            <div class="w-50 mb-3">
                                <label class="mb-2">Select Category</label>
                                <v-select
                                    v-if="categories"
                                    label="name"
                                    :options="categories"
                                    v-model="selectedCat"
                                    :searchable="false"
                                    class="bt-border-color"
                                ></v-select>
                            </div>
                            <div class="w-50 mb-3" v-if="selectedCat">
                                <label class="mb-2">Select Sub Category</label>
                                <v-select
                                    label="name"
                                    :options="selectedCat.sub_categories"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    v-model="form.sub_category_id"
                                    class="bt-border-color "
                                ></v-select>
                            </div>
                            <div class="w-50">
                                <label class="mb-2">Select Brand</label>
                                <v-select
                                    v-if="brands"
                                    label="name"
                                    v-model="form.brand_id"
                                    :reduce="brand => brand.id"
                                    :options="brands"
                                    :searchable="false"
                                    class="bt-border-color"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-image" role="tabpanel" aria-labelledby="v-pills-image-tab" tabindex="0">
                        <div class="p-4 bg-white shadow mb-4">
                            <h4 class="pb-3">Image Upload Requirements</h4>
                            <ul style="list-style:disc;" class="ps-4 mb-4">
                                <li>1 MB limit.</li>
                                <li>300 * 200 Size</li>
                                <li>Allowed types: <span class="primary-color"> JPG</span>, <span class="primary-color">JPEG</span>, <span class="primary-color">PNG</span>.</li>
                            </ul>
                            <div class="file-upload-container">
                                <div class="file-upload-container-wrapper">
                                    <!--IMAGES PREVIEW-->
                                    <div v-for="(image, index) in form.images"   class="file-upload-container-wrapper__preview" :key="image.index">
                                        <img :src="image.url" class="file-upload-container-wrapper__preview-item">
                                        <button @click="removeMedia(index)"  class="file-upload-container-wrapper__preview-cancel" type="button">
                                            <svg viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="work-case" fill="currentColor" transform="translate(91.520000, 91.520000)"> <polygon id="Close" points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48"> </polygon> </g> </g> </g></svg>
                                        </button>
                                    </div>
                                    <!--UPLOAD BUTTON-->
                                    <div class="file-upload-container-wrapper__add">
                                        <label for="mu-file-input" class="file-upload-container__add-btn">
                                                    <span>
                                                        <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#D74825"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M736.68 435.86a173.773 173.773 0 0 1 172.042 172.038c0.578 44.907-18.093 87.822-48.461 119.698-32.761 34.387-76.991 51.744-123.581 52.343-68.202 0.876-68.284 106.718 0 105.841 152.654-1.964 275.918-125.229 277.883-277.883 1.964-152.664-128.188-275.956-277.883-277.879-68.284-0.878-68.202 104.965 0 105.842zM285.262 779.307A173.773 173.773 0 0 1 113.22 607.266c-0.577-44.909 18.09-87.823 48.461-119.705 32.759-34.386 76.988-51.737 123.58-52.337 68.2-0.877 68.284-106.721 0-105.842C132.605 331.344 9.341 454.607 7.379 607.266 5.417 759.929 135.565 883.225 285.262 885.148c68.284 0.876 68.2-104.965 0-105.841z" fill="#312782"></path><path d="M339.68 384.204a173.762 173.762 0 0 1 172.037-172.038c44.908-0.577 87.822 18.092 119.698 48.462 34.388 32.759 51.743 76.985 52.343 123.576 0.877 68.199 106.72 68.284 105.843 0-1.964-152.653-125.231-275.917-277.884-277.879-152.664-1.962-275.954 128.182-277.878 277.879-0.88 68.284 104.964 68.199 105.841 0z" fill="#D74825"></path><path d="M545.039 473.078c16.542 16.542 16.542 43.356 0 59.896l-122.89 122.895c-16.542 16.538-43.357 16.538-59.896 0-16.542-16.546-16.542-43.362 0-59.899l122.892-122.892c16.537-16.542 43.355-16.542 59.894 0z" fill="#312782"></path><path d="M485.17 473.078c16.537-16.539 43.354-16.539 59.892 0l122.896 122.896c16.538 16.533 16.538 43.354 0 59.896-16.541 16.538-43.361 16.538-59.898 0L485.17 532.979c-16.547-16.543-16.547-43.359 0-59.901z" fill="#312782"></path><path d="M514.045 634.097c23.972 0 43.402 19.433 43.402 43.399v178.086c0 23.968-19.432 43.398-43.402 43.398-23.964 0-43.396-19.432-43.396-43.398V677.496c0.001-23.968 19.433-43.399 43.396-43.399z" fill="#$secondary-color: var(--secondary-color, #D74825);"></path></g></svg>
                                                    </span>
                                        </label>
                                        <input @change="handleFileChange" id="mu-file-input" type="file" accept="image/*" multiple hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-description" role="tabpanel" aria-labelledby="v-pills-description-tab" tabindex="0">
                        <div class="p-4 bg-white shadow mb-4 editor_content">
                            <InputLabel
                                value="Full Description"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                            <Editor v-model="form.description" />
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-spaci" role="tabpanel" aria-labelledby="v-pills-spaci-tab" tabindex="0">
                        <div class="p-4 bg-white shadow mb-4 editor_content">
                            <InputLabel
                                value="Spacification"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                            <Editor v-model="form.spacification" />
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-warranty" role="tabpanel" aria-labelledby="v-pills-warranty-tab" tabindex="0">
                        <div class="p-4 bg-white shadow mb-4 editor_content">
                            <InputLabel
                                value="Warranty"
                                class="text-dark fw-medium mb-2 fs-4"
                                />
                            <Editor v-model="form.warranty" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
