<script setup lang="ts">
import DeleteUserController from '@/actions/App/Http/Controllers/Admin/User/DeleteUserController'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { HandshakeIcon, MoreHorizontal } from 'lucide-vue-next'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    clients: Domain.Client.Data.ClientData[]
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
    <Head title="Clients" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <ClinicBreadcrumbs :clinic="clinic" :clinics="clinics" current="clients" />

            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">Clients</h1>
                    <p class="pt-1 text-muted-foreground">
                        See all clients created through your referral system. Track referred customers, their associated clinics, and their order
                        activity.
                    </p>
                </div>
                <div></div>
            </div>

            <div v-if="clients.length > 0" class="w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-zinc-500 uppercase">
                                <td class="pl-5">Name</td>
                                <td class="pl-5">Email</td>
                                <td class="pl-5">Contributions</td>
                                <td class="pl-5"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="client in clients" :key="client.id">
                                <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="text-base leading-none font-medium text-zinc-700">{{ client.name }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <p class="text-sm leading-none text-zinc-600">{{ client.email }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <div
                                                class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium text-zinc-600">
                                                {{ client.commissions_count }}
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
                        <HandshakeIcon />
                    </EmptyMedia>
                    <EmptyTitle>No clients</EmptyTitle>
                    <EmptyDescription>Clients appear automatically when new referred orders come through your Shopify store.</EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
