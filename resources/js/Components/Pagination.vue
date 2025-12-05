<template>
    <div class="pagination">
        <div class="pagination__left">
            <div class="pagination__left__text" v-if="!props.notShowNumber">
                Showing <span class="primary-color">{{ from }}</span> to <span class="primary-color">{{ to }}</span> of <span class="primary-color">{{ total }}</span> entries
            </div>
        </div>
        <div class="pagination__right">
            <ul class="pagination__right__list">
                <li
                    class="pagination__right__list__item"
                    v-for="link in links"
                    :class="{ 'pagination__right__list__item--active' : link.active }"
                >
                    <Link :href="link.url" class="pagination__right__list__item__link" v-html="link.label" />
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import {Link } from '@inertiajs/vue3'
    const props = defineProps({
        links: {
            type: Array
        },
        from: {
            type: Number,
            default: 0
        },
        to: {
            type: Number,
            default: 0
        },
        total: {
            type: Number,
            default: 0
        },
        notShowNumber:{
            type:Boolean,
            default:false,
        }
    })
</script>