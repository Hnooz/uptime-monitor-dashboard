<script setup>
    import TextInput from '@/Components/TextInput.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import DangerButton from '@/Components/DangerButton.vue'
    import { Link, router, usePage, useForm } from '@inertiajs/vue3';
    import { debounce } from "debounce";
    import { ref, watch } from 'vue';

    const props = defineProps({ endpoint: Object })
    const page = usePage()
    const editing = ref(false)
    const confirmingDeletion = ref(false)
    const form = useForm({
        location : props.endpoint.location,
        frequency: props.endpoint.frequency_value
    })


    watch(() => form.isDirty, ()=>{
        edit()
    })



    const edit = debounce(() => {
        form.patch(route('endpoints.update', props.endpoint), {
            preserveScroll: true
        })
    }, 500)

    const destroy = () => {       
        router.delete(route('endpoints.destroy', props.endpoint),{
            onSuccess:()=> confirmingDeletion.value = false
        })
    }
</script>


<template>
    <tr>
        <td class="px-12 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
            <template v-if="editing">
                <text-input id="location" type="text" v-model="form.location" class="block text-sm" placeholder="e.g./ pricing" />
            </template>

            <template v-else>
                <Link :href="`/endpoints/${endpoint.id}`">{{ endpoint.location }}</Link>
            </template>
        </td>
        <td class="px-12 py-4 text-sm font-normal text-gray-700 whitespace-nowrap">
           <template v-if="editing">                
                <select name="frequency" id="frequency" v-model="form.frequency" class="block px-4 py-1.5 border-gray-300 rounded-lg focus:border-indigo-500">
                    <option :value="frequency.frequency" v-for="frequency in page.props.frequencies.data" :key="frequency.frequency">{{ frequency.label }}</option>
                </select>
           </template>

            <template v-else>
                {{ endpoint.frequency_label }}
            </template>
        </td>
        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
            <template v-if="endpoint.latest_check">
                <time :datetime="endpoint.latest_check.created_at.date_time">{{endpoint.latest_check.created_at.human}}</time>
            </template>
            <template v-else>
                -
            </template>
        </td>
        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
            <template v-if="endpoint.latest_check">
                <span class="inline-flex text-white items-center rounded-md px-2.5 py-0.5 text-sm font-semibold" :class="{'bg-green-500': endpoint.latest_check.is_successful, 'bg-rose-500' : !endpoint.latest_check.is_successful}">
                    {{endpoint.latest_check.response_code}} {{endpoint.latest_check.status_text}} 
                </span>
            </template>
            <template v-else>
                -
            </template>
        </td>
        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
            <template v-if="endpoint.uptime_percentage !== null">
                {{ endpoint.uptime_percentage }} %
            </template>

            <template v-else>
                -
            </template>
        </td>
        <td class="px-4 py-4 text-sm whitespace-nowrap flex items-center gap-4">
            <button @click="editing = !editing">
                <svg v-if="!editing" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

            </button>
            <button @click="confirmingDeletion = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </td>
    </tr>
    <confirmation-modal :show="confirmingDeletion" @close="confirmingDeletion = false">
            <template #title>
                Delete Endpoint
            </template>

            <template #content>
                <p>are you sure you want to delete this endpoint?</p>
            </template>

            <template #footer>
                <secondary-button @click="confirmingDeletion = false">
                    Cancel
                </secondary-button>

                <danger-button class="ml-2" @click="destroy">
                    Delete Endpoint
                </danger-button>
            </template>
        </confirmation-modal>
</template>
