<script setup lang="ts">
import DashboardIndexController from '@/actions/App/Http/Controllers/Admin/Dashboard/DashboardIndexController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { MoreHorizontal, Plus, Users } from 'lucide-vue-next'

interface Props {
    users: Domain.User.Data.UserData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: DashboardIndexController().url,
    },
]
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Users</h1>
                    </div>
                    <p class="pt-1 text-slate-600">Manage the login accounts for your clinics.</p>
                </div>
                <div>
                    <!-- <Link :href="CreateClinicController()"> -->
                    <Button size="lg">
                        <Plus />
                        <span>Add User</span>
                    </Button>
                    <!-- </Link> -->
                </div>
            </div>

            <div v-if="users.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-slate-200 bg-slate-50 text-xs font-medium text-slate-500 uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Email</td>
                                <td class="pl-5">Clinic</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="user in users" :key="user.id">
                                <tr class="h-16 border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-sm leading-none text-slate-600">{{ user.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">
                                                {{ user.email }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">
                                                <span v-if="user.is_admin"> Admin </span>
                                                <span v-else-if="user.clinic">
                                                    {{ user.clinic.name }}
                                                </span>
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
                                                        <!-- <Link :href="EditClinicController(clinic.id)">
                                                            <DropdownMenuItem>Edit</DropdownMenuItem>
                                                        </Link> -->
                                                        <DropdownMenuItem disabled>Edit</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Change Clinic</DropdownMenuItem>
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
                        <Users />
                    </EmptyMedia>
                    <EmptyTitle>No user accounts</EmptyTitle>
                    <EmptyDescription>Create a login account so a clinic can access their referrals and commissions.</EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <!-- <Link :href="CreateClinicController()"> -->
                    <Button variant="outline" size="sm">
                        <Plus />
                        Add User
                    </Button>
                    <!-- </Link> -->
                </EmptyContent>
            </Empty>
        </div>
    </AppLayout>
</template>
