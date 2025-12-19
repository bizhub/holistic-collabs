<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { MoreHorizontal, Tag, Truck } from 'lucide-vue-next'

interface Props {
    orders: Domain.Order.Data.OrderData[]
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
    <Head title="Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Orders</h1>
                    </div>
                    <p class="pt-1 text-slate-600">View all orders placed through Shopify that include referral activity.</p>
                </div>
                <div></div>
            </div>

            <div v-if="orders.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-slate-200 bg-slate-50 text-xs font-medium text-slate-500 uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Clinic</td>
                                <td class="pl-5">Coupon</td>
                                <td class="pl-5">
                                    <div class="flex justify-end">Subtotal</div>
                                </td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="order in orders" :key="order.id">
                                <tr class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-base leading-none font-medium text-slate-700">{{ order.client?.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="order.clinic" class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">{{ order.clinic.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="order.coupon_code" class="inline-block bg-slate-200 px-3 py-1.5">
                                            <div class="flex items-center space-x-1">
                                                <Tag class="size-4 text-slate-600" />
                                                <div class="text-sm font-medium text-slate-600">{{ order.coupon_code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center justify-end">
                                            <p class="text-sm leading-none text-slate-600">
                                                ${{
                                                    order.subtotal_price.toLocaleString(undefined, {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2,
                                                    })
                                                }}
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
                                                        <DropdownMenuItem>View</DropdownMenuItem>
                                                        <DropdownMenuItem>Edit</DropdownMenuItem>
                                                        <!-- <DropdownMenuItem>Add Coupon</DropdownMenuItem> -->
                                                    </DropdownMenuGroup>
                                                    <!-- <DropdownMenuSeparator /> -->
                                                    <!-- <DropdownMenuItem @click="deleteClinic(clinic.id)">Delete</DropdownMenuItem> -->
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
                        <Truck />
                    </EmptyMedia>
                    <EmptyTitle>No orders yet</EmptyTitle>
                    <EmptyDescription>Orders will appear here once clients place purchases using your clinics referral coupons.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
