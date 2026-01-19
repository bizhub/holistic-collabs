<script setup lang="ts">
import StorePayoutController from '@/actions/App/Http/Controllers/Admin/Payout/StorePayoutController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { Handshake } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    commissions: Domain.Commission.Data.CommissionData[]
    paid_until: string
}

const props = defineProps<Props>()

const total = computed(() => {
    return props.commissions.reduce((sum, commission) => {
        return sum + Number(commission.amount)
    }, 0)
})

const createPayout = () => {
    router.post(StorePayoutController(props.clinic.id), {
        paid_until: props.paid_until,
    })
}
</script>

<template>
    <Head title="Create Payout" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="payouts" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Create Payout</h1>
                    <p class="pt-1 text-muted-foreground">Check which commissions will be included before creating the payout.</p>
                </div>
                <div></div>
            </div>

            <div class="flex items-start gap-6">
                <div class="flex-1">
                    <div v-if="commissions.length > 0" class="w-full">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-zinc-500 uppercase">
                                        <td class="pl-5">Date</td>
                                        <td class="pl-5"></td>
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
                                                        {{ dayjs(commission.created_at).format('DD/MM/YYYY h:mma') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="pl-5"></td>
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
                        <div class="h-32"></div>
                        <div class="flex items-center border-t border-zinc-200 py-4">
                            <div class="flex-1">Total</div>
                            <div>${{ total.toFixed(2) }} <span>NZD</span></div>
                        </div>
                        <Button size="lg" class="w-full" :disabled="total <= 0" @click="createPayout">Create Payout</Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
