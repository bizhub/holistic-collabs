<script setup lang="ts">
import ClinicIndexController from '@/actions/App/Http/Controllers/Clinic/ClinicIndexController'
import CreateClinicController from '@/actions/App/Http/Controllers/Clinic/CreateClinicController'
import DeleteClinicController from '@/actions/App/Http/Controllers/Clinic/DeleteClinicController'
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
                        <h1 class="text-3xl font-bold tracking-tight">Clinics</h1>
                    </div>
                    <p class="pt-1 text-slate-600">Manage and view all clinics in the system, including key details and linked coupons</p>
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
                        <tbody>
                            <template v-for="clinic in clinics" :key="clinic.id">
                                <tr class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-base leading-none font-medium text-slate-700">{{ clinic.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="ml-2 text-sm leading-none text-slate-600">
                                                {{ clinic.clients_count }} {{ clinic.clients_count === 1 ? 'Client' : 'Clients' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="ml-2 text-sm leading-none text-slate-600">
                                                {{ clinic.commissions_count }} {{ clinic.commissions_count === 1 ? 'Commission' : 'Commissions' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="clinic.coupons">
                                            <div v-for="coupon in clinic.coupons" :key="coupon.id" class="inline-block bg-slate-200 px-3 py-1.5">
                                                <div class="flex items-center space-x-1">
                                                    <Tag class="size-4 text-slate-600" />
                                                    <div class="text-sm font-medium text-slate-600">{{ coupon.code }}</div>
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
                                                        <DropdownMenuItem disabled>View</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Edit</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Add Coupon</DropdownMenuItem>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator />
                                                    <DropdownMenuItem @click="deleteClinic(clinic.id)">Delete</DropdownMenuItem>
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
