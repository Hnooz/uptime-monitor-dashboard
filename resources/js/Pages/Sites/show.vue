<script setup>
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Endpoint from '@/Components/Endpoint.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import EmailNotification from '@/Components/EmailNotification.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    site: Object,
    endpoints: Object,
})

const page = usePage()
const form = useForm({
    location : null,
    frequency: page.props.frequencies.data[0].frequency
})

const submit = () => {
    form.post(route('endpoints.store', props.site.data), {
        onSuccess: () => form.reset()
    })
}

</script>

<template>
    <Head title="Show" />

    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{site.data.domain}}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-semibold text-lg- text-gray-800 leading-tight">New endpoint</h1>
                <form @submit.prevent="submit" class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex items-start p-3 mt-4 space-x-2">
                    <div class="grow">
                        <input-label for="location" value="Location" class="sr-only" />

                        <text-input id="location" type="text" v-model="form.location" class="block w-full h-9 text-sm" placeholder="e.g./ pricing" />
                        <input-error class="mt-2" :message="form.errors.location" />
                    </div>
                    <div>
                        <input-label for="frequency" value="Frequency" class="sr-only" />
                        <select name="frequency" id="frequency" v-model="form.frequency" class="block w-44 px-4 py-1.5 border-gray-300 rounded-lg focus:border-indigo-500">
                            <option :value="frequency.frequency" v-for="frequency in usePage().props.frequencies.data" :key="frequency.frequency">{{ frequency.label }}</option>
                        </select>
                    </div>
                    <primary-button>Add</primary-button>
                </form>
                <div v-if="endpoints.data.length > 0" class="mt-8">
                    <h1 class="font-semibold text-lg text-gray-800 leading-tight">
                        Currently monitoring ({{ endpoints.data.length }})
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
                                                        Location
                                                    </th>

                                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Frequency
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Last Check
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Last status
                                                    </th>

                                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        Uptime
                                                    </th>

                                                    <th scope="col" class="relative py-3.5 px-4">
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                                <Endpoint v-for="endpoint in endpoints.data" :key="endpoint.id" :endpoint="endpoint" />
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
               
                <div v-if="endpoints.data.length > 0" class="mt-8 flex flex-col">
                    <h1 class="font-semibold text-lg text-gray-800 leading-tight">Notification channels</h1>
                    <div class="grid grid-cols-3 gap-12 mt-4">
                        <email-notification :site="site.data" />
                    </div>
                </div>

                <div v-else class="max-w-7xl flex flex-col justify-center items-center mx-auto sm:px-6 lg:px-8">
                   <img class="w-1/2" src="./../../../images/no_data.svg" alt="">
                </div>
            </div>
        </div>
    </AppLayout>
</template>
