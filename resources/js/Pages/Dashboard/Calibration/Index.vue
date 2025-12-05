<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from "@/Components/Editor.vue";
import {useForm} from "@inertiajs/vue3";
import toast from "bootstrap/js/src/toast.js";

const props = defineProps({
    bSettings : Array,
});
const form = useForm({
    calibration_content:props.bSettings?.calibration_content ?? null,
});
let UpdateBusinessSetting = () =>{
    try{
        form.post('/save-setting');
            $toast.success('Calibration Content is update successfully ');
    }catch (err){
        $toast.error('Something Went Wrong! Please try again later');
    }
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h2>Calibration Content</h2>
            <button @click="UpdateBusinessSetting" class="button-primary">Save</button>
        </div>
        <div class="editor_content">
            <Editor v-model="form.calibration_content" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
