<script setup>
import SideBar from '@/Components/SideBar.vue';
</script>

<template>
    <div>
        <div class="layout">

            <SideBar />

            <!-- App Content -->
            <div class="app-content">
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
