<script setup lang="ts">
import ClinicPayoutsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicPayoutsController'
import DeletePayoutController from '@/actions/App/Http/Controllers/Admin/Payout/DeletePayoutController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import { HandCoins, MoreHorizontal } from 'lucide-vue-next'

interface Props {
    payouts: Domain.Commission.Data.PayoutData[]
}

defineProps<Props>()

dayjs.extend(utc)
dayjs.extend(timezone)

const deletePayout = (id: string) => {
    if (!confirm('Are you sure you want to delete this payout?')) {
        return
    }

    router.delete(DeletePayoutController(id))
}
</script>

<template>
    <Head title="Payouts" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight">Payouts</h1>
                <p class="pt-1 text-muted-foreground">View all clinic payouts and their statuses.</p>
            </div>

            <div v-if="payouts.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Date</td>
                                <td class="pl-5">Clinic</td>
                                <!-- <td class="pl-5">Contributions</td> -->
                                <td class="pl-5 text-right">Amount</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="payout in payouts" :key="payout.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ dayjs.utc(payout.created_at).local().format('DD/MM/YYYY') }}
                                        </p>
                                    </td>
                                    <td class="pl-5">
                                        <Link
                                            :href="ClinicPayoutsController(payout.clinic?.id ?? 'unknown')"
                                            class="text-sm leading-none hover:underline">
                                            {{ payout.clinic?.name }}
                                        </Link>
                                    </td>
                                    <!-- <td class="pl-5">
                                        <div class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium">
                                            {{ payout.total_amount }}
                                        </div>
                                    </td> -->
                                    <td class="pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none">
                                                <span v-if="payout.total_amount"> ${{ payout.total_amount.toFixed(2) }} </span>
                                                <span v-else>-</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-4">
                                        <div class="flex justify-end pr-4">
                                            <DropdownMenu>
                                                <DropdownMenuTrigger as-child>
                                                    <Button variant="secondary" size="sm" aria-label="Options">
                                                        <MoreHorizontal />
                                                    </Button>
                                                </DropdownMenuTrigger>
                                                <DropdownMenuContent class="w-56" align="end">
                                                    <DropdownMenuGroup>
                                                        <!-- <Link :href="CreatePayoutController(clinic.id)">
                                                            <DropdownMenuItem>Create Payout</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicCommissionsController(clinic.id)">
                                                            <DropdownMenuItem>View</DropdownMenuItem>
                                                        </Link> -->
                                                    </DropdownMenuGroup>
                                                    <!-- <DropdownMenuSeparator /> -->
                                                    <DropdownMenuItem @click="deletePayout(payout.id)">Delete</DropdownMenuItem>
                                                </DropdownMenuContent>
                                            </DropdownMenu>
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
                        <HandCoins />
                    </EmptyMedia>
                    <EmptyTitle>No payouts</EmptyTitle>
                    <EmptyDescription>Payouts for clinics will appear here after processing.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
