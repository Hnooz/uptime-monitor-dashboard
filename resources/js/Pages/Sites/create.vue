<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';

    defineProps({
        sites: Object
    })

    const addSite = ref(false)

    const user = usePage().props.auth.user;

    const form = useForm({
        domain : null,
        description : null,
        user_id: user.id
    })

    const submit = () =>{
        form.post(route('sites.store'),{
            preserveScroll: true,
            onSuccess: () => closeModal(),
        })
    }

    const closeModal = () => {
        addSite.value = false;
        form.reset();
    };
</script>

<template>
    <button @click="addSite = true" class="flex items-center gap-x-2 text-sm rounded-md font-medium bg-gray-800 px-4 py-2 text-left capitalize  text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
        </svg>
        <span>add site</span>
    </button>

    <Modal :show="addSite" @close="closeModal">
        <div class="p-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900">Add Site</h2>
            </header>
            <form @submit.prevent="submit"  class="mt-6 space-y-6">
                
                <div class="mt-6">
                    <InputLabel for="domain" value="Domain" class="sr-only" />
                    <TextInput
                        id="domain"
                        v-model="form.domain"
                        type="url"
                        class="mt-1 block w-full"
                        placeholder="www.example.com"
                        @keyup.enter="submit"
                    />
                    <InputError :message="form.errors.domain" class="mt-2" />
                </div>
                <div class="mt-6">
                    <InputLabel for="description" value="Description" class="sr-only" />
                    
                    <textarea id="description"
                        v-model="form.description"
                        class="border-gray-300 mt-1 block w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        
                        placeholder="Brief description"></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                    
                </div>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>

