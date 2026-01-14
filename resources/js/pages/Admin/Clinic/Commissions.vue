<script setup lang="ts">
import ClinicCommissionsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCommissionsController'
import ClinicInvitesController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicInvitesController'
import ClinicUsersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicUsersController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { Handshake, Zap } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    commissions: Domain.Commission.Data.CommissionData[]
}

defineProps<Props>()
</script>

<template>
    <Head title="Clinic Commissions" />

    <AppLayout>
        <!-- <SettingsLayout> -->
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="mb-4 flex items-center">
                    <div class="flex-1">
                        <div>
                            <h1 class="text-3xl font-bold tracking-tight">
                                <span>{{ clinic.name }}</span>
                            </h1>
                        </div>
                        <!-- <p class="pt-1 text-zinc-600">New commissions will appear here when clients place orders.</p> -->
                    </div>
                    <div>
                        <Button variant="secondary">
                            <!-- <Zap /> -->
                            <span>Edit Clinic</span>
                        </Button>
                    </div>
                </div>
                <div class="flex items-center space-x-8 border-b border-zinc-200">
                    <Link :href="ClinicCommissionsController(clinic.id)" class="-mb-0.5 border-b-4 border-primary pb-2 text-zinc-600">
                        Commissions
                    </Link>
                    <Link :href="ClinicUsersController(clinic.id)" class="pb-2.5 text-zinc-600">Users</Link>
                    <Link :href="ClinicInvitesController(clinic.id)" class="pb-2.5 text-zinc-600">Invites</Link>
                    <div class="pb-2.5 text-zinc-600">Coupons</div>
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <div class="flex-1">
                        <div>
                            <h1 class="text-2xl tracking-tight">Commissions</h1>
                        </div>
                    </div>
                    <div>
                        <Button size="sm" variant="secondary">
                            <Zap />
                            <span>Mark all as Paid</span>
                        </Button>
                    </div>
                </div>
            </div>

            <!-- <div class="mb-6 grid grid-cols-3 gap-6">
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-zinc-500 uppercase">referrals</h6>
                        <span class="text-3xl font-semibold">{{ 0 }}</span>
                    </div>
                    <div>
                        <Handshake class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-zinc-500 uppercase">commissions</h6>
                        <span class="text-3xl font-semibold">{{ 0 }}</span>
                    </div>
                    <div>
                        <ChartNoAxesCombined class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-zinc-500 uppercase">commission earned</h6>
                        <span class="text-3xl font-semibold">${{ (550 / 100).toFixed(2) }}</span>
                    </div>
                    <div>
                        <Truck class="size-12 text-zinc-200" />
                    </div>
                </div>
            </div> -->

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
        <!-- </SettingsLayout> -->
    </AppLayout>
</template>
