<script setup lang="ts">
import { computed } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { index as tickets } from '@/routes/tickets';
import { index as users } from '@/routes/users';
import { destroy as logout } from '@/routes/auth';
import { Moon } from 'lucide-vue-next';

const page = usePage();


let allPages = [
    {
        'title': 'Tickets',
        'href': tickets.url(),
        'active': page.props.route === 'tickets.index',
        'show': true,
    },
    {
        'title': 'Users',
        'href': users.url(),
        'active': page.props.route === 'users.index',
        'show': page.props.auth.is_admin,
    }
];

const visiblePages = computed(() => allPages.filter(item => item.show));

const form = useForm();
const logoutForm = () => {
    form.delete(logout.url());
}
</script>

<template>
    <div class="flex h-full">
        <div class="h-full w-[250px] bg-blue-950 p-4 flex flex-col">
            <div class="text-2xl text-white flex items-center gap-2">
                <Moon class="text-amber-100" :size="21"/>
                <span><strong class="text-amber-100">Lua</strong>/desk</span>
            </div>
            <nav class="border-t border-amber-100/10 mt-4 pt-4 list-none flex flex-col gap-3">
                <Link v-for="item in visiblePages" :href="item.href" :class="['p-2 text-white transition-all ease-in-out duration-300 hover:bg-blue-500/10 cursor-pointer', item.active?'bg-blue-500/10':'' ]">
                    {{ item.title }}
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