<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { MoreHorizontal, Plus, Users } from 'lucide-vue-next'

// interface Props {
//     users: Domain.User.Data.UserData[]
// }

// defineProps<Props>()

const invites = ref([])
</script>

<template>
    <Head title="Invites" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Invites</h1>
                    </div>
                    <p class="pt-1 text-slate-600">Manage pending invitations. Send, resend, or revoke invites.</p>
                </div>
                <div>
                    <!-- <Link :href="CreateClinicController()"> -->
                    <Button size="lg">
                        <Plus />
                        <span>Send Invitation</span>
                    </Button>
                    <!-- </Link> -->
                </div>
            </div>

            <div v-if="invites.length > 0" class="w-full">
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
                            <template v-for="user in invites" :key="user.id">
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
                                                        <DropdownMenuItem disabled>Add Coupon</DropdownMenuItem>
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
                    <EmptyTitle>No active invites</EmptyTitle>
                    <EmptyDescription
                        >You haven’t sent any invitations. Use the button below to invite users or admins to your system.</EmptyDescription
                    >
                </EmptyHeader>
                <EmptyContent>
                    <!-- <Link :href="CreateClinicController()"> -->
                    <Button variant="outline" size="sm">
                        <Plus />
                        Send Invitation
                    </Button>
                    <!-- </Link> -->
                </EmptyContent>
            </Empty>
        </div>
    </AppLayout>
</template>
