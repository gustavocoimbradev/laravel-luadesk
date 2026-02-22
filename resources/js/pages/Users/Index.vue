<script setup>
import PanelLayout from '@/layouts/PanelLayout.vue';
import { Link } from '@inertiajs/vue3';
import { create, edit } from '@/routes/users';
defineProps({
    users: Array
})
</script>

<template>
    <PanelLayout v-slot="slot">

        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div>
                        {{ slot.title }}
                    </div>
                    <div>
                        <Link id="new-ticket-button" :href="create.url()" class="button button-primary">
                            New user
                        </Link>
                    </div> 
                </div>
            </div> 
             <div class="card-body">
                <div class="text-center p-4 text-blue-950/70" v-if="!users.length">
                    No users created yet
                </div>
                <div class="responsive-table" v-if="users.length">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="w-[300px]">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <Link as="tr" v-for="user in users" :href="edit.url(user.id)" class="cursor-pointer">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.is_admin ? 'Admin' : 'User' }}</td>
                            </Link>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </PanelLayout>
</template>