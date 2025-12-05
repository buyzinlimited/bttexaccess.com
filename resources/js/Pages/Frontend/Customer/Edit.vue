<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head, Link} from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AppLayout>
        <template #header>
            <h2>Profile</h2>
        </template>


        <div class="row flex-column align-items-center py-5">
            <div class="col-lg-6">
                <Link href="/logout" method="post" class="button-primary d-flex align-items-center gap-2 mb-3 ms-auto" as="button">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log Out</span>
                </Link>
            </div>
            <div class="mb-4 col-lg-6">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />
            </div>

            <div class="mb-4 col-lg-6">
                <UpdatePasswordForm  />
            </div>

            <div class="mb-4  col-lg-6">
                <DeleteUserForm />
            </div>
        </div>
    </AppLayout>
</template>
