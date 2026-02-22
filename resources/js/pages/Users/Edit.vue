<script setup>
import { useForm } from '@inertiajs/vue3';
import PanelLayout from '@/layouts/PanelLayout.vue';
import { update } from '@/routes/users';
const props = defineProps({
    user: Object 
});
const form = useForm({
    'name': props.user.name,
    'email': props.user.email,
    'password': '',
    'is_admin': props.user.is_admin
});
const submit = () => {
    form.put(update.url(props.user.id));
}
</script>

<template>
    <PanelLayout>
        <form @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    {{ $page.props.auth.user.is_admin ? 'User' : 'My account' }}
                </div>z
                <div class="card-body">
                    <input type="text" class="field" placeholder="Name" v-model="form.name"/>
                    <div class="error" v-if="$page.props.errors.name">{{ $page.props.errors.name }}</div>
                    <input type="text" class="field" placeholder="Email" v-model="form.email"/>
                    <div class="error" v-if="$page.props.errors.email">{{ $page.props.errors.email }}</div>
                    <input type="password" class="field" placeholder="Password (let it blank if you do not want to change it)" v-model="form.password"/>
                    <div class="error" v-if="$page.props.errors.password">{{ $page.props.errors.password }}</div>
                    <select required class="field" v-model="form.is_admin" v-if="$page.props.auth.user.is_admin">
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                    </select>
                    <div class="error" v-if="$page.props.errors.is_admin">{{ $page.props.errors.is_admin }}</div>
                </div>
                <div class="card-footer">
                    <button type="submit" :class="['button button-primary', form.processing ? 'button-disabled' : '']">
                        {{ $page.props.auth.user.is_admin ? 'Update user' : 'Update my info' }}
                    </button>
                </div>
            </div>
        </form>
    </PanelLayout>
</template>