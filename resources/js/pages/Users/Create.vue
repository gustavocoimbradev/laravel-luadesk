<script setup>
import { useForm } from '@inertiajs/vue3';
import PanelLayout from '@/layouts/PanelLayout.vue';
import { store } from '@/routes/users';
const form = useForm({
    'name': '',
    'email': '',
    'password': '',
    'is_admin': 0
});
const submit = () => {
    form.post(store.url());
}
</script>

<template>
    <PanelLayout>
        <form @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    New user
                </div>
                <div class="card-body">
                    <input type="text" class="field" placeholder="Name" v-model="form.name"/>
                    <div class="error" v-if="$page.props.errors.name">{{ $page.props.errors.name }}</div>
                    <input type="text" class="field" placeholder="Email" v-model="form.email"/>
                    <div class="error" v-if="$page.props.errors.email">{{ $page.props.errors.email }}</div>
                    <input type="password" class="field" placeholder="Password" v-model="form.password"/>
                    <div class="error" v-if="$page.props.errors.password">{{ $page.props.errors.password }}</div>
                    <select required class="field" v-model="form.is_admin">
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                    </select>
                    <div class="error" v-if="$page.props.errors.is_admin">{{ $page.props.errors.is_admin }}</div>
                </div>
                <div class="card-footer">
                    <button type="submit" :class="['button button-primary', form.processing ? 'button-disabled' : '']">Create user</button>
                </div>
            </div>
        </form>
    </PanelLayout>
</template>