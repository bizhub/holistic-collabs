<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { ChartNoAxesCombined, Plug } from 'lucide-vue-next'

interface Props {
    commissions: Domain.Commission.Data.CommissionGroupData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
]
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
                <!-- <div class="items-center justify-between sm:flex">
                        <div class="flex items-center">
                            <a
                                class="rounded-full focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none"
                                href=" javascript:void(0)">
                                <div class="bg-primary-100 px-3 py-1 text-sm font-medium text-primary-700">
                                    <p>All</p>
                                </div>
                            </a>
                            <a
                                class="ml-2 bg-slate-100 focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none sm:ml-2"
                                href="javascript:void(0)">
                                <div class="px-3 py-1 text-sm font-medium text-slate-600 hover:bg-primary-100 hover:text-primary-700">
                                    <p>Active</p>
                                </div>
                            </a>
                            <a
                                class="ml-2 bg-slate-100 focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none sm:ml-2"
                                href="javascript:void(0)">
                                <div class="px-3 py-1 text-sm font-medium text-slate-600 hover:bg-primary-100 hover:text-primary-700">
                                    <p>Pending</p>
                                </div>
                            </a>
                        </div>
                    </div> -->
                <div class="mt-2 overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <tbody>
                            <template v-for="group in commissions" :key="group.clinic.id">
                                <tr class="h-16 rounded border border-slate-200 bg-slate-50 hover:bg-slate-100 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-base leading-none text-slate-700">{{ group.clinic.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-24">
                                        <Badge variant="secondary">Pending</Badge>
                                    </td>
                                    <td class="pl-5"></td>
                                    <td class="pl-5"></td>

                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <!-- <Users class="size-4 text-slate-400" /> -->
                                            <p class="ml-2 text-sm leading-none text-slate-600"><span class="font-semibold">1</span> Commission</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <!-- <button class="rounded bg-red-100 px-3 py-3 text-sm leading-none text-red-700 focus:outline-none">
                                            Due today at 18:00
                                        </button> -->
                                    </td>
                                    <td class="pl-4">
                                        <div class="flex justify-end pr-4">
                                            <Button variant="outline" size="sm">View</Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    v-for="commission in group.commissions"
                                    :key="commission.id"
                                    class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td class="">
                                        <div class="flex items-center pl-5">
                                            <!-- <p class="mr-2 text-base leading-none text-slate-700">{{ commission.amount }}</p> -->
                                        </div>
                                    </td>
                                    <td class="pl-24">
                                        <!-- <Badge variant="secondary">Pending</Badge> -->
                                    </td>
                                    <td class="pl-5"></td>
                                    <td class="pl-5"></td>
                                    <td class="pl-5">
                                        <div class="flex items-center justify-end">
                                            <!-- <Users class="size-4 text-slate-400" /> -->
                                            <p class="ml-2 text-sm leading-none text-slate-600">${{ commission.amount.toFixed(2) }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5"></td>
                                    <td class="pl-4">
                                        <div class="flex justify-end pr-4">
                                            <!-- <Button variant="outline" size="sm">View</Button> -->
                                        </div>
                                    </td>
                                </tr>
                                <tr class="h-4"></tr>
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
