<script setup lang="ts">
import ClinicClientsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicClientsController'
import ClinicCommissionsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCommissionsController'
import ClinicCouponsController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicCouponsController'
import ClinicInvitesController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicInvitesController'
import ClinicOrdersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicOrdersController'
import ClinicUsersController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicUsersController'
import { Link } from '@inertiajs/vue3'
import { ChevronRight, ChevronsUpDown, Store } from 'lucide-vue-next'

type CurrentPage = 'commissions' | 'payouts' | 'users' | 'invites' | 'clients' | 'coupons' | 'orders'

interface Props {
    clinic: Domain.Clinic.Data.ClinicData
    clinics: Domain.Clinic.Data.ClinicData[]
    current: CurrentPage
}

const props = defineProps<Props>()

const clinicSectionHref = (clinicId: string) => {
    switch (props.current) {
        case 'commissions':
            return ClinicCommissionsController(clinicId)
        case 'payouts':
            return ClinicCommissionsController(clinicId)
        case 'users':
            return ClinicUsersController(clinicId)
        case 'invites':
            return ClinicInvitesController(clinicId)
        case 'clients':
            return ClinicClientsController(clinicId)
        case 'coupons':
            return ClinicCouponsController(clinicId)
        case 'orders':
            return ClinicOrdersController(clinicId)
        default:
            return ClinicCommissionsController(clinicId)
    }
}

const sectionLabel = computed(() => {
    const str = props.current ?? ''
    return str.charAt(0).toUpperCase() + str.slice(1)
})
</script>

<template>
    <div class="flex items-center">
        <div class="flex flex-1 items-center">
            <div>
                <Link href="/clinics" class="flex items-center px-2 py-1 hover:bg-zinc-100">
                    <Store class="mr-2 size-4" />
                    <span class="text-sm text-foreground">Clinics</span>
                </Link>
            </div>
            <div class="px-4"><ChevronRight class="size-5 text-muted-foreground/50" /></div>
            <div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <div class="flex cursor-pointer items-center px-2 py-1 hover:bg-zinc-100">
                            <div class="mr-2 size-4 rounded bg-blue-800"></div>
                            <div class="text-sm text-foreground">{{ clinic.name }}</div>
                            <ChevronsUpDown class="ml-1 size-3.5 text-muted-foreground" />
                        </div>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-64 p-0" align="start">
                        <Command highlight-on-hover>
                            <CommandInput placeholder="Search clinics…" />
                            <CommandList>
                                <CommandEmpty>No results found.</CommandEmpty>
                                <CommandGroup heading="Clinics">
                                    <Link :href="clinicSectionHref(_clinic.id)" v-for="_clinic in clinics" :key="_clinic.id">
                                        <CommandItem :value="_clinic.id">{{ _clinic.name }}</CommandItem>
                                    </Link>
                                </CommandGroup>
                            </CommandList>
                        </Command>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
            <div class="px-4"><ChevronRight class="size-5 text-muted-foreground/50" /></div>
            <div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <div class="flex cursor-pointer items-center px-2 py-1 hover:bg-zinc-100">
                            <div class="text-sm text-foreground">{{ sectionLabel }}</div>
                            <ChevronsUpDown class="ml-1 size-3.5 text-muted-foreground" />
                        </div>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56" align="start">
                        <DropdownMenuGroup>
                            <Link :href="ClinicCommissionsController(clinic.id)">
                                <DropdownMenuItem>Commissions</DropdownMenuItem>
                            </Link>
                            <Link :href="ClinicCommissionsController(clinic.id)">
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
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </div>
</template>
