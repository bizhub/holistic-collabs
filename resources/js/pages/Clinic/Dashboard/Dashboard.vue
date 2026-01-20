<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { ChartNoAxesCombined, Handshake, Truck } from 'lucide-vue-next'

interface Props {
    auth: {
        clinic: {
            name: string
        }
    }

    client_count: number
    commission_count: number
    commission_earned: number
    commissions: Domain.Commission.Data.CommissionData[]

    payouts: Domain.Commission.Data.PayoutData[]
    upcoming_payout_amount: number

    commission_percentage_change?: number
}

defineProps<Props>()
</script>

<template>
    <Head title="Overview" />

    <ClinicLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Overview</h1>
                    </div>
                    <p class="pt-1 text-muted-foreground">Earn commissions through orders using your coupon codes</p>
                </div>
                <div></div>
            </div>

            <div class="mb-6 grid grid-cols-3 gap-6">
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">referrals</h6>
                        <span class="text-3xl font-semibold">{{ client_count }}</span>
                        <!-- <span class="ml-2 inline-block rounded-md bg-green-100 px-2 py-px text-xs text-green-500">+3.1%</span> -->
                    </div>
                    <div>
                        <Handshake class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">commissions</h6>
                        <span class="text-3xl font-semibold">{{ commission_count }}</span>
                        <span v-if="commission_percentage_change" class="ml-2 inline-block rounded-md bg-green-100 px-2 py-px text-xs text-green-500">
                            +{{ commission_percentage_change }}%
                        </span>
                    </div>
                    <div>
                        <ChartNoAxesCombined class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">Upcoming payout</h6>
                        <span class="text-3xl font-semibold">${{ upcoming_payout_amount.toFixed(2) }}</span>
                        <!-- <span class="ml-2 inline-block rounded-md bg-green-100 px-2 py-px text-xs text-green-500">+3.1%</span> -->
                    </div>
                    <div>
                        <Truck class="size-12 text-zinc-200" />
                    </div>
                </div>
            </div>

            <div v-if="payouts.length > 0" class="w-full">
                <div class="mb-4 flex items-center">
                    <div class="flex-1">
                        <div class="flex items-center space-x-6">
                            <h1 class="text-xl font-medium tracking-tight">Payouts</h1>
                        </div>
                        <!-- <p class="pt-1 text-muted-foreground">Earn commissions through orders using your coupon codes.</p> -->
                    </div>
                    <div></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <!-- <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Paid On</td>
                                <td class="pl-5"></td>
                                <td class="pl-5"></td>
                                <td class="pr-10 pl-5">
                                    <div class="flex justify-end">Amount</div>
                                </td>
                            </tr>
                        </thead> -->
                        <tbody>
                            <template v-for="payout in payouts" :key="payout.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ dayjs(payout.paid_at).format('DD MMM YYYY') }}
                                        </p>
                                    </td>
                                    <td class="pl-5">
                                        <!-- <div v-if="order.clinic" class="flex items-center">
                                            <p class="text-sm leading-none text-zinc-600">{{ order.clinic.name }}</p>
                                        </div> -->
                                        <!-- <Badge variant="secondary">Paid</Badge> -->
                                    </td>
                                    <td class="pl-5">
                                        <!-- <div v-if="order.coupon_code" class="inline-block bg-zinc-200 px-3 py-1.5">
                                            <div class="flex items-center space-x-1">
                                                <Tag class="size-4 text-zinc-600" />
                                                <div class="text-sm font-medium text-zinc-600">{{ order.coupon_code }}</div>
                                            </div>
                                        </div> -->
                                    </td>
                                    <td class="pr-10 pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none">${{ payout.total_amount.toFixed(2) }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <Empty v-else class="border">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <Handshake />
                    </EmptyMedia>
                    <EmptyTitle>No payouts yet</EmptyTitle>
                    <EmptyDescription>Earn commissions through orders using your coupon codes.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </ClinicLayout>
</template>
