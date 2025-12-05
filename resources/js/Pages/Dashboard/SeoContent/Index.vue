<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from "@/Components/Editor.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
   bSettings: Array,
});
const form = useForm({
    seo_content: props.bSettings?.seo_content ?? null,
});

let updateBuisnessSetting = () =>{
    try{
        form.post('save-setting');
        $toast.success('Abount content Update successfully');
    }catch(err){
        $toast.error('Something Went Wrong! Please try again later');
    }
}
</script>
<template>
    <AuthenticatedLayout>
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h2>Home Page SEO Content</h2>
            <button @click="updateBuisnessSetting" class="button-primary">Save</button>
        </div>
        <div class="editor_content">
            <Editor v-model="form.seo_content" />
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>

</style>
