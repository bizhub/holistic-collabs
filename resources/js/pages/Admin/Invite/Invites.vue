<script setup lang="ts">
import CreateInviteController from '@/actions/App/Http/Controllers/Admin/Invite/CreateInviteController'
import DeleteInviteController from '@/actions/App/Http/Controllers/Admin/Invite/DeleteInviteController'
import ResendInviteController from '@/actions/App/Http/Controllers/Admin/Invite/ResendInviteController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { Mails, MoreHorizontal, Plus } from 'lucide-vue-next'

interface Props {
    invites: Domain.Invite.Data.InviteData[]
}

defineProps<Props>()

const deleteInvite = (invite: Domain.Invite.Data.InviteData) => {
    if (!confirm('Are you sure you want to delete this invite for "' + invite.name + '"?')) {
        return
    }

    router.delete(DeleteInviteController(invite.id).url)
}
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
                    <Link :href="CreateInviteController()">
                        <Button size="lg">
                            <Plus />
                            <span>Send Invitation</span>
                        </Button>
                    </Link>
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
                            <template v-for="invite in invites" :key="invite.id">
                                <tr class="h-16 border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-sm leading-none text-slate-600">{{ invite.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">
                                                {{ invite.email }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div v-if="invite.clinic" class="flex items-center">
                                            <p class="text-sm leading-none text-slate-600">
                                                {{ invite.clinic.name }}
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
                                                        <Link :href="ResendInviteController(invite.id)">
                                                            <DropdownMenuItem>Resend</DropdownMenuItem>
                                                        </Link>
                                                    </DropdownMenuGroup>
                                                    <DropdownMenuSeparator />
                                                    <DropdownMenuItem @click="deleteInvite(invite)">Delete</DropdownMenuItem>
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
                        <Mails />
                    </EmptyMedia>
                    <EmptyTitle>No active invites</EmptyTitle>
                    <EmptyDescription>
                        You haven't sent any invitations. Use the button below to invite users or admins to your system.
                    </EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <Link :href="CreateInviteController()">
                        <Button variant="outline" size="sm">
                            <Plus />
                            Send Invitation
                        </Button>
                    </Link>
                </EmptyContent>
            </Empty>
        </div>
    </AppLayout>
</template>
