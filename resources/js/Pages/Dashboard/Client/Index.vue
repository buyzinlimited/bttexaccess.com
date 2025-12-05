<script setup>
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import {ref} from "vue";
import moment from "moment";



const props = defineProps({
    clients:Array,
    errors: Array,
})
const url = ref(null);
const newUrl = ref(null);



const form = useForm({
    name: null,
    image:null
})
const onFileChange = (e) => {
    const file = e.target.files[0];
    form.image = file;
    newClient.image = file;
    url.value = URL.createObjectURL(file);
    newUrl.value = URL.createObjectURL(file);
}

function addNewClient()
{
    document.getElementById('addClient').$vb.modal.show()
}

function addClient()
{
    router.post('/clients', {...form})
    form.reset()
    url.value = null
}

const newClient = useForm({
    id: null,
    name: null,
    image:null,
});
const editClient = (client) => {
    document.getElementById('editClient').$vb.modal.show()
    newClient.id = client.id,
        newClient.name = client.name,
        newClient.image = client.image,
        newUrl.value = cateclientgory.image
}

const updateClient = (id) => {
    url.value = null;
    newUrl.value = null;
    router.post(`/update-client/${id}`, newClient);
    newClinet.reset();
    document.getElementById('editClient').$vb.modal.hide()

}

</script>

<template>
    <Head title="Clients" />
    <AuthenticatedLayout>
        
        <section class="app-user-list mb-5">
            <!-- list and filter start -->
            <div class="card rounded-0">
                <div class="card-datatable table-responsive p-0">
                    <div class="p-3">
                        <p class="fs-5 mb-1">Total {{ clients?.length}} Clients</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <input type="text" class="p-2 border border-secondary rounded w-100 w-lg-25" placeholder="Search Category..">
                            <button  class="button-primary" @click="addNewClient">
                                <i class="bi bi-plus-lg fs-4"></i> Add New Client
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
                        <tr v-for="client in clients" :key="client.id" >
                            <td>
                                <img :src="client?.image" alt="" width="80" />
                            </td>
                            <td>
                                <Link href="/" class="text-dark">
                                    {{ client?.name }}
                                </Link>
                            </td>
                            <td>
                                {{ moment(category?.created_at).format('DD MMMM YYYY')}}
                            </td>
                            <td>
                                <div class="d-flex gap-2 actions">
                                    <button @click="editClient(client)" class="edit" style="width:30px;height:30px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <Link :href="`/brands/${client.id}`" method="delete"  class="delete" preserve-scroll style="width:30px;height:30px;">
                                        <i class="bi bi-trash"></i>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="p-5 bg-white d-flex align-items-center justify-content-between">
                        <p>Showing 10 Clients in 10000</p>
                    </div>
                </div>
            </div>
        </section>

        <Modal id="addClient" v-vb-is:modal>
            <div>
                <h2 class="mb-4">Add Client</h2>
                <form @submit.prevent="addClient">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Client Name"
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
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Add Client</PrimaryButton>
                </form>
            </div>
        </Modal>

        <Modal id="editClient" v-vb-is:modal>
            <div class="category-add">
                <h2 class="mb-4">Update Client</h2>
                <form @submit.prevent="updateClient(newClient.id)">
                    <div class="mb-3">
                        <InputLabel
                            for="name"
                            value="Client Name"
                            class="d-block mb-2"
                        />

                        <TextInput
                            class="bt-border-color w-100 p-2"
                            v-model="newClient.name"
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
                    <PrimaryButton type="submit" class="w-100"  :disabled="form.processing">Submit Client</PrimaryButton>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
