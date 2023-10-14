<script setup>

import Flash from '@/Components/Flash.vue';
import Navbar from '@/Components/Navbar.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <Navbar />
            <!-- Page Heading -->
            <header class="bg-white shadow-xl shadow-gray-200" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
        <flash v-if="page.props.flash" :type="page.props.flash.type" :popstate="page.props.popstate">{{ page.props.flash.message}}</flash>
    </div>
</template>
