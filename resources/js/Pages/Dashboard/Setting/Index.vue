<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3'


const header_logo_url = ref(null);
const footer_logo_url = ref(null);
const fav_icon_url = ref(null);

const props = defineProps({
    products: Array,
    categories: Array,
    bSettings: Array,
    brands: Array,
    errors:Object,
    topItems: Array
});


const form = useForm({
    app_name: props.bSettings?.app_name ?? null,
    inquiry_mail: props.bSettings?.inquiry_mail ?? null,
    contact_mail: props.bSettings?.contact_mail ?? null,
    chat_script: props.bSettings?.chat_script ?? null,
    header_logo: props.bSettings?.header_logo ?? null,
    footer_logo: props.bSettings?.footer_logo ?? null,
    fav_icon: props.bSettings?.fav_icon ?? null,
    footer_text: props.bSettings?.footer_text ?? null,
    nav_cats: props.bSettings?.nav_cats ?? [],
    box1_cats: props.bSettings?.box1_cats ?? [],
    box2_cats: props.bSettings?.box2_cats ?? [],
    box1_brands: props.bSettings?.box1_brands ?? [],
    box2_brands: props.bSettings?.box2_brands ?? [],
    search_text: props.bSettings?.search_text ?? null,
    home_box_one: props.bSettings?.home_box_one ?? null,
    home_box_two: props.bSettings?.home_box_two ?? null,
    featured_products: props.bSettings?.featured_products ?? [],
    top_selling_products: props.bSettings?.top_selling_products ?? [],
    footer_help_number:props.bSettings?.footer_help_number ?? null,
    footer_number:props.bSettings?.footer_number ?? null,
    footer_email:props.bSettings?.footer_email ?? null,
    footer_whatsapp_number:props.bSettings?.footer_whatsapp_number ?? null,
    working_day:props.bSettings?.working_day ?? null,
    office_time:props.bSettings?.office_time ?? null,
    footer_address: props.bSettings?.footer_address ?? null,
    footer_working_text: props.bSettings?.footer_working_text ?? null,
    facebook_link:props.bSettings?.facebook_link ?? null,
    youtube_link:props.bSettings?.youtube_link ?? null,
    instagram_link:props.bSettings?.instagram_link ?? null,
    linkedin_link:props.bSettings?.linkedin_link ?? null,
    metatitle:props.bSettings?.metatitle ?? null,
    metakeyword:props.bSettings?.metakeyword ?? null,
    metadescription:props.bSettings?.metadescription ?? null,
});



const logoForm = useForm({
    header_logo :  null,
    footer_logo :  null,
    fav_icon :   null,
})

const headerLogo = (image) => {
    const file = image.target.files[0];
    logoForm.header_logo = file;
    header_logo_url.value = URL.createObjectURL(file);
}
const footerLogo = (image) => {
    const file = image.target.files[0];
    logoForm.footer_logo = file;
    footer_logo_url.value = URL.createObjectURL(file);
}
const favIcon = (image) => {
    const file = image.target.files[0];
    logoForm.fav_icon = file;
    fav_icon_url.value = URL.createObjectURL(file);
}

let updateBuisnessSetting = () =>{
    try{
        form.post('/save-setting');
        $toast.success('Settings Updated successfully');

    }catch(err){
        $toast.error('Something Went Wrong! Please try agin later');

    }
}

const updateLogo = () =>{
    logoForm.post('/save-logo-setting', {
        onSuccess: (res)=>{
            $toast.success("Business Settings Update Successfully Done");
            header_logo_url.value = null
            footer_logo_url.value = null
            fav_icon_url.value = null
        },
        onError: (res) =>{
            $toast.error('Something Went Wrong! Please try agin later');
            header_logo_url.value = null
            footer_logo_url.value = null
            fav_icon_url.value = null
        }
    });
}

// save top bar items
const topItem = useForm({
    icon:null,
    text:null,
});

const saveTopBarItems = () => {
    topItem.post('/save-top-bar-items', {
        onSuccess: ()=>{
            $toast.success("Top Bar Adedd Successfully");
            topItem.icon = null;
            topItem.text = null;
        },
    })
}

</script>

<template>
    <Head title="Settings" />
    <AuthenticatedLayout>
        <div class="settings pt-0 p-5">
            <div class="row align-items-start mt-5">
                <div class="col-lg-3 pe-0">
                    <div class="flex-column nav-pills bg-white list-group  rounded-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="list-group-item active border-0 d-flex align-items-center justify-content-between" id="v-pills-app-tab" data-bs-toggle="pill" data-bs-target="#v-pills-app" type="button" role="tab" aria-controls="v-pills-app" aria-selected="true">
                            App <i class="bi bi-chevron-right"></i>
                        </button>
                        <button class="list-group-item border-0 d-flex align-items-center justify-content-between" id="v-pills-apprience-tab" data-bs-toggle="pill" data-bs-target="#v-pills-apprience" type="button" role="tab" aria-controls="v-pills-apprience" aria-selected="true">
                            Media <i class="bi bi-chevron-right"></i>
                        </button>
                        <button class="list-group-item border-0 d-flex align-items-center justify-content-between" id="v-pills-category-tab" data-bs-toggle="pill" data-bs-target="#v-pills-category" type="button" role="tab" aria-controls="v-pills-category" aria-selected="false">
                            Category <i class="bi bi-chevron-right"></i>
                        </button>
                        <button class="list-group-item border-0 d-flex align-items-center justify-content-between" id="v-pills-brand-tab" data-bs-toggle="pill" data-bs-target="#v-pills-brand" type="button" role="tab" aria-controls="v-pills-category" aria-selected="false">
                            Brand <i class="bi bi-chevron-right"></i>
                        </button>
                        <button class="list-group-item border-0 d-flex align-items-center justify-content-between" id="v-pills-product-tab" data-bs-toggle="pill" data-bs-target="#v-pills-product" type="button" role="tab" aria-controls="v-pills-product" aria-selected="false">
                            Product <i class="bi bi-chevron-right"></i>
                        </button>
                        <button class="list-group-item border-0 d-flex align-items-center justify-content-between" id="v-pills-topbar-tab" data-bs-toggle="pill" data-bs-target="#v-pills-topbar" type="button" role="tab" aria-controls="v-pills-topbar" aria-selected="false">
                            Top Bar <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-9 ps-0">
                    <div class="tab-content bg-white p-3" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-app" role="tabpanel" aria-labelledby="v-pills-app-tab" tabindex="0">

                            <div>
                                <form class="form form-vertical" @submit.prevent="updateBuisnessSetting()">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h3>App Setting</h3>
                                        <button class="button-primary">Save Changes</button>
                                    </div>
                                    <div class="row">                                        
                                        <div class=" p-3 col-6">
                                            <label for="name" class="d-block mb-2 text-dark">App Name</label>
                                            <input id="name" v-model="form.app_name" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="mail" class="d-block mb-2 text-dark">Inquiry Receive Mail</label>
                                            <input id="mail" v-model="form.inquiry_mail" type="email" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="mail" class="d-block mb-2 text-dark">Contact Receive Mail</label>
                                            <input id="mail" v-model="form.contact_mail" type="email" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <div class="d-flex">
                                                <div class="w-100">
                                                    <label for="box-1" class="d-block mb-2 text-dark">Home Box 1</label>
                                                    <input id="box-1" v-model="form.home_box_one" type="text" class="bt-border p-2 rounded w-100">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="p-3 col-6">
                                            <div class="d-flex">
                                                <div class="w-100">
                                                    <label for="box-1" class="d-block mb-2 text-dark">Home Box 2</label>
                                                    <input id="box-1" v-model="form.home_box_two" type="text" class="bt-border p-2 rounded w-100">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="mail" class="d-block mb-2 text-dark">Search Box Text</label>
                                            <input v-model="form.search_text" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="mail" class="d-block mb-2 text-dark">Footer Help Number</label>
                                            <input id="mail" v-model="form.footer_help_number" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="box-1" class="d-block mb-2 text-dark">Footer Number</label>
                                            <input id="box-1" v-model="form.footer_number" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="box-2" class="d-block mb-2 text-dark">Footer Email</label>
                                            <input id="box-2" v-model="form.footer_email" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="box-2" class="d-block mb-2 text-dark">Footer Whatsapp Number</label>
                                            <input id="box-2" v-model="form.footer_whatsapp_number" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="box-1" class="d-block mb-2 text-dark">Working Day</label>
                                            <input id="box-1" v-model="form.working_day" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="box-2" class="d-block mb-2 text-dark">Office Time</label>
                                            <input id="box-2" v-model="form.office_time" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="box-2" class="d-block mb-2 text-dark">Facebook</label>
                                            <input id="box-2" v-model="form.facebook_link" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="box-2" class="d-block mb-2 text-dark">Youtube</label>
                                            <input id="box-2" v-model="form.youtube_link" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="box-2" class="d-block mb-2 text-dark">Instagram</label>
                                            <input id="box-2" v-model="form.instagram_link" type="text" class="bt-border p-2 rounded w-100">
                                        </div>

                                        <div class="p-3 col-12">
                                            <label for="box-2" class="d-block mb-2 text-dark">Linked in</label>
                                            <input id="box-2" v-model="form.linkedin_link" type="text" class="bt-border p-2 rounded w-100">
                                        </div>

                                        <div class="p-3 col-6">
                                            <label for="name"  class="d-block mb-2 text-dark">Footer Address</label>
                                            <textarea rows="5" v-model="form.footer_address" class="w-100 rounded bt-border p-2"></textarea>
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="name"  class="d-block mb-2 text-dark">Footer Working Our Text</label>
                                            <textarea rows="5" v-model="form.footer_working_text" class="w-100 rounded bt-border p-2"></textarea>
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="name"  class="d-block mb-2 text-dark">Chat Script</label>
                                            <textarea rows="5" v-model="form.chat_script" class="w-100 rounded bt-border p-2"></textarea>
                                        </div>
                                        <div class="p-3 col-6">
                                            <label for="name"  class="d-block mb-2 text-dark">Footer Text</label>
                                            <textarea rows="5" v-model="form.footer_text" class="w-100 rounded bt-border p-2"></textarea>
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="metatitle" class="d-block mb-2 text-dark">Meta Title</label>
                                            <input id="metatitle" v-model="form.metatitle" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="metakeyword" class="d-block mb-2 text-dark">Meta Keyword</label>
                                            <input id="metakeyword" v-model="form.metakeyword" type="text" class="bt-border p-2 rounded w-100">
                                        </div>
                                        <div class="p-3 col-12">
                                            <label for="metadescription"  class="d-block mb-2 text-dark">Meta Description</label>
                                            <input id="metadescription" v-model="form.metadescription" type="text" class="bt-border p-2 rounded w-100">                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                       <div class="tab-pane fade" id="v-pills-apprience" role="tabpanel" aria-labelledby="v-pills-apprience-tab" tabindex="0">

                            <div class="p-5">
                                <form class="form form-vertical" @submit.prevent="updateLogo">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                   <h3>Media Setting</h3>
                                  <button type="submit" class="button-primary">Save Changes</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="border p-2 rounded">
                                                <h4 class="fw-medium">Header Logo</h4>
                                                <div class="w-100  border border-dashed rounded bg-black" style="height: 10rem;">
                                                    <img class="w-100 h-100" v-if="header_logo_url !== null" :src="header_logo_url" alt="">
                                                    <img class="w-100 h-100" v-else :src="bSettings?.header_logo" alt="">
                                                </div>

                                                <label for="header-logo" class="button-primary py-1 px-2 mt-2 cursor-pointer" >
                                                    <input type="file" id="header-logo" @change="headerLogo" hidden>
                                                    Add File
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border p-2 rounded">
                                                <h4 class="fw-medium">Footer</h4>
                                                <div class="w-100  border border-dashed rounded bg-black" style="height: 10rem;">
                                                    <img class="w-100 h-100" v-if="footer_logo_url !== null" :src="footer_logo_url" alt="">
                                                    <img class="w-100 h-100" v-else :src="bSettings?.footer_logo" alt="">
                                                </div>

                                                <label for="footer-logo" class="button-primary py-1 px-2 mt-2 cursor-pointer" >
                                                    <input type="file" id="footer-logo" hidden @change="footerLogo" >
                                                    Add File
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border p-2 rounded">
                                                <h4 class="fw-medium">Favicon</h4>
                                                <div class="w-100  border border-dashed rounded bg-black" style="height: 10rem;">
                                                    <img class="w-100 h-100" v-if="fav_icon_url !== null" :src="fav_icon_url" alt="">
                                                    <img class="w-100 h-100" v-else :src="bSettings?.fav_icon" alt="">
                                                </div>

                                                <label for="fav-icon" class="button-primary py-1 px-2 mt-2 cursor-pointer" >
                                                    <input type="file" id="fav-icon" hidden @change="favIcon">
                                                    Add File
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

<!--                        Category Form -->
                        <div class="tab-pane fade" id="v-pills-category" role="tabpanel" aria-labelledby="v-pills-category-tab" tabindex="0">

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="mb-2 fw-bold">Category Setting</h3>
                                    <button type="submit" class="button-primary d-flex align-items-center gap-2"
                                    @click="updateBuisnessSetting"
                                    >
                                    Save Changes
                                    </button>
                                </div>

                                <h3 class="mb-2 fw-normal">Navigation Category</h3>
                                <div class="d-flex align-items-center justify-content-between mb-5 w-75">
                                    
                                    <v-select
                                        v-if="categories"
                                        label="name"
                                        class="bt-border rounded w-100"
                                        :options="categories"
                                        :reduce="item => item.id"
                                        :searchable="true"
                                        v-model="form.nav_cats"
                                        placeholder="Set Category"
                                        multiple
                                    >
                                        <template v-slot:option="option">
                                            <li class="d-flex align-items-start py-1">
                                                <div class="d-flex align-items-center justify-content-between w-100">
                                                    <div class="me-1 d-flex align-items-center gap-2">
                                                        <img :src="option?.image" alt="" width="50" height="50">
                                                        <h6 class="mb-25">{{ option?.name }}</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>

                                    </v-select>
                                </div>


                            <h3 class="mb-2 fw-normal">{{ bSettings?.home_box_one }}</h3>
                            <div class="d-flex align-items-center justify-content-between mb-5 w-75">
                                <v-select
                                    label="name"
                                    multiple=""
                                    class="rounded w-100 bt-border"
                                    :options="categories"
                                    v-model="form.box1_cats"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Set Category"
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.image" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.name }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>
                            </div>

                            <h3 class="mb-2 fw-normal">{{ bSettings?.home_box_two }}</h3>
                            <div class="d-flex align-items-center justify-content-between w-75">
                                <v-select
                                    label="name"
                                    multiple=""
                                    class="rounded w-100 bt-border"
                                    :options="categories"
                                    v-model="form.box2_cats"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Set Category"
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.image" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.name }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-brand" role="tabpanel" aria-labelledby="v-pills-brand-tab" tabindex="0">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="mb-2 fw-bold">Brand Setting</h3>
                                    <button type="submit" class="button-primary d-flex align-items-center gap-2"
                                    @click="updateBuisnessSetting"
                                    >
                                    Save Changes
                                    </button>
                                </div>

                            <h3 class="mb-2 fw-normal">{{ bSettings?.home_box_one}}</h3>
                            <div class="d-flex align-items-center justify-content-between mb-5 w-75">
                                <v-select
                                    label="name"
                                    multiple=""
                                    class="rounded w-100 bt-border"
                                    :options="brands"
                                    v-model="form.box1_brands"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Set Brand"
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.image" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.name }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>
                            </div>

                            <h3 class="mb-2 fw-normal">{{ bSettings?.home_box_two}}</h3>
                            <div class="d-flex align-items-center justify-content-between w-75">
                                <v-select
                                    label="name"
                                    multiple=""
                                    class="rounded w-100 bt-border"
                                    :options="brands"
                                    v-model="form.box2_brands"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Set Brand"
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.image" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.name }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>
                            </div>
                        </div>

<!--                        Product Form -->
                        <div class="tab-pane fade" id="v-pills-product" role="tabpanel" aria-labelledby="v-pills-product-tab" tabindex="0">
                            <form @submit.prevent="updateBuisnessSetting">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="mb-2 fw-normal">Featured Product</h3>
                                    <button  type="submit" class="button-primary d-flex align-items-center gap-2">
                                        <span>Save Setting</span>
                                    </button>
                                </div>
                                <v-select
                                    label="title"
                                    class="bt-border rounded"
                                    :options="products"
                                    v-model="form.featured_products"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Select Product"
                                    multiple
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.images[0].url" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.title }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>



                                <h3 class="mt-8 mb-2 fw-normal">Top Selling Products</h3>
                                <v-select
                                    label="title"
                                    class="bt-border rounded"
                                    :options="products"
                                    v-model="form.top_selling_products"
                                    :reduce="item => item.id"
                                    :searchable="true"
                                    placeholder="Select Product"
                                    multiple
                                >
                                    <template v-slot:option="option">
                                        <li class="d-flex align-items-start py-1">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="me-1 d-flex align-items-center gap-2">
                                                    <img :src="option.images[0].url" alt="" width="50" height="50">
                                                    <h6 class="mb-25">{{ option?.title }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </v-select>
                            </form>
                        </div>

                        <!-- top bar -->
                        <div class="tab-pane fade" id="v-pills-topbar" role="tabpanel" aria-labelledby="v-pills-topbar-tab" tabindex="0">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="mb-2 fw-bold">Top Bar Text</h3>
                            </div>
                            <div v-if="topItems?.length > 0">
                                <ul class="d-flex flex-column gap-3 py-5" >
                                    <li v-for="item in topItems" class="d-flex align-items-center justify-content-between gap-2 p-3 bg-white shadow">
                                        <div class="d-flex align-items-center gap-2">
                                            <span v-html="item?.icon"></span>
                                            <p style="text-transform:initial">{{ item?.text }}</p>
                                        </div>
                                        <div>
                                            <Link :href="`/delete-top-item/${item?.id}`" method="get" as="button" type="button">
                                                <i class="bi bi-trash"></i>
                                            </Link>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="width:40px; height:40px" class="border d-flex align-items-center justify-content-center rounded border-secondary" v-html="topItem.icon">

                                        </span>
                                        <div class="w-100">
                                            <input class="border p-2 rounded border-secondary w-100" type="text" placeholder="Inter Tex.." v-model="topItem.text">
                                        </div>
                                    </div>
                                    <p class="fs-5 text-danger pt-1" v-if="errors">{{errors?.text}}</p>

                                    <p class="py-2 pt-3 fs-5">Get Icon <a href="https://icons.getbootstrap.com/" class="primary-color">Click Here</a></p>

                                    <input class="w-100 p-2 rounded border border-secondary mt-2" type="text" placeholder="Paste Icon.." v-model="topItem.icon">
                                    <p class="fs-5 text-danger pt-1" v-if="errors">{{errors?.icon}}</p>
                                </div>
                                <button type="submit" class="button-primary d-flex align-items-center gap-2 justify-content-center"
                                @click="saveTopBarItems"
                                >
                                Save Item
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

