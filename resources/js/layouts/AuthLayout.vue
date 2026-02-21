<script setup>
import { Moon } from 'lucide-vue-next';
</script>

<template>
    <div class="flex h-full items-center justify-center bg-blue-950">
        <div class="flex flex-col items-center justify-center">
            <div class="text-4xl text-white mb-6 flex items-center gap-2">
                <Moon class="text-amber-100" :size="30"/>
                <span><strong class="text-amber-100">Lua</strong>/desk</span>
            </div>
            <div class="bg-amber-100 border border-amber-200/50 shadow-lg p-6 w-[400px] max-w-full ">
                <slot/>
            </div>
        </div>
    </div>
</template>