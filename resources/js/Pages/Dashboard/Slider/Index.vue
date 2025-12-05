<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import {ref} from "vue";
import moment from 'moment';



const props = defineProps({
    sliders:Array,
    errors: Array,
})
const url = ref(null);
const newUrl = ref(null);



const form = useForm({
    url: null,
    sort: null,
    image:null
})
const onFileChange = (e) => {
    const file = e.target.files[0];
    form.image = file;
    newSlider.image = file;
    url.value = URL.createObjectURL(file);
    newUrl.value = URL.createObjectURL(file);
}

const addNewSlider = () => {
    document.getElementById('addSlider').$vb.modal.show()
}

function addSlider()
{
    router.post('/slider', {...form}, {
        onSuccess: () => {
            form.reset();
            url.value = null;
            document.getElementById('addSlider').$vb.modal.hide();
        }
    })
}


const newSlider = useForm({
    id: null,
    url: null,
    image:null,
});
const editSlider = (slider) => {
    document.getElementById('editSlider').$vb.modal.show()
    newSlider.id = slider.id,
    newSlider.url = slider.name,
    newSlider.image = slider.image,
    newUrl.value = slider.image
}

const updateSlider = (id) => {
    url.value = null;
    newUrl.value = null;
    router.post(`/update-brand/${id}`, newSlider);
    newSlider.reset();
    document.getElementById('editSlider').$vb.modal.hide()

}
</script>
<template>
    <Head title="Slider" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">
            <!-- list and filter start -->
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ sliders?.length}} Sliders</p>
                        <div class="d-flex align-items-center justify-content-end">
                            <button  class="button-primary" @click="addNewSlider">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Slider
                            </button>
                        </div>
                    </div>

                    <table class="page-list-table table p-0">
                        <thead class="bg-black border-none">
                        <tr class="border-none">
                            <th class="sorting text-white">Image</th>
                            <th class="sorting text-white">url</th>
                            <th class="sorting text-white">Order Number</th>
                            <th class="sorting text-white">Created At</th>
                            <th class="sorting text-white">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="slider in sliders" :key="slider?.id" >
                            <td>
                                <img :src="slider?.image" alt="" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ slider?.url }}
                                </Link>
                            </td>
                            <td>
                                {{ slider?.sort }} 
                            </td>
                            <td>
                                {{ moment(slider?.created_at).format('DD MMMM YYYY')}}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editSlider(slider)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/slider/${slider?.id}`" method="delete"  class="delete" preserve-scroll style="width:30px;height:30px;">
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
    </AuthenticatedLayout>

    <Modal id="addSlider" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add new Slider</h2>
                <form @submit.prevent="addSlider">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Slider Url"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="form.url"
                        />
                        <InputError :message="errors.url" />
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div>
                            <InputLabel
                                for="sort"
                                value="Slider Sort Number"
                                class="d-block mb-2"
                            />

                            <TextInput
                                class="bt-border-color w-25 p-2"
                                v-model="form.sort"
                            />
                            <InputError :message="errors.sort" />
                        </div>
                        <div>
                            <InputLabel
                                for="name"
                                value="Add Image"
                                class="d-block mb-2"
                            />
                            <div class="category-image">
                                <label for="category-image">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Upload Slider Image</span>
                                    <TextInput
                                        type="file"
                                        id="category-image"

                                        @change="onFileChange"
                                    />
                                </label>
                                
                            </div>
                            <InputError :message="errors.image" />
                        </div>
                    </div>
                    <div class="py-3">
                        <img v-if="url" :src="url" class="w-full h-auto">
                    </div>
                    
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Add Slider</PrimaryButton>
                </form>
            </div>
        </Modal>

        <Modal id="editSlider" v-vb-is:modal>
            <div class="category-add">
                <h2 class="mb-4">Update Slider</h2>
                <form @submit.prevent="updateSlider(newSlider.id)">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Brand Name"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newSlider.name"
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
                                    id="slider-image"

                                    @change="onFileChange"
                                />
                            </label>
                            <div class="category-image-preview">
                                <img v-if="newUrl" :src="newUrl" alt="">
                            </div>
                        </div>
                        <InputError :message="errors.image" />
                    </div>
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Submit Slider</PrimaryButton>
                </form>
            </div>
        </Modal>
</template>