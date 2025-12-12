<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { HandshakeIcon } from 'lucide-vue-next'

// interface Props {
//     commissions: Domain.Commission.Data.CommissionGroupData[]
// }

// defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
]
</script>

<template>
    <Head title="Clients" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Clients</h1>
                    </div>
                    <p class="pt-1 text-slate-600">
                        See all clients created through your referral system. Track referred customers, their associated clinics, and their order
                        activity.
                    </p>
                </div>
                <div></div>
            </div>

            <Empty class="border border-dashed">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <HandshakeIcon />
                    </EmptyMedia>
                    <EmptyTitle>No clients</EmptyTitle>
                    <EmptyDescription>Clients appear automatically when new referred orders come through your Shopify store.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
