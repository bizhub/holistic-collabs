<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Truck } from 'lucide-vue-next'

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
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Orders</h1>
                    </div>
                    <p class="pt-1 text-slate-600">View all orders placed through Shopify that include referral activity.</p>
                </div>
                <div></div>
            </div>

            <Empty class="border border-dashed">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <Truck />
                    </EmptyMedia>
                    <EmptyTitle>No orders yet</EmptyTitle>
                    <EmptyDescription>Orders will appear here once clients place purchases using your clinics’ referral coupons.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
