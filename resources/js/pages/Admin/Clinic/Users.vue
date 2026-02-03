<script setup lang="ts">
import DeleteUserController from '@/actions/App/Http/Controllers/Admin/User/DeleteUserController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { MoreHorizontal, UsersIcon } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    users: Domain.User.Data.UserData[]
}

defineProps<Props>()

const deleteUser = (id: string) => {
    if (!confirm('Are you sure you want to delete this user?')) {
        return
    }

    router.delete(DeleteUserController(id).url)
}
</script>

<template>
    <Head title="Users" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="users" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Users</h1>
                    <p class="pt-1 text-muted-foreground">Manage the login accounts for your clinics.</p>
                </div>
                <div>
                    <!-- <Link :href="CreateInviteController()">
                        <Button>
                            <Plus />
                            <span>Create user</span>
                        </Button>
                    </Link> -->
                </div>
            </div>

            <div v-if="users.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Email</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="user in users" :key="user.id">
                                <tr class="h-16 border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">{{ user.name }}</p>
                                    </td>
                                    <td class="pl-5">
                                        <p class="text-sm leading-none">
                                            {{ user.email }}
                                        </p>
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
                                                        <DropdownMenuItem disabled>View</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Edit</DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Change Clinic</DropdownMenuItem>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator /> -->
                                                    <DropdownMenuItem @click="deleteUser(user.id)">Delete</DropdownMenuItem>
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
                        <UsersIcon />
                    </EmptyMedia>
                    <EmptyTitle>No user accounts</EmptyTitle>
                    <EmptyDescription>Create a login account so a clinic can access their referrals and commissions.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
