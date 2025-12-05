<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <!-- Side Bar -->
    <aside class="side-bar">
        <div class="side-bar-header border-bottom bg-black">
            <img style="width:200px; height: auto;" :src="$page?.props?.setting?.header_logo" alt="">
            <ul class="d-flex align-items-center justify-content-end gap-3">
                <li>
                    <Link href="/dashboard">
                        <i class="bi bi-house text-white"></i>
                    </Link>
                </li>
                <li>
                    <Link href="/profile">
                        <i class="bi bi-person-circle text-white"></i>
                    </Link>
                </li>
                <li>
                    <a  :href="$page.props.auth.APP_URL" target="_blank">
                        <i class="bi bi-globe text-white"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="side-bar-body">
            <ul class="side-bar-body-items">
                <li>
                    <Link
                        href="/dashboard"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.component === 'Dashboard'}"
                    >
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </Link>
                </li>

                <li>
                    <Link href="/dashboard/products"
                          class="side-bar-body-items-item"
                          :class="{'side-bar-body-items-item--active': $page.component === 'Properties/ManageProperty'}"
                    >
                        <i class="bi bi-boxes"></i>
                        <span>Products</span>
                    </Link>
                </li>

                <li>
                    <a

                    class="side-bar-body-items-item "
                    data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"
                    :class="{'side-bar-body-items-item--active': $page.component === 'Category'}"
                    >
                        <i class="bi bi-ui-checks-grid"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="collapse ms-2" id="collapseExample">
                        <li>
                            <Link
                                href="/categories"
                                class="side-bar-body-items-item gap-1"
                                :class="{'side-bar-body-items-item--active': $page.component === 'Brand'}"
                            >
                            <i class="bi bi-app fs-5"></i>
                                <span>Main Category</span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/sub-categories"
                                class="side-bar-body-items-item gap-1"
                                :class="{'side-bar-body-items-item--active': $page.component === 'SubCategory'}"
                            >
                            <i class="bi bi-app fs-5"></i>
                                <span>Sub Category</span>
                            </Link>
                        </li>
                    </ul>
                </li>

                <li>
                    <Link
                        href="/brands"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.component === 'Brand'}"
                    >
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Brands</span>
                    </Link>
                </li>
                <li>
                    <Link
                        href="/clients"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.component === 'Client'}"
                    >
                        <i class="bi bi-person-circle"></i>
                        <span>Clients</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/pages"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item&#45;&#45;active': $page.url.startsWith('/pages')}"
                    >
                        <i class="bi bi-body-text"></i>
                        <span>Pages</span>
                    </Link>
                </li> 
                <!-- Settings -->
                <li>
                    <Link
                        href="/abouts"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.url.startsWith('/dashboard/abouts')}"
                    >
                        <i class="bi bi-back"></i>
                        <span>Abouts</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/seocontents"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.url.startsWith('/dashboard/seocontents')}"
                    >
                        <i class="bi bi-calendar-range"></i>
                        <span>Seo Contents</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/calibration"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.url.startsWith('/calibration')}"
                    >
                        <i class="bi bi-twitch"></i>
                        <span>Calibration</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/slider"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.url.startsWith('/slider')}"
                    >
                        <i class="bi bi-images"></i>
                        <span>Slider</span>
                    </Link>
                </li>

                <li>
                    <Link
                        href="/advertise"
                        class="side-bar-body-items-item"
                        :class="{'side-bar-body-items-item--active': $page.url.startsWith('/advertise')}"
                    >
                        <i class="bi bi-badge-ad"></i>
                        <span>Advertise</span>
                    </Link>
                </li>

                <li>
                    <Link
                    href="/dashboard/settings"
                    class="side-bar-body-items-item"
                    :class="{'side-bar-body-items-item--active': $page.url.startsWith('/dashboard/settings')}"
                    >
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </Link>
                </li>
                <li>
                    <Link
                    href="/cache/clear"
                    class="side-bar-body-items-item"
                    :class="{'side-bar-body-items-item--active': $page.url.startsWith('/cache/clear')}"
                    >
                        <i class="bi bi-gear"></i>
                        <span>Cache Clear</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
