<script setup lang="ts">
import ClinicCommissionsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCommissionsController'
import ClinicInvitesController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicInvitesController'
import ClinicUsersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicUsersController'
import CreateInviteController from '@/actions/App/Http/Controllers/Admin/Invite/CreateInviteController'
import DeleteUserController from '@/actions/App/Http/Controllers/Admin/User/DeleteUserController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ChevronRight, ChevronsUpDown, MoreHorizontal, Plus, UsersIcon } from 'lucide-vue-next'

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
    <Head title="Invites" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex flex-1 items-center">
                    <div>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <div class="flex cursor-pointer items-center px-2 py-1 hover:bg-zinc-100">
                                    <!-- <div class="mr-2 size-4 bg-blue-800"></div> -->
                                    <div class="text-xl font-medium text-zinc-700">{{ clinic.name }}</div>
                                    <ChevronsUpDown class="ml-1 size-5" />
                                </div>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-64 p-0" align="start">
                                <Command highlight-on-hover>
                                    <CommandInput placeholder="Search clinics…" />
                                    <CommandList>
                                        <CommandEmpty>No results found.</CommandEmpty>
                                        <CommandGroup heading="Clinics">
                                            <Link :href="ClinicUsersController(_clinic.id)" v-for="_clinic in clinics" :key="_clinic.id">
                                                <CommandItem :value="_clinic.id">{{ _clinic.name }}</CommandItem>
                                            </Link>
                                        </CommandGroup>
                                    </CommandList>
                                </Command>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                    <div class="px-4"><ChevronRight class="size-5 text-zinc-500" /></div>
                    <div>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <div class="flex cursor-pointer items-center p-2 hover:bg-zinc-100">
                                    <!-- <div class="mr-2 size-4 bg-orange-900"></div> -->
                                    <div class="text-xl font-medium text-zinc-700">Users</div>
                                    <ChevronsUpDown class="ml-1 size-5" />
                                </div>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-56" align="start">
                                <DropdownMenuGroup>
                                    <Link :href="ClinicCommissionsController(clinic.id)">
                                        <DropdownMenuItem>Commissions</DropdownMenuItem>
                                    </Link>
                                    <Link :href="ClinicUsersController(clinic.id)">
                                        <DropdownMenuItem>Users</DropdownMenuItem>
                                    </Link>
                                    <Link :href="ClinicInvitesController(clinic.id)">
                                        <DropdownMenuItem>Invites</DropdownMenuItem>
                                    </Link>
                                    <Link :href="ClinicUsersController(clinic.id)">
                                        <DropdownMenuItem>Coupons</DropdownMenuItem>
                                    </Link>
                                    <Link :href="ClinicUsersController(clinic.id)">
                                        <DropdownMenuItem>Orders</DropdownMenuItem>
                                    </Link>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
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

            <Empty v-else>
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
