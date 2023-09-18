<script setup>
import SiteSelector from '@/Components/SiteSelector.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import Check from '@/Components/Check.vue'
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';


const props = defineProps({
    endpoint: Object,
})

const page = usePage()


</script>

<template>
    <Head title="Endpoint" />

    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <Link :href="`/dashboard/${endpoint.data.site.id}`" class="font-medium text-gray-600 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>{{endpoint.data.url}}</span>
                </Link>

                <SiteSelector :sites="page.props.sites.data" />
            </div>
        </template>

        <div class="py-12">
            <div v-if="endpoint.data.checks.length > 0" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8">
                    <h1 class="font-semibold text-lg text-gray-600 capitalize leading-tight">
                        {{endpoint.data.checks.length}} checks
                    </h1>
                    <section class="container mx-auto">
                        <div class="flex flex-col mt-6">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                                <tr>
                                                    <th scope="col" class="py-3.5 px-12 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Checked at
                                                    </th>

                                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Response code
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                       Response body
                                                    </th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">                                                
                                                <check v-for="check in endpoint.data.checks" :key="check.id" :check="check" />                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <div v-else class="max-w-7xl flex justify-center items-center mx-auto sm:px-6 lg:px-8">
               <img class="w-1/2" src="../../../../public/no_data.svg" alt="">
            </div>
        </div>
    </AppLayout>
</template>
