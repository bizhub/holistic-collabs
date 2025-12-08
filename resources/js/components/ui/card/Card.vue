<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div
    data-slot="card"
    :class="
      cn(
        'bg-card text-card-foreground flex flex-col gap-6 border border-slate-200 py-6 shadow-sm shadow-slate-100',
        props.class,
      )
    "
  >
    <slot />
  </div>
</template>
