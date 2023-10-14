<script setup>
import Create from '@/Pages/Sites/create.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { Head, useForm, usePage, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    sites: Object,
    endpoints: Object,
})

const page = usePage()
const site = ref({})
const form = useForm({ is_connected : null})
const confirmingDeletion = ref(false)

const connect = (site, event) => {
    form.is_connected = event
    form.put(route('sites.update-connection', site))
}

const confirmDeletion = (data) => {
    confirmingDeletion.value = true
    site.value = data
}

const destroy = () => {
    router.delete(route('sites.destroy', site.value), {
        onSuccess: () => confirmingDeletion.value = false
    })
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

                <div class="mt-6">
                    <div v-if="sites.data.length > 0">
                        <!-- <hr class="my-6 border-gray-200 "> -->
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">
                            <div v-for="site in sites.data" :key="site.id" class="flex flex-col justify-between p-5 bg-white rounded-lg shadow-lg shadow-gray-200 dark:bg-gray-800 dark:shadow-none">
                                <div class="flex items-center justify-between">
                                    <Link :href="`/sites/${site.id}`" class="flex capitalize items-center font-medium text-gray-600 gap-x-2 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>

                                        {{site.name}}
                                    </Link>
    
                                    <button type="button" @click="confirmDeletion(site)" class="text-gray-400 hover:text-red-500 duration-200 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>

                                <p class="mt-4 text-sm text-gray-600 capitalize dark:text-gray-300">{{ site.description }}</p>
                                
                                <div class="flex items-baseline justify-between mt-4">
                                    <button @click="connect(site, is_connected = false)" v-if="site.is_connected" class="flex items-center px-4 py-2 text-sm text-red-600 transition-colors duration-200 bg-red-100 rounded-lg hover:bg-red-200 dark:bg-red-700/50 dark:text-white gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                        </svg>
                                        Disconnect
                                    </button>
                                    <button v-else @click="connect(site, is_connected = true)" class="flex items-center px-4 py-2 text-sm text-emerald-600 transition-colors duration-200 bg-emerald-100 rounded-lg hover:bg-emerald-200 dark:bg-emerald-700/50 dark:text-white gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                        </svg>
                                        Connect
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
        </div>

        <confirmation-modal :show="confirmingDeletion" @close="confirmingDeletion = false">
            <template #title>
                Delete Site
            </template>

            <template #content>
                <p>are you sure you want to delete this site?</p>
            </template>

            <template #footer>
                <secondary-button @click="confirmingDeletion = false">
                    Cancel
                </secondary-button>

                <danger-button class="ml-2" @click="destroy">
                    Delete Site
                </danger-button>
            </template>
        </confirmation-modal>

    </AppLayout>
</template>
