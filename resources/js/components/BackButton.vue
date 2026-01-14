<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ChevronLeft } from 'lucide-vue-next'
</script>

<template>
    <Link href="/" class="mb-1 inline-flex items-center text-sm text-zinc-500 transition ease-in-out hover:text-zinc-800">
        <ChevronLeft class="mr-1 h-4 w-4" /> <slot>Back</slot>
    </Link>
</template>
