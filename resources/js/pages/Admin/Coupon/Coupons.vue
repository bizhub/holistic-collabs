<script setup lang="ts">
import ClinicCouponsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCouponsController'
import DeleteCouponController from '@/actions/App/Http/Controllers/Admin/Coupon/DeleteCouponController'
import DashboardIndexController from '@/actions/App/Http/Controllers/Admin/Dashboard/DashboardIndexController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { MoreHorizontal, Tag, Tags } from 'lucide-vue-next'

interface Props {
    coupons: Domain.Coupon.Data.CouponData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: DashboardIndexController().url,
    },
]

const deleteCoupon = (id: string) => {
    if (!confirm('Are you sure you want to delete this coupon?')) {
        return
    }

    router.delete(DeleteCouponController(id))
}
</script>

<template>
    <Head title="Coupons" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold tracking-tight text-foreground">Coupons</h1>
                </div>
                <p class="pt-1 text-muted-foreground">Browse and manage all coupons, their usage details, and associations with clinics</p>
            </div>

            <div v-if="coupons.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Coupon</td>
                                <td class="pl-5">Clinic</td>
                                <td class="pl-5">Commissions</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="coupon in coupons" :key="coupon.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <div class="inline-block bg-zinc-200 px-3 py-1.5">
                                            <div class="flex items-center space-x-1">
                                                <Tag class="size-4 text-zinc-600" />
                                                <div class="text-sm font-medium text-zinc-600">{{ coupon.code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <Link
                                            :href="ClinicCouponsController(coupon.clinic?.id ?? 'unknown')"
                                            class="text-sm leading-none text-foreground hover:underline">
                                            {{ coupon.clinic?.name }}
                                        </Link>
                                    </td>
                                    <td class="pl-5">
                                        <div
                                            class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium text-zinc-600">
                                            {{ coupon.commissions_count }}
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
                                                    <!-- <DropdownMenuGroup>
                                                        <DropdownMenuItem>Edit</DropdownMenuItem>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator /> -->
                                                    <DropdownMenuItem @click="deleteCoupon(coupon.id)">Delete</DropdownMenuItem>
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
                        <Tags />
                    </EmptyMedia>
                    <EmptyTitle>No Coupons</EmptyTitle>
                    <EmptyDescription>Assign discount codes from Shopify to existing clinics.</EmptyDescription>
                </EmptyHeader>
                <!-- <EmptyContent>
                    <Link :href="CreateClinicController()">
                        <Button variant="outline" size="sm">
                            <Plus />
                            Add Clinic
                        </Button>
                    </Link>
                </EmptyContent> -->
            </Empty>
        </div>
    </AppLayout>
</template>
