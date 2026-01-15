<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { Handshake, Zap } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    commissions: Domain.Commission.Data.CommissionData[]
}

defineProps<Props>()
</script>

<template>
    <Head title="Commissions" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="commissions" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Commissions</h1>
                    <p class="pt-1 text-zinc-600">New commissions will appear here when clients place orders.</p>
                </div>
                <div>
                    <Button size="sm" v-if="commissions.length > 0">
                        <Zap />
                        <span>Mark all as Paid</span>
                    </Button>
                </div>
            </div>

            <div v-if="commissions.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-zinc-500 uppercase">
                                <td class="pl-5">Date</td>
                                <td class="pl-5"></td>
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
                                            <p class="text-sm leading-none text-zinc-600">
                                                {{ dayjs(commission.created_at).format('DD/MM/YYYY h:mma') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <!-- <div v-if="order.clinic" class="flex items-center">
                                            <p class="text-sm leading-none text-zinc-600">{{ order.clinic.name }}</p>
                                        </div> -->
                                        <Badge variant="secondary">{{ commission.status }}</Badge>
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
                                            <p class="text-sm leading-none text-zinc-600">${{ commission.amount.toFixed(2) }}</p>
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
