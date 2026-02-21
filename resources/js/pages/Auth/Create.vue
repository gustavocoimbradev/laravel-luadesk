<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from "@/routes/auth";
import { Loader2 } from 'lucide-vue-next';
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
                <button type="submit" :class="['p-2 bg-blue-950 text-white w-full cursor-pointer transition-all ease-in-out duration-300 hover:bg-blue-900 flex items-center gap-3 justify-center', form.processing ? 'disabled opacity-70 pointer-events-none' : '']">
                    <Loader2 v-if="form.processing" class="animate-spin w-5" />
                    <span v-if="!form.processing">Login</span>
                    <span v-if="form.processing">Logging in</span>
                </button>
            </div>
        </form>
    </AuthLayout>
</template>