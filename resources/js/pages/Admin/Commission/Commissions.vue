<script setup lang="ts">
import DashboardIndexController from '@/actions/App/Http/Controllers/Admin/Dashboard/DashboardIndexController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { ChartNoAxesCombined, MoreHorizontal, Plug } from 'lucide-vue-next'

interface Props {
    commissions: Domain.Commission.Data.CommissionGroupData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: DashboardIndexController().url,
    },
]

const calcCommissionsTotal = (commissions: Domain.Commission.Data.CommissionData[]) => {
    return commissions.reduce((total, commission) => {
        return total + commission.amount
    }, 0)
}
</script>

<template>
    <Head title="Coupons" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold tracking-tight">Commissions</h1>
                    <Link :href="'/asd'">
                        <Button size="sm"><Plug />Connect</Button>
                    </Link>
                </div>
                <p class="pt-1 text-slate-600">New commissions will appear here when clients place orders.</p>
            </div>

            <div v-if="commissions.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-slate-200 bg-slate-50 text-xs font-medium text-slate-500 uppercase">
                                <td class="pl-5">Clinic</td>
                                <!-- <td class="pl-5">Email</td>
                                <td class="pl-5">Clinic</td> -->
                                <td class="pl-5">Contributions</td>
                                <td class="pl-5">Total unpaid</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="commission in commissions" :key="commission.clinic.id">
                                <tr class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-base leading-none font-medium text-slate-700">{{ commission.clinic.name }}</p>
                                        </div>
                                    </td>
                                    <!-- <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">{{ commission.email }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">{{ commission.clinic?.name }}</p>
                                        </div>
                                    </td> -->
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <div
                                                class="flex size-6 items-center justify-center bg-slate-200 text-sm leading-none font-medium text-slate-600">
                                                {{ commission.commissions.length }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">
                                                ${{ calcCommissionsTotal(commission.commissions).toFixed(2) }}
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
                                                        <DropdownMenuItem disabled>View</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Edit</DropdownMenuItem>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator />
                                                    <DropdownMenuItem disabled>Delete</DropdownMenuItem>
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
                        <ChartNoAxesCombined />
                    </EmptyMedia>
                    <EmptyTitle>You're all caught up</EmptyTitle>
                    <EmptyDescription>There are currently no unpaid commissions to review.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
