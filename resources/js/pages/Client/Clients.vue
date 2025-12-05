<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Plug } from 'lucide-vue-next'

interface Props {
    commissions: Domain.Commission.Data.CommissionGroupData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
]
</script>

<template>
    <Head title="Coupons" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold tracking-tight">Clients</h1>
                    <Link :href="'/asd'">
                        <Button size="sm"><Plug />Connect</Button>
                    </Link>
                </div>
                <p class="pt-1 text-slate-600">Browse and manage all coupons, their usage details, and associations with clinics</p>
            </div>
        </div>
    </AppLayout>
</template>
