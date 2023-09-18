<script setup>
    import { router, useForm } from "@inertiajs/vue3";
    import TextInput from '@/Components/TextInput.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import InputError from '@/Components/InputError.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'

    const props = defineProps({site : Object})
    const form = useForm({ email : []})

    const submit = () => form.put(route('notification.emails.store', props.site), { 
        preserveScroll : true, 
        onSuccess: () => form.reset()
    })

    const destroy = (email) => {
        router.delete(`/sites/${props.site.id}/notification/emails?email=${email}`,{
            preserveScroll : true,
        })
    }
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            Email
        </h2>

        <form @submit.prevent="submit" class="flex items-start mt-4 space-x-2">
            <div class="grow">
                <input-label for="email" value="email" class="sr-only" />

                <text-input id="email" type="email" v-model="form.email" class="block w-full h-9 text-sm" placeholder="e.g./ pricing" />
                <input-error class="mt-2" :message="form.errors.email" />
            </div>
            <primary-button>Add</primary-button>
        </form>

        <div class="mt-6">
            <ul class="space-y-2">
                <li v-for="email in site.notification_emails" :key="email.index" class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">{{email}}</span>
                    <button type="button" @click="destroy(email)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>