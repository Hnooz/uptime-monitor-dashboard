<script setup>
import Create from '@/Pages/Sites/create.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage, Link, router } from '@inertiajs/vue3';


const props = defineProps({
    sites: Object,
    endpoints: Object,
})

const page = usePage()

const destroy = (site) => {
    if(window.confirm("Are you sure you want to destroy this site?")){
        router.delete(route('sites.destroy', site))
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between w-full">
                    <h1 class=" font-medium text-2xl text-gray-700">Sites</h1>
                    <create />
                </div>

                <div v-if="sites.data.length > 0">
                    <hr class="my-6 border border-gray-200 ">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">
                        <div v-for="site in sites.data" :key="site.id" class="flex flex-col justify-between p-5 bg-white rounded-lg shadow-lg shadow-gray-200 dark:bg-gray-800 dark:shadow-none">
                            <div class="flex items-center justify-between">
                                <Link :href="`/sites/${site.id}`" class="flex capitalize items-center font-semibold text-gray-800 gap-x-2 hover:text-blue-500">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                                    </svg>
                                    {{site.name}}
                                </Link>

                                <button type="button" @click="destroy(site)" class="text-rose-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-3 text-sm text-gray-600 capitalize dark:text-gray-300">{{ site.description }}</p>
                            <div class="flex items-baseline justify-between">
                                <button class="flex items-center px-4 py-2 mt-4 text-sm text-red-600 transition-colors duration-200 bg-red-100 rounded-lg hover:bg-red-200 dark:bg-red-700/50 dark:text-white gap-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                    </svg>
                    
                                    Disconnect
                                </button>
                                <span class="text-gray-500 text-sm font-medium">Endpoints {{ site.endpoints_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="max-w-7xl flex flex-col justify-center items-center mx-auto sm:px-6 lg:px-8">
                   <img class="w-1/2" src="../../../public/no_data.svg" alt="">
                </div>
            </div>
        </div>
    </AppLayout>
</template>
