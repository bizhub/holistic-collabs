<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import { Tag, Truck } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    orders: Domain.Order.Data.OrderData[]
}

defineProps<Props>()

dayjs.extend(utc)
dayjs.extend(timezone)
</script>

<template>
    <Head title="Orders" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="orders" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Orders</h1>
                    <p class="pt-1 text-muted-foreground">View all orders placed through Shopify that include referral activity.</p>
                </div>
                <div></div>
            </div>

            <div v-if="orders.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Order</td>
                                <td class="pl-5">Date</td>
                                <td class="pl-5">Client</td>
                                <td class="pl-5">Coupon Used</td>
                                <td class="pr-10 pl-5">
                                    <div class="flex justify-end">Subtotal</div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="order in orders" :key="order.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">#{{ order.order_number }}</p>
                                    </td>
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ dayjs.utc(order.created_at).local().format('DD/MM/YYYY h:mma') }}
                                        </p>
                                    </td>
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">{{ order.client?.name }}</p>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="order.coupon_code" class="inline-block bg-zinc-200 px-3 py-1.5">
                                            <div class="flex items-center space-x-1">
                                                <Tag class="size-4 text-zinc-600" />
                                                <div class="text-sm font-medium text-zinc-600">{{ order.coupon_code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pr-10 pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none text-zinc-600">
                                                ${{
                                                    order.subtotal_price.toLocaleString(undefined, {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2,
                                                    })
                                                }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <Empty v-else class="border border-dashed">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <Truck />
                    </EmptyMedia>
                    <EmptyTitle>No orders yet</EmptyTitle>
                    <EmptyDescription>Orders will appear here once clients place purchases using your clinics referral coupons.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
