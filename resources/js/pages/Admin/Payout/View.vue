<script setup lang="ts">
import DeletePayoutController from '@/actions/App/Http/Controllers/Admin/Payout/DeletePayoutController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import { Handshake } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    commissions: Domain.Commission.Data.CommissionData[]
    payout: Domain.Commission.Data.PayoutData
}

const props = defineProps<Props>()

dayjs.extend(utc)
dayjs.extend(timezone)

const total = computed(() => {
    return props.commissions.reduce((sum, commission) => {
        return sum + Number(commission.amount)
    }, 0)
})

const deletePayout = () => {
    if (!confirm('Are you sure you want to delete this payout?')) {
        return
    }

    router.delete(DeletePayoutController(props.payout.id))
}
</script>

<template>
    <Head title="View Payout" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="payouts" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Payout</h1>
                    <p class="pt-1 text-muted-foreground">View payout details, including amounts, dates, and related commissions.</p>
                </div>
                <div>
                    <Button @click="deletePayout" variant="secondary" size="sm">Delete</Button>
                </div>
            </div>

            <div class="flex items-start gap-6">
                <div class="flex-1">
                    <div v-if="commissions.length > 0" class="w-full">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                        <td class="pl-5">Date</td>
                                        <td class="pl-5">Client</td>
                                        <td class="pr-10 pl-5">
                                            <div class="flex justify-end">Commission</div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="commission in commissions" :key="commission.id">
                                        <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                            <td>
                                                <div class="flex items-center pl-5">
                                                    <p class="text-sm leading-none">
                                                        {{ dayjs.utc(commission.created_at).local().format('DD/MM/YYYY h:mma') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-5">
                                                <p class="text-sm leading-none">
                                                    {{ commission.client?.name }}
                                                </p>
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

                    <Empty v-else class="border border-zinc-200">
                        <EmptyHeader>
                            <EmptyMedia variant="icon">
                                <Handshake />
                            </EmptyMedia>
                            <EmptyTitle>No commissions yet</EmptyTitle>
                            <EmptyDescription>Earn commissions through orders using your coupon codes.</EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                </div>
                <div class="w-96">
                    <div class="w-full border border-zinc-200 p-4">
                        <div class="h-32">
                            <div class="flex items-center pb-2">
                                <div class="flex-1 text-muted-foreground">Clinic</div>
                                <div>{{ clinic.name }}</div>
                            </div>
                            <div class="flex items-center pb-2">
                                <div class="flex-1 text-muted-foreground">Paid at</div>
                                <div>{{ dayjs(payout.paid_at).format('DD/MM/YYYY hh:mma') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center border-t border-zinc-200 pt-4">
                            <div class="flex-1 text-muted-foreground">Total</div>
                            <div>${{ total.toFixed(2) }} <span class="text-zinc-600">NZD</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
