<script setup lang="ts">
import CreatePayoutController from '@/actions/App/Http/Controllers/Admin/Payout/CreatePayoutController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import { HandCoins, Handshake } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    commissions: Domain.Commission.Data.CommissionData[]
}

defineProps<Props>()

dayjs.extend(utc)
dayjs.extend(timezone)
</script>

<template>
    <Head title="Commissions" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="commissions" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Commissions</h1>
                    <p class="pt-1 text-muted-foreground">New commissions will appear here when clients place orders.</p>
                </div>
                <div>
                    <Link :href="CreatePayoutController(clinic.id)">
                        <Button v-if="commissions.length > 0">
                            <HandCoins />
                            <span>Create Payout</span>
                        </Button>
                    </Link>
                </div>
            </div>

            <div v-if="commissions.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Date</td>
                                <td class="pl-5">Order</td>
                                <td class="pl-5">Client</td>
                                <td class="pl-5"></td>
                                <td class="pr-10 pl-5">
                                    <div class="flex justify-end">Commission Amount</div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="commission in commissions" :key="commission.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ dayjs.utc(commission.created_at).local().format('DD/MM/YYYY h:mma') }}
                                        </p>
                                    </td>
                                    <td class="pl-5">
                                        <p v-if="commission.order" class="text-sm leading-none">#{{ commission.order.order_number }}</p>
                                    </td>
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ commission.client?.name }}
                                        </p>
                                    </td>
                                    <td class="pl-5">
                                        <Badge v-if="commission.payout !== null" variant="default">Paid</Badge>
                                        <Badge v-else variant="secondary">Pending</Badge>
                                    </td>
                                    <td class="pr-10 pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none">${{ commission.amount.toFixed(2) }}</p>
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
                        <Handshake />
                    </EmptyMedia>
                    <EmptyTitle>No commissions yet</EmptyTitle>
                    <EmptyDescription>Earn commissions through orders using your coupon codes.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
