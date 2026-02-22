<script setup>
import { useForm } from '@inertiajs/vue3';
import { formatDate } from '@/utils/date';
import PanelLayout from '@/layouts/PanelLayout.vue';
import { store } from '@/routes/answers';
const props = defineProps({
    ticket: Object
})
const form = useForm({
    'content': '',
    'closes_ticket': false
});
const submit = (closes_ticket = false) => {
    form.closes_ticket = closes_ticket;
    form.post(store.url({ticket: props.ticket.id}), {
        onSuccess: () => form.reset('content', 'closes_ticket')
    })
}
</script>

<template>
    <PanelLayout>
        <div class="card">
            <div class="card-header">
                {{ ticket.title }}
            </div>
             <div class="card-body">
                {{ ticket.content }}
            </div>
            <div class="card-footer">
                Requested by {{ ticket.user.name }} at {{ formatDate(ticket.created_at) }}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Answers
            </div> 
             <div class="card-body">
                <div class="flex flex-col gap-4">
                    <div v-for="answer in ticket.answers" :class="['p-3 border-l-2', answer.user.is_admin ? 'border-blue-950 bg-blue-500/5' : 'border-slate-100']">
                        <div class="mb-2">{{ answer.content }}</div>
                        <small class="text-xs text-blue-950/50">Answered by {{ answer.user.name }} at {{ formatDate(answer.created_at) }}</small>
                    </div>
                    <span class="text-blue-950/90" v-if="ticket.answers.length === 0">No response yet</span>
                </div>
            </div>
            <div v-if="ticket.status === 2" class="card-footer text-red-500/50">
                This ticket has been closed at {{ formatDate(ticket.answers[ticket.answers.length-1].created_at) }} by {{ ticket.answers[ticket.answers.length-1].user.name }}
            </div>
            <div class="card-footer text-base" v-if="(ticket.status === 0 || ticket.status === 1) || $page.props.auth.is_admin">
                <form @submit.prevent id="answer-form">
                    <textarea v-model="form.content" class="field h-[100px]" placeholder="Let a message..."></textarea>
                    <div class="error" v-if="$page.props.errors.content">{{ $page.props.errors.content }}</div>
                    <div class="flex items-center gap-3">
                        <button @click="submit(false)" type="submit" :class="['button button-primary', form.processing ? 'button-disabled' : '']">
                            Send message
                        </button>
                        <button @click="submit(true)" id="close-button" v-if="$page.props.auth.is_admin" type="submit" :class="['button button-secondary', form.processing ? 'button-disabled' : '']">
                            Send message and close this ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </PanelLayout>
</template>