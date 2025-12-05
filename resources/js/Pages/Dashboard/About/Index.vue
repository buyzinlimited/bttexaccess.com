<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from "@/Components/Editor.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    bSettings: Array,
});
const form = useForm({
    about_content: props.bSettings?.about_content ?? null,
});
let updateBusinessSetting = () =>{
    try{
        form.post('/save-setting');
        $toast.success('Settings Updated successfully');
    }catch(err){
        $toast.error('Something Went Wrong! Please try agin later');
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h2>Create About Content</h2>
            <button @click="updateBusinessSetting" class="button-primary">Save</button>
        </div>
        <div class="editor_content">
            <Editor v-model="form.about_content" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
