<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import {Head, useForm, router} from "@inertiajs/vue3";

const form = useForm({
   name: null,
   email: null,
   phone: null,
   message: null,
    company_name: null,
    company_detail: null
});

const sendMessage = () => {
    router.post('/contact-message', form, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            $toast.success('Message Sent Successfully');
    }
    });
}
</script>

<template>
    <Head title="Contact US" />
    <AppLayout>
        <section>
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div>
                            <div class="bt-title mb-4">
                                <h2>Contact Us</h2>
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <span style="background-color: red"></span>
                                    <span style="background-color: green"></span>
                                    <span style="background-color: yellow"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-3 mb-5 px-2">
                                    <div class="w-100 h-100 bg-white shadow p-3">
                                        <div class="text-center mb-2">
                                            <span class="d-inline-block bg-white p-3 rounded-5 shadow">
                                                <i class="bi bi-house-door"></i>
                                            </span>
                                        </div>
                                        <h3 class="text-center mb-2">Corporate Office</h3>
                                        <div class="d-flex gap-2">
                                            <i class="bi bi-geo-alt"></i>
                                            <address>Green Satmahal, House: 206-208, 4th Floor (402-403), Boro Moghbazar, Dhaka-1217, Bangladesh</address>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mb-5 px-2">
                                    <div class="w-100 h-100 bg-white shadow p-3">
                                        <div class="text-center mb-2">
                                            <span class="d-inline-block bg-white p-3 rounded-5 shadow">
                                                <i class="bi bi-headset"></i>
                                            </span>
                                        </div>
                                        <h3 class="text-center mb-2">Contact Details</h3>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +880 2222 228529
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +880 2483 15919
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-envelope"></i>
                                                aulad.btta@gmail.com
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-envelope"></i>
                                                bttexaccess@ymail.com
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mb-5 px-2">
                                    <div class="w-100 h-100 bg-white shadow p-3">
                                        <div class="text-center mb-2">
                                            <span class="d-inline-block bg-white p-3 rounded-5 shadow">
                                                <i class="bi bi-headset"></i>
                                            </span>
                                        </div>
                                        <h3 class="text-center mb-2">Sales Contact</h3>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-envelope"></i>
                                                aulad.btta@gmail.com
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +8801716 284115
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +8801613 722962
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mb-5 px-2">
                                    <div class="w-100 h-100 bg-white shadow p-3">
                                        <div class="text-center mb-2">
                                            <span class="d-inline-block bg-white p-3 rounded-5 shadow">
                                                <i class="bi bi-headset"></i>
                                            </span>
                                        </div>
                                        <h3 class="text-center mb-2">Service Contact</h3>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-envelope"></i>
                                                technical.btta@gmail.com
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +8801716 284115
                                            </a>
                                            <a href="" class="d-flex gap-2">
                                                <i class="bi bi-telephone"></i>
                                                +8801613 722960
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 p-4 bg-white shadow mb-5">
                        <form @submit.prevent="sendMessage">
                            <div class="form">
                                <div class="mb-3">
                                    <label for="name" class="form-label"> Name </label>
                                    <input type="text" class="form-control border p-2 w-100" id="name" placeholder="Inter Your Full Name... " v-model="form.name" required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="email" class="form-label"> Email </label>
                                        <input type="email" class="form-control border p-2 w-100" id="email" placeholder="Email Address" v-model="form.email" required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="number" class="form-label"> Mobile No</label>
                                        <input type="number" class="form-control border p-2 w-100" id="number" placeholder="Mobile No " v-model="form.phone" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="company" class="form-label"> Company Name</label>
                                    <input type="text" class="form-control border mb-5 p-2 w-100" id="company" placeholder="Company Name " v-model="form.company_name" required>
                                </div>
                                <div>
                                    <label for="companyDetails" class="form-label">Company Details (Optional)</label>

                                    <textarea id="companyDetails" name="companyDetails" rows="4"  class="form-control  border mb-5 w-100" v-model="form.company_detail"></textarea>
                                </div>
                                <div>
                                    <label for="message" class="form-label">Message </label>

                                    <textarea id="message" name="message" rows="4"  class="form-control  border mb-5 w-100" v-model="form.message" required></textarea>
                                </div>

                                <button type="submit" class="button-primary"> Send </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>

</template>
<style scoped>
.side-info{
    text-align: left;
    ul{
        text-style:none;
    }
    h1{
        color: #E50102;
        font-weight: 400;
    }
    h2{
        font-weight: 400;
        color: #E50102;
    }
    p{
        text-align: left;
        padding-left: 90px;
        line-height: 28px;
        i{
            padding-right: 10px;
        }
    }
}

</style>
