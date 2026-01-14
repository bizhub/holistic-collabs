<script setup lang="ts">
import UnpaidCommissionsController from '@/actions/App/Http/Controllers/Admin/Commission/UnpaidCommissionsController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ChartNoAxesCombined, MoreHorizontal } from 'lucide-vue-next'

interface Props {
    clinics: Domain.Clinic.Data.ClinicData[]
}

defineProps<Props>()
</script>

<template>
    <Head title="Commissions" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight">Commissions</h1>
                <p class="pt-1 text-slate-600">New commissions will appear here when clients place orders.</p>
            </div>

            <div v-if="clinics.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-slate-200 bg-slate-50 text-xs font-medium text-slate-500 uppercase">
                                <td class="pl-5">Clinic</td>
                                <td class="pl-5">Contributions</td>
                                <td class="pl-5 text-right">Total unpaid</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="clinic in clinics" :key="clinic.id">
                                <tr class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <Link :href="UnpaidCommissionsController(clinic.id)" class="hover:underline">
                                                <p class="text-base leading-none font-medium text-slate-700">{{ clinic.name }}</p>
                                            </Link>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <div
                                                class="flex size-6 items-center justify-center bg-slate-200 text-sm leading-none font-medium text-slate-600">
                                                {{ clinic.commissions_count }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none text-slate-600">
                                                <span v-if="clinic.commissions_sum_amount">
                                                    ${{ (clinic.commissions_sum_amount / 100).toFixed(2) }}
                                                </span>
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
                                                        <Link :href="UnpaidCommissionsController(clinic.id)">
                                                            <DropdownMenuItem>View</DropdownMenuItem>
                                                        </Link>
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
