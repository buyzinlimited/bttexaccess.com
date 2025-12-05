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
    advertises:Array,
    errors: Object,
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
    url.value = URL.createObjectURL(file);
}

const addNewAdvertise = () => {
    document.getElementById('addAdvertise').$vb.modal.show()
}

function addAdvertise()
{
    router.post('/advertise', {...form}, {
        onSuccess: () => {
            form.reset();
            url.value = null;
            document.getElementById('addAdvertise').$vb.modal.hide();
        }
    });
}


const newAdvertise = useForm({
    id: null,
    url: null,
    sort: null,
    image:null,
});

const updateFile = (image) => {
    const file = image.target.files[0];
    newAdvertise.image = file;
    newUrl.value = URL.createObjectURL(file);
}

const editAdvertise = (advertise) => {
    document.getElementById('editAdvertise').$vb.modal.show()
    newAdvertise.id = advertise.id,
    newAdvertise.url = advertise.url,
    newAdvertise.sort = advertise.sort,
    newUrl.value = advertise.image
}


const updateAdvertise = (id) => {
    router.post(`/update-advertise/${id}`, newAdvertise);
    newAdvertise.reset();
    document.getElementById('editAdvertise').$vb.modal.hide()
    newUrl.value = null;
}

</script>
<template>
    <Head title="Advertise" />
    <AuthenticatedLayout>
        <section class="app-user-list mb-5">   
            
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ advertises?.length}} Advertises</p>
                        <div class="d-flex align-items-center justify-content-end">
                            <button  class="button-primary" @click="addNewAdvertise">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Advertise
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
                        <tr v-for="advertise in advertises" :key="slider?.id" >
                            <td>
                                <img :src="advertise?.image" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ advertise?.url }}
                                </Link>
                            </td>
                            <td>
                                {{ advertise?.sort}}
                            </td>
                            <td>
                                {{ moment(advertise?.created_at).format('DD MMMM YYYY')}}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editAdvertise(advertise)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/advertise/${advertise?.id}`" method="delete"  class="delete" preserve-scroll style="width:30px;height:30px;">
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

        <Modal id="addAdvertise" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add new Advertise</h2>
                <form @submit.prevent="addAdvertise">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Advertise Url"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="form.url"
                        />
                        <InputError :message="errors?.url" />
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div>
                            <InputLabel
                                for="sort"
                                value="Advertise Sort Number"
                                class="d-block mb-2"
                            />

                            <TextInput
                                class="bt-border-color w-25 p-2"
                                v-model="form.sort"
                            />
                            <InputError :message="errors?.sort" />
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
                                    <span>Upload Advertise Image</span>
                                    <TextInput
                                        type="file"
                                        id="category-image"
                                        @change="onFileChange"
                                    />
                                </label>
                                
                            </div>
                            <InputError :message="errors?.image" />
                        </div>
                    </div>
                    <div class="py-3">
                        <img v-if="url" :src="url" class="w-full h-auto">
                    </div>
                    
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Add Advertise</PrimaryButton>
                </form>
            </div>
        </Modal>

        <Modal id="editAdvertise" v-vb-is:modal>
            <div class="category-add">
                <h2 class="mb-4">Update Advertise</h2>
                
                <form @submit.prevent="updateAdvertise(newAdvertise?.id)">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Advertise Url"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newAdvertise.url"
                        />
                        <InputError :message="errors?.url" />
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div>
                            <InputLabel
                                for="sort"
                                value="Advertise Sort Number"
                                class="d-block mb-2"
                            />

                            <TextInput
                                class="bt-border-color w-25 p-2"
                                v-model="newAdvertise.sort"
                            />
                            <InputError :message="errors?.sort" />
                        </div>
                        <div>
                            <InputLabel
                                for="name"
                                value="Update Image"
                                class="d-block mb-2"
                            />
                            <div class="category-image">
                                <label for="update-addvertise-image">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Upload Advertise Image</span>
                                    <TextInput
                                        type="file"
                                        id="update-addvertise-image"

                                        @change="updateFile"
                                    />
                                </label>
                                
                            </div>
                            <InputError :message="errors?.image" />
                        </div>
                    </div>
                    <div class="py-3">
                        <img v-if="newUrl" :src="newUrl" class="w-full h-auto">
                    </div>
                    
                    <PrimaryButton type="submit" class="w-100">Update Advertise</PrimaryButton>
                </form>
            </div>
        </Modal> 
        
</template>