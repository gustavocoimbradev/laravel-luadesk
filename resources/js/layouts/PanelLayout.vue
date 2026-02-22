<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { index as tickets } from '@/routes/tickets';
import { index as users, edit as myAccount } from '@/routes/users';
import { destroy as logout } from '@/routes/auth';
import { Menu, X, Moon } from 'lucide-vue-next';

const page = usePage();
 
let allPages = [
    {
        'title': page.props.auth.is_admin && page.props.count.pending !== 0 ? 'Tickets <div class="badge badge-tiny">'+page.props.count.pending+'</div>' : 'Tickets',
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

const isExpanded = ref(false);

const toggleMenu = () => {
    isExpanded.value = !isExpanded.value;
}

</script>

<template>
    <div class="flex h-full">
        <div class="bg-blue-950 h-[65px] fixed w-full top-0 left-0 flex items-center justify-start gap-6 px-4 md:hidden">
            <div :class="['text-2xl text-white flex items-center gap-2 transition-all ease-in-out duration-300', isExpanded ? 'opacity-0 pointer-events-none' : '']">
                <button class="cursor-pointer mr-2">
                    <Menu class="text-amber-100" :size="30" @click="toggleMenu"/>
                </button>
                <Moon class="text-amber-100" :size="21"/>
                <span><strong class="text-amber-100">Lua</strong>/desk</span>
            </div>
        </div>
        <div :class="['h-full w-full md:w-[250px] bg-blue-950 p-4 flex flex-col fixed md:left-0 transition-all ease-in-out duration-600', isExpanded ? 'left-0' : 'left-[-100dvw] ']">
            <div class="text-2xl text-white flex items-center gap-2">
                <button class="cursor-pointer mr-2 md:hidden">
                    <X class="text-amber-100" :size="30" @click="toggleMenu"/>
                </button>
                <Moon class="text-amber-100" :size="21"/>
                <span><strong class="text-amber-100">Lua</strong>/desk</span>
            </div>
            <nav class="border-t border-amber-100/10 mt-4 pt-4 list-none flex flex-col gap-3">
                <Link v-for="item in visiblePages" :href="item.href" :class="['button button-sidebar', item.active?'button-sidebar-active':'']">
                    <span v-html="item.title" class="flex items-center gap-2"></span>
                </Link>
            </nav>
            <div class="mt-auto flex flex-col gap-3">
                <Link :href="myAccount.url($page.props.auth.user.id)" :class="['button button-sidebar', (page.props.route === 'users.edit' && page.props.user.id === page.props.auth.user.id) ? 'button-sidebar-active' : '']">
                    My account
                </Link>
                <form @submit.prevent="logoutForm">
                    <button type="submit" class="p-2 text-white transition-all ease-in-out duration-300 w-full text-left hover:bg-blue-500/10 cursor-pointer">
                        Logout 
                    </button>
                </form>
            </div>
        </div>
        <div class="bg-blue-950/5 flex-1 p-5 flex flex-col gap-4 overflow-x-hidden mt-[70px] md:ml-[250px] md:mt-0">
            <div class="success-solid" v-if="$page.props.flash.success">{{ page.props.flash.success }}</div>
            <div class="error-solid" v-if="$page.props.flash.error">{{ page.props.flash.error }}</div>
            <slot :title="visiblePages.find(item => item.active === true)?.title"/>
        </div>
    </div>
</template>