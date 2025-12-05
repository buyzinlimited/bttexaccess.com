<script setup>
import { useForm, router, Head, Link } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Gallary from "@/Components/Gallary.vue";

import { useCartStore } from "@/stores/useCartStore.js";
const store = useCartStore();

import { SWhatsApp } from "vue-socials";
import { SFacebook } from "vue-socials";
import { STwitter } from "vue-socials";
import { SLinkedIn } from "vue-socials";

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import RelatedProductSlider from "@/Components/RelatedProductSlider.vue";
import SeoHead from "@/Components/SeoHead.vue";

const props = defineProps({
  product: Object,
  errors: Array,
  ProductAverageRating: Number,
  relatedProducts: Array,
});

const windowFeatures = {};
const shareOptions = {
  url: `https://bttexaccess.com/product/${props.product.slug}`,
  text: `https://bttexaccess.com/product/${props.product.slug}`,
  image: `https://bttexaccess.com${props.product.images[0]}`,
};
const useNativeBehavior = false;

const onClose = () => {};
const onOpen = () => {};
const onBlock = () => {};
const onFocus = () => {};

const createQuestion = useForm({
  question: null,
  product_id: props.product.id,
});

const textarea = ref(false);
const active = () => (textarea.value = true);

const addQuestion = () => {
  router.post("/questions", createQuestion, { preserveScroll: true });
  createQuestion.reset();
};

const ansArea = ref(false);
const replay = () => (ansArea.value = true);
const createAnswer = useForm({
  answer: null,
});

const addAnswer = (id) => {
  router.post(`/create-answer/${id}`, createAnswer, {
    preserveScroll: true,
  });
  ansArea.value = false;
};

const reviewArea = ref(false);
const activeReview = () => (reviewArea.value = true);

const createReview = useForm({
  rating: null,
  review: null,
  product_id: props.product.id,
});

const addReview = () => {
  router.post("/reviews", createReview, { preserveScroll: true });
  createReview.reset();
  reviewArea.value = false;
};

const initCart = ref(1);
const increment = () => (initCart.value = initCart.value + 1);
const decrement = () => {
  if (initCart.value > 1) {
    initCart.value = initCart.value - 1;
  }
};
const addToCart = (product) => {
  let sellPrice = product?.discount > 0 ? product?.discount : product?.price;
  store.addToCart({
    ...product,
    quantity: initCart.value,
    sellPrice: sellPrice,
  });
  $toast.success("Added to cart successful.");
};
const isInCart = computed(() => {
  return store.cart.find((item) => item.id === props.product?.id)?.quantity;
});
</script>

<template>
  <SeoHead :product="product" />

  <AppLayout>
    <div class="container py-lg-8">
      <div class="row">
        <div class="col-lg-4 col-12">
          <Gallary :product="product" />
        </div>
        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
          <div class="shadow h-100 p-3">
            <h3 class="mb-1">{{ product?.title }}</h3>
            <p class="mb-2">
              Brand:
              <Link
                class="primary-color"
                :href="`/brand/${product?.brand?.slug}`"
                >{{ product?.brand?.name }}</Link
              >
            </p>
            <div
              class="mb-4 editor_content"
              v-html="product?.short_description"
            ></div>
            <div>
              <button class="button-primary" @click="addToCart(product)">
                Add To Cart
              </button>
            </div>
            <div class="mt-5">
              <h4 class="mt-4 mb-2">Share Via</h4>
              <div class="mb-3 d-flex align-items-center gap-2">
                <SFacebook
                  :window-features="windowFeatures"
                  :share-options="shareOptions"
                  :use-native-behavior="useNativeBehavior"
                  @popup-close="onClose"
                  @popup-open="onOpen"
                  @popup-block="onBlock"
                  @popup-focus="onFocus"
                >
                  <i class="bi bi-facebook fs-3" style="color: #1647c1"></i>
                </SFacebook>
                <SWhatsApp
                  :window-features="windowFeatures"
                  :share-options="shareOptions"
                  :use-native-behavior="useNativeBehavior"
                  @popup-close="onClose"
                  @popup-open="onOpen"
                  @popup-block="onBlock"
                  @popup-focus="onFocus"
                >
                  <i class="bi bi-whatsapp fs-3" style="color: #4ee161"></i>
                </SWhatsApp>
                <STwitter
                  :window-features="windowFeatures"
                  :share-options="shareOptions"
                  :use-native-behavior="useNativeBehavior"
                  @popup-close="onClose"
                  @popup-open="onOpen"
                  @popup-block="onBlock"
                  @popup-focus="onFocus"
                >
                  <i class="bi bi-twitter fs-3" style="color: #1c96e9"></i>
                </STwitter>
                <SLinkedIn
                  :window-features="windowFeatures"
                  :share-options="shareOptions"
                  :use-native-behavior="useNativeBehavior"
                  @popup-close="onClose"
                  @popup-open="onOpen"
                  @popup-block="onBlock"
                  @popup-focus="onFocus"
                >
                  <i class="bi bi-linkedin fs-3" style="color: #056394"></i>
                </SLinkedIn>
              </div>
              <h4 class="mb-2">Customer Review:</h4>
              <div class="d-flex align-items-center gap-1">
                <span class="primary-color d-flex align-items-center gap-1">
                  <i
                    class="bi fs-4"
                    :class="
                      ProductAverageRating < star ? 'bi-star' : 'bi-star-fill'
                    "
                    v-for="star in 5"
                  ></i>
                </span>
                <span> ( {{ product?.reviews?.length }} ) Ratings </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="overflow-hidden shadow">
            <div class="p-3" style="background-color: #031b4e">
              <h3
                class="text-white p-2 mb-2 text-center"
                style="border-block: 1px solid #fff"
              >
                Same day delivery or the next day (We Do not have any Delivery
                Charges)
              </h3>
            </div>
            <div class="p-2">
              <p class="text-dark fs-4 mb-3 text-center">
                Special Discount for Wholesale & Retail Customers
              </p>
              <ul class="ps-4 d-flex flex-column gap-2">
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-credit-card-2-front mt-1 text-dark"></i>
                  <span class="text-dark">Credit Facility Available</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-patch-check mt-1 text-dark"></i>
                  <span class="text-dark">100% Original Products</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-sort-up-alt mt-1 text-dark"></i>
                  <span class="text-dark"
                    >Enjoy Lowest Price with Price Matching</span
                  >
                </li>
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-box mt-1 text-dark"></i>
                  <span class="text-dark"
                    >Largest Collection with 5000+ Items</span
                  >
                </li>
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-cash mt-1 text-dark"></i>
                  <span class="text-dark">Cash on Delivery Facility</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                  <i class="bi bi-shield-check mt-1 text-dark"></i>
                  <span class="text-dark">Excellent Warranty Support</span>
                </li>
              </ul>
              <div class="d-flex flex-column flex align-items-center py-3">
                <div
                  class="d-flex align-items-center justify-contain-center gap-2"
                >
                  <img
                    src="@/assets/images/helpline.png"
                    style="width: 30px; height: 30px"
                  />
                  <span>Helpline</span>
                </div>
                <h3>
                  <a href="tel:017162284115" class="primary-color"
                    >+8801716 284115</a
                  >
                </h3>
                <p class="text-secondary fs-6">
                  Call for Order & Other Enquiry
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container my-5">
      <div class="product-detail-tab bg-white border">
        <ul
          class="nav nav-pills mb-3 justify-content-center border-bottom"
          id="pills-tab"
          role="tablist"
        >
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="pills-desc-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-desc"
              type="button"
              role="tab"
              aria-controls="pills-desc"
              aria-selected="true"
            >
              Description
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="pills-spaci-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-spaci"
              type="button"
              role="tab"
              aria-controls="pills-spaci"
              aria-selected="true"
            >
              Spacification
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="pills-review-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-review"
              type="button"
              role="tab"
              aria-controls="pills-review"
              aria-selected="false"
            >
              Reviews
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="pills-qa-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-qa"
              type="button"
              role="tab"
              aria-controls="pills-qa"
              aria-selected="false"
            >
              Q/A
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="pills-warranty-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-warranty"
              type="button"
              role="tab"
              aria-controls="pills-warranty"
              aria-selected="false"
            >
              Product Warranty
            </button>
          </li>
        </ul>
        <div class="tab-content p-lg-5" id="pills-tabContent">
          <div
            class="tab-pane fade show active"
            id="pills-desc"
            role="tabpanel"
            aria-labelledby="pills-desc-tab"
            tabindex="0"
          >
            <div v-html="product?.description" class="editor_content"></div>
          </div>
          <div
            class="tab-pane fade show"
            id="pills-spaci"
            role="tabpanel"
            aria-labelledby="pills-spaci-tab"
            tabindex="0"
          >
            <div v-html="product?.spacification" class="editor_content"></div>
          </div>
          <div
            class="tab-pane fade"
            id="pills-review"
            role="tabpanel"
            aria-labelledby="pills-review-tab"
            tabindex="0"
          >
            <p
              v-if="$page.props?.auth?.user === null"
              class="fs-5 text-center mb-2"
            >
              <Link class="primary-color" href="/login">login</Link>
              or
              <Link class="primary-color" href="/register">register</Link>
              to Add a Review
            </p>
            <div
              class="py-3 py-lg-0 d-flex flex-column flex-lg-row align-items-center justify-content-between"
            >
              <h3 class="mb-3 mb-lg-0">Ratings & Reviews</h3>
              <button
                class="button-primary"
                v-if="$page.props?.auth?.user"
                @click="activeReview"
              >
                Write A Review
              </button>
            </div>
            <div v-if="reviewArea">
              <div class="border rounded p-2 p-lg-4 m-lg-3 d-flex flex-column">
                <div class="mb-4">
                  <h4 class="mb-2">Product Ratting</h4>
                  <div class="rating">
                    <input
                      v-model="createReview.rating"
                      type="radio"
                      id="star5"
                      name="rating"
                      value="5"
                    />
                    <label
                      class="star"
                      for="star5"
                      title="Awesome"
                      aria-hidden="true"
                    >
                      <i class="bi bi-star-fill"></i>
                    </label>
                    <input
                      v-model="createReview.rating"
                      type="radio"
                      id="star4"
                      name="rating"
                      value="4"
                    />
                    <label
                      class="star"
                      for="star4"
                      title="Great"
                      aria-hidden="true"
                    >
                      <i class="bi bi-star-fill"></i>
                    </label>
                    <input
                      v-model="createReview.rating"
                      type="radio"
                      id="star3"
                      name="rating"
                      value="3"
                    />
                    <label
                      class="star"
                      for="star3"
                      title="Very good"
                      aria-hidden="true"
                    >
                      <i class="bi bi-star-fill"></i>
                    </label>
                    <input
                      v-model="createReview.rating"
                      type="radio"
                      id="star2"
                      name="rating"
                      value="2"
                    />
                    <label
                      class="star"
                      for="star2"
                      title="Good"
                      aria-hidden="true"
                    >
                      <i class="bi bi-star-fill"></i>
                    </label>
                    <input
                      v-model="createReview.rating"
                      type="radio"
                      id="star1"
                      name="rating"
                      value="1"
                    />
                    <label
                      class="star"
                      for="star1"
                      title="Bad"
                      aria-hidden="true"
                    >
                      <i class="bi bi-star-fill"></i>
                    </label>
                  </div>
                </div>
                <div>
                  <h4 class="d-block">Add Written Review</h4>
                  <textarea
                    v-model="createReview.review"
                    class="w-100 border rounded p-2 mt-3 shadow-sm"
                    rows="5"
                    placeholder="How's the quality of the products"
                  ></textarea>
                </div>
                <div>
                  <button class="button-primary mt-3 px-5" @click="addReview">
                    Submit
                  </button>
                </div>
              </div>
            </div>
            <div class="border-bottom pb-3 mb-5">
              <h2 class="fs-2">{{ ProductAverageRating }}</h2>
              <div class="d-flex align-items-center gap-1">
                <span class="primary-color d-flex align-items-center gap-1">
                  <i
                    class="bi fs-4"
                    :class="
                      ProductAverageRating < star ? 'bi-star' : 'bi-star-fill'
                    "
                    v-for="star in 5"
                  ></i>
                </span>
                <span> ( {{ product?.reviews?.length }} ) Ratings </span>
              </div>
            </div>

            <div v-if="product.reviews">
              <div class="border-bottom py-4" v-for="item in product.reviews">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-3">
                    <span class="primary-color d-flex align-items-center gap-1">
                      <i
                        class="bi fs-4"
                        :class="item.rating < star ? 'bi-star' : 'bi-star-fill'"
                        v-for="star in 5"
                      ></i>
                    </span>
                    <p>{{ item?.user?.name }}</p>
                  </div>
                  <span>{{ item?.created_at }}</span>
                </div>
                <p>{{ item?.review }}</p>
              </div>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="pills-qa"
            role="tabpanel"
            aria-labelledby="pills-qa-tab"
            tabindex="0"
          >
            <div
              v-if="$page.props?.auth?.user"
              class="mb-2 d-flex w-100 w-lg-50 mx-auto rounded"
              :class="{
                'flex-column align-items-end border border-secondary': textarea,
              }"
            >
              <textarea
                name=""
                id=""
                class="questionField"
                :class="{ 'questionField--active': textarea }"
                v-model="createQuestion.question"
                @click="active"
                placeholder="Ask Question"
              ></textarea>
              <button
                @click="addQuestion"
                class="button-primary"
                :class="{ 'm-1': textarea }"
              >
                Ask Question
              </button>
            </div>
            <p v-else class="fs-5 text-center mb-2">
              <Link class="primary-color" href="/login">login</Link>
              or
              <Link class="primary-color" href="/register">register</Link>
              to ask Bttex now and answer will show here.
            </p>
            <h3 class="mb-4">
              Questions About This Product (
              {{ product?.questions?.length }} )
            </h3>

            <div class="py-3" v-for="item in product.questions">
              <div class="d-flex gap-3 mb-4">
                <span class="mt-1">
                  <i class="bi bi-chat-square-fill primary-color"></i>
                </span>
                <div class="w-80">
                  <p>{{ item.question }}</p>
                  <div class="d-flex align-items-center gap-5">
                    <span>{{ item?.user?.name }} {{ item.created_at }}</span>
                    <span
                      class="primary-color fs-5 cursor-pointer"
                      @click="replay"
                      v-if="
                        item.answer == null &&
                        $page.props.auth.user.type === 'admin'
                      "
                      >Replay</span
                    >
                  </div>
                  <!--                                    Answer -->
                  <div class="mt-4" v-if="ansArea && item.answer == null">
                    <textarea
                      v-model="createAnswer.answer"
                      class="p-1"
                      style="width: 100%; max-width: 500px; height: 100px"
                    ></textarea>
                    <button
                      class="button-primary d-block"
                      @click="addAnswer(item.id)"
                    >
                      Submit
                    </button>
                  </div>
                </div>
              </div>

              <div class="d-flex gap-3 border-bottom pb-2" v-if="item.answer">
                <span class="mt-1">
                  <i class="bi bi-chat-square-fill text-secondary"></i>
                </span>
                <div>
                  <p>{{ item.answer }}</p>
                  <span
                    >{{ $page.props.auth.APP_NAME }} - answered within 1
                    hour</span
                  >
                </div>
              </div>
            </div>
          </div>

          <div
            class="tab-pane fade show"
            id="pills-warranty"
            role="tabpanel"
            aria-labelledby="pills-warranty-tab"
            tabindex="0"
          >
            <div v-html="product?.warranty" class="editor_content"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container slider-image pb-5">
      <div class="bt-title mb-4">
        <h2>Related Products</h2>
        <div
          class="d-flex align-items-center justify-content-center gap-2 mt-2 mb-6"
        >
          <span style="background-color: red"></span>
          <span style="background-color: green"></span>
          <span style="background-color: yellow"></span>
        </div>
      </div>

      <RelatedProductSlider :slides="relatedProducts" />
    </div>
  </AppLayout>
</template>

<style lang="scss" scoped>
.loader {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 50%;
  left: 50%;
  z-index: 99;
  transform: translate(-50%, -50%);
  backdrop-filter: blur(5px);
  display: flex;
  align-items: center;
  justify-content: center;
}

#loading {
  display: inline-block;
  width: 50px;
  height: 50px;
  border: 5px solid rgb(0, 0, 0, 0.2);
  border-radius: 50%;
  border-top-color: red;
  animation: spin 1s ease-in-out infinite;
  -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}
@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

.swiper-slide {
  height: unset !important;
}

.rating {
  border: none;
  float: left;
}

.rating > label {
  color: rgba(192, 188, 188, 0.94);
  float: right;
  margin-left: 5px;
}
.rating > label > i {
  font-size: 32px;
}

.rating > input {
  display: none;
}

.rating > input:checked ~ label,
.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
  color: #e50102;
}

.rating > input:checked + label:hover,
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label,
.rating > input:checked ~ label:hover ~ label {
  color: #e50102;
}
</style>
