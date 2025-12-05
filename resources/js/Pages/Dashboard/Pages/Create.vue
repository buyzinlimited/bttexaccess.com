
<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref, watchEffect} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from '@/Components/Editor.vue';
import {useSlug} from "@/composables/useSlug.js";
import { Link } from '@inertiajs/vue3'


const {makeSlug} = useSlug();


const props = defineProps({
    main_url: String|null,
});
const fullPageSpecification = ref(false)

let createForm = useForm({
    title: null,
    slug:null,
    summery:null,
});

const isLoading = ref(false);
const addPage = () => {
    createForm.post(props.main_url,{
        preserveState: true,
        replace: true,
        onStart: res =>{
            isLoading.value = true;
        },
        onSuccess: page => {
            isLoading.value = false;
            createForm.reset();
            $sToast.fire({
                icon: 'success',
                title: "Page Save Successfully Done...."
            })
        },
        onError: errors => {
            isLoading.value = false;
            $toast.error("Validation Errors...")
        }
    });
}
watchEffect(() => {
    createForm.slug = makeSlug(createForm.title)
})



</script>


<template>
    <AuthenticatedLayout>
        <div class="content-header row mb-1">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h2 class="float-start mb-0">Create Page</h2>
                <a href="/pages" class="d-flex align-items-center gap-2 button-primary">
                    <i class="bi bi-chevron-left"></i>
                    <span>Go To Back</span>
                </a>
            </div>
        </div>
        <section class="app-user-list">
            <div class="mt-5">
                <div class="row match-height">
                    <div class="bg-white col-lg-9 editor_content">
                        <Editor v-model="createForm.summery" :isMultiline="fullPageSpecification" :height=" fullPageSpecification ? '600px' : '400px'"/>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body p-2">
                                <h2 class="card-title">Page Title & Slug</h2>
                                <div class="form-group mt-1">
                                    <label>Title</label> <info title="Page Title"/>
                                    <input v-model="createForm.title" class="form-control" type="text" placeholder="e.g This is page title">
                                </div>
                                <div class="form-group mt-1">
                                    <label>slug</label> <info title="Url Slug Convert To Title"/>
                                    <input class="form-control" disabled type="text" v-model="createForm.slug" placeholder="e.g Title-convert-to-slug">
                                </div>
                            </div>
                            <div class="card">
                            <div class="card-body p-2">
                                <div class="row gap-2">
                                    <div class="col-12">
                                        <div class="card bg-light-success cursor-pointer" @click="addPage">
                                            <div class="card-body d-flex align-items-center justify-content-center py-2">
                                                <span class="text-success">Save Page</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <Link href="/pages"  class="card bg-light-danger cursor-pointer">
                                            <div class="card-body d-flex align-items-center justify-content-center py-2">
                                                <span class="text-danger">Cancel Request</span>
                                            </div>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
