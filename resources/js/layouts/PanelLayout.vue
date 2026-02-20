<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { index as tickets } from '@/routes/tickets';
import { index as users } from '@/routes/users';
import { destroy as logout } from '@/routes/auth';

const page = usePage();

const pages = [
    {
        'title': 'Tickets',
        'href': tickets.url(),
        'active': page.props.route === 'tickets.index'
    },
    {
        'title': 'Users',
        'href': users.url(),
        'active': page.props.route === 'users.index'
    }
];
const form = useForm();
const logoutForm = () => {
    form.delete(logout.url());
}
</script>

<template>
    <div class="flex h-full">
        <div class="h-full w-[250px] bg-blue-950 p-4 flex flex-col">
            <div class="text-2xl text-white">
                <strong class="text-amber-100">Lua</strong>/desk
            </div>
            <nav class="border-t border-amber-100/10 mt-4 pt-4 list-none flex flex-col gap-3">
                <Link v-for="page in pages" :href="page.href" :class="['p-2 text-white transition-all ease-in-out duration-300 hover:bg-blue-500/10 cursor-pointer', page.active?'bg-blue-500/10':'' ]">
                    {{ page.title }}
                </Link>
            </nav>
            <div class="mt-auto">
                <form @submit.prevent="logoutForm">
                    <button type="submit" class="p-2 text-white transition-all ease-in-out duration-300 w-full text-left hover:bg-blue-500/10 cursor-pointer">
                        Logout 
                    </button>
                </form>
            </div>
        </div>
        <div class="bg-white min-h-[500px]">
            <slot/>
        </div>
    </div>
</template>