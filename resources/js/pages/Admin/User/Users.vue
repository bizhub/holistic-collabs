<script setup lang="ts">
import DashboardIndexController from '@/actions/App/Http/Controllers/Admin/Dashboard/DashboardIndexController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Plus, Users } from 'lucide-vue-next'

// interface Props {
//     commissions: Domain.Commission.Data.CommissionGroupData[]
// }

// defineProps<Props>()

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

            <Empty class="border border-dashed">
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
