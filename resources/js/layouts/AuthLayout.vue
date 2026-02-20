<template>
    <div class="flex h-full items-center justify-center bg-blue-950">
        <div class="flex flex-col items-center justify-center">
            <div class="text-4xl text-white mb-6">
                <strong class="text-amber-100">Lua</strong>/desk
            </div>
            <div class="bg-amber-100 border border-amber-200/50 shadow-lg p-6 w-[400px] max-w-full ">
                <slot/>
            </div>
        </div>
    </div>
</template>