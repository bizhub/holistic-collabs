<script setup lang="ts">
import ClinicClientsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicClientsController'
import ClinicCommissionsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCommissionsController'
import ClinicCouponsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCouponsController'
import ClinicIndexController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicIndexController'
import ClinicInvitesController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicInvitesController'
import ClinicOrdersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicOrdersController'
import ClinicPayoutsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicPayoutsController'
import ClinicUsersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicUsersController'
import CreateClinicController from '@/actions/App/Http/Controllers/Admin/Clinic/CreateClinicController'
import DeleteClinicController from '@/actions/App/Http/Controllers/Admin/Clinic/DeleteClinicController'
import EditClinicController from '@/actions/App/Http/Controllers/Admin/Clinic/EditClinicController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { MoreHorizontal, Plus, Store, Tag } from 'lucide-vue-next'

interface Props {
    clinics: Domain.Clinic.Data.ClinicData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clinics',
        href: ClinicIndexController().url,
    },
]

const deleteClinic = (id: string) => {
    if (!confirm('Are you sure you want to delete this Clinic?')) {
        return
    }

    router.delete(DeleteClinicController(id))
}
</script>

<template>
    <Head title="Clinics" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight text-foreground">Clinics</h1>
                    </div>
                    <p class="pt-1 text-muted-foreground">Manage and view all clinics in the system, including key details and linked coupons</p>
                </div>
                <div>
                    <Link :href="CreateClinicController()">
                        <Button size="lg">
                            <Plus />
                            <span>Add Clinic</span>
                        </Button>
                    </Link>
                </div>
            </div>

            <div v-if="clinics.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Clients</td>
                                <td class="pl-5">Commissions</td>
                                <td class="pl-5">Users</td>
                                <td class="pl-5">Coupons</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="clinic in clinics" :key="clinic.id">
                                <tr class="h-16 border border-zinc-200 hover:bg-muted/50 focus:outline-none">
                                    <td>
                                        <Link
                                            :href="ClinicCommissionsController(clinic.id)"
                                            class="pl-5 text-sm leading-none text-foreground hover:underline">
                                            {{ clinic.name }}
                                        </Link>
                                    </td>
                                    <td class="pl-5">
                                        <div
                                            class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium text-zinc-600">
                                            {{ clinic.clients_count }}
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div
                                            class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium text-zinc-600">
                                            {{ clinic.commissions_count }}
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div
                                            class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium text-zinc-600">
                                            {{ clinic.users_count }}
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="clinic.coupons">
                                            <div v-for="coupon in clinic.coupons" :key="coupon.id" class="inline-block bg-zinc-200 px-3 py-1.5">
                                                <div class="flex items-center space-x-1">
                                                    <Tag class="size-4 text-zinc-600" />
                                                    <div class="text-sm font-medium text-zinc-600">{{ coupon.code }}</div>
                                                </div>
                                            </div>
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
                                                        <Link :href="ClinicCommissionsController(clinic.id)">
                                                            <DropdownMenuItem>Commissions</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicPayoutsController(clinic.id)">
                                                            <DropdownMenuItem>Payouts</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicUsersController(clinic.id)">
                                                            <DropdownMenuItem>Users</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicInvitesController(clinic.id)">
                                                            <DropdownMenuItem>Invites</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicClientsController(clinic.id)">
                                                            <DropdownMenuItem>Clients</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicCouponsController(clinic.id)">
                                                            <DropdownMenuItem>Coupons</DropdownMenuItem>
                                                        </Link>
                                                        <Link :href="ClinicOrdersController(clinic.id)">
                                                            <DropdownMenuItem>Orders</DropdownMenuItem>
                                                        </Link>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator />

                                                    <DropdownMenuGroup>
                                                        <Link :href="EditClinicController(clinic.id)">
                                                            <DropdownMenuItem>Edit</DropdownMenuItem>
                                                        </Link>
                                                        <DropdownMenuItem @click="deleteClinic(clinic.id)">Delete</DropdownMenuItem>
                                                    </DropdownMenuGroup>
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
                        <Store />
                    </EmptyMedia>
                    <EmptyTitle>No Clinics</EmptyTitle>
                    <EmptyDescription>Add your first clinic to manage coupons, commissions, and client referrals.</EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <Link :href="CreateClinicController()">
                        <Button variant="outline" size="sm">
                            <Plus />
                            Add Clinic
                        </Button>
                    </Link>
                </EmptyContent>
            </Empty>
        </div>
    </AppLayout>
</template>
