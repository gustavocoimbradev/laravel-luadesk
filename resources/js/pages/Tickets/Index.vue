<script setup>
import { formatDate } from '@/utils/date';
import PanelLayout from '@/layouts/PanelLayout.vue';
import { Link } from '@inertiajs/vue3';
import { show as ticket, create } from '@/routes/tickets';
defineProps({
    tickets: Array
})
</script>

<template>
    <PanelLayout v-slot="slot">

        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div v-html="slot.title" class="flex items-center gap-2"></div>
                    <div>
                        <Link id="new-ticket-button" :href="create.url()" class="button button-primary">
                            New ticket
                        </Link>
                    </div> 
                </div>
            </div>
             <div class="card-body">
                <div class="text-center p-4 text-blue-950/70" v-if="!tickets.length">
                    No tickets created yet
                </div>
                <div class="responsive-table" v-if="tickets.length">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th v-if="$page.props.auth.is_admin">Author</th>
                                <th class="w-[300px]">Date</th>
                                <th class="text-center w-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <Link as="tr" v-for="item in tickets" :href="ticket.url(item.id)" class="cursor-pointer">
                                <td>{{ item.title }}</td>
                                <td v-if="$page.props.auth.is_admin">{{ item.user.name }}</td>
                                <td>{{ formatDate(item.created_at) }}</td>
                                <td>
                                    <div class="badge" :data-status="item.status">{{ item.status === 0 ? 'Pending' : (item.status === 1 ? 'Answered' : 'Closed') }}</div>
                                </td>
                            </Link>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </PanelLayout>
</template>