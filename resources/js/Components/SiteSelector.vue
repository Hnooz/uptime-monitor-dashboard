<template>
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <!-- Settings Dropdown -->
        <div class="ml-3 relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                            Sites
                            <svg
                                class="ml-2 -mr-0.5 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <div v-for="site in sites" :key="site.id">
                        <DropdownLink :href="`/dashboard/${site.id}`"> {{site.domain}} </DropdownLink>
                    </div>
                    <button @click="addSite = true" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        add site
                    </button>
                </template>
            </Dropdown>
        </div>
    </div>

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
                        class="mt-1 block w-3/4"
                        placeholder="www.example.com"
                        @keyup.enter="submit"
                    />
                    <InputError :message="form.errors.domain" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
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
