<script setup>
import Modal from '@/Components/Modal.vue';
import { ref } from "vue"

 defineProps({
    check: Object
 })
 const viewResponseBody = ref(false)
</script>

<template>
    <tr>
        <td class="px-12 py-3.5 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
            <template v-if="check">
                <time :datetime="check.created_at.date_time">{{check.created_at.human}}</time>
            </template>
            <template v-else>
                -
            </template>
        </td>
        <td class="px-12 py-3.5 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
            <span class="inline-flex text-white items-center rounded-md px-2.5 py-0.5 text-sm font-semibold" :class="{'bg-green-500': check.is_successful, 'bg-rose-500' : !check.is_successful}">
                {{check.response_code}} {{check.status_text}} 
            </span>
        </td>
        <td>
            <template v-if="check.response_body">
               <button @click="viewResponseBody = true">view</button>
            </template>
            <template v-else>
                -
            </template>
        </td>
    </tr>

    <Modal :show="viewResponseBody" @close="viewResponseBody = false">
        <div class="p-6">
           <textarea class="border border-gray-300 rounded-md w-full" :value="check.response_body" readonly rows="10"></textarea>
        </div>
    </Modal>
</template>
