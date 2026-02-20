<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from "@/routes/auth";
const form = useForm({
    email: '',
    password: ''
});
const submit = () => {
    form.post(store.url());
};
</script>

<template>
    <AuthLayout>
        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <fieldset class="flex flex-col">
                <input v-model="form.email" type="email" id="email" class="outline-none p-2 border border-amber-400/50 w-full bg-amber-200/50" placeholder="Email"/>
            </fieldset>
            <fieldset class="flex flex-col">
                <input v-model="form.password" type="password" id="password" class="outline-none p-2 border border-amber-400/50 w-full bg-amber-200/50" placeholder="Password"/>
            </fieldset>
        <div v-if="$page.props.errors.message" class="text-red-700 border-dashed border p-2 border-red-700">
            {{ $page.props.errors.message }}
        </div>
            <div>
                <button type="submit" class="p-2 bg-blue-950 text-white w-full cursor-pointer transition-all ease-in-out duration-300 hover:bg-blue-900">Log In</button>
            </div>
        </form>
    </AuthLayout>
</template>