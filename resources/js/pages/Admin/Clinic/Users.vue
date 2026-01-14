<script setup lang="ts">
import ClinicCommissionsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCommissionsController'
import ClinicInvitesController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicInvitesController'
import ClinicUsersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicUsersController'
import EditClinicController from '@/actions/App/Http/Controllers/Admin/Clinic/EditClinicController'
import CreateInviteController from '@/actions/App/Http/Controllers/Admin/Invite/CreateInviteController'
import DeleteUserController from '@/actions/App/Http/Controllers/Admin/User/DeleteUserController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { MoreHorizontal, Plus, UsersIcon } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
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
    <Head title="Invites" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="mb-4 flex items-center">
                    <div class="flex-1">
                        <div>
                            <h1 class="text-3xl font-bold tracking-tight">
                                <span>{{ clinic.name }}</span>
                            </h1>
                        </div>
                        <!-- <p class="pt-1 text-zinc-600">New commissions will appear here when clients place orders.</p> -->
                    </div>
                    <div>
                        <Link :href="EditClinicController(clinic.id)">
                            <Button variant="secondary">
                                <span>Edit Clinic</span>
                            </Button>
                        </Link>
                    </div>
                </div>
                <div class="flex items-center space-x-8 border-b border-zinc-200">
                    <Link :href="ClinicCommissionsController(clinic.id)" class="pb-2.5 text-zinc-600">Commissions</Link>
                    <Link :href="ClinicUsersController(clinic.id)" class="-mb-0.5 border-b-4 border-primary pb-2 text-zinc-600">Users</Link>
                    <Link :href="ClinicInvitesController(clinic.id)" class="pb-2.5 text-zinc-600">Invites</Link>
                    <div class="pb-2.5 text-zinc-600">Coupons</div>
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <div class="flex-1">
                        <h1 class="text-2xl tracking-tight">Users</h1>
                    </div>
                    <div>
                        <Link :href="CreateInviteController()">
                            <Button size="sm">
                                <Plus />
                                <span>Create user</span>
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>

            <div v-if="users.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-zinc-500 uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Email</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="user in users" :key="user.id">
                                <tr class="h-16 border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-sm leading-none text-zinc-600">{{ user.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-zinc-600">
                                                {{ user.email }}
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
