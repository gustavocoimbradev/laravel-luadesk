<script setup>
import { useForm } from '@inertiajs/vue3';
import PanelLayout from '@/layouts/PanelLayout.vue';
import { store } from '@/routes/tickets';
const form = useForm({
    'title': '',
    'content': ''
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
                    New ticket
                </div>
                <div class="card-body">
                    <input class="field" placeholder="Title of your request" v-model="form.title"/>
                    <div class="error" v-if="$page.props.errors.content">{{ $page.props.errors.title }}</div>
                    <textarea class="field mb-0 h-[100px]" placeholder="Describe your request..." v-model="form.content"></textarea>
                    <div class="error" v-if="$page.props.errors.content">{{ $page.props.errors.content }}</div>
                </div>
                <div class="card-footer">
                    <button type="submit" :class="['button button-primary', form.processing ? 'button-disabled' : '']">Create ticket</button>
                </div>
            </div>
        </form>
    </PanelLayout>
</template>