<script setup lang="ts">
import ClinicIndexController from '@/actions/App/Http/Controllers/Clinic/ClinicIndexController'
import CreateClinicController from '@/actions/App/Http/Controllers/Clinic/CreateClinicController'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { MoreHorizontal, Plus, Tag } from 'lucide-vue-next'

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

            <div class="w-full">
                <div class="bg-white">
                    <div class="items-center justify-between sm:flex">
                        <div class="flex items-center">
                            <a
                                class="rounded-full focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none"
                                href=" javascript:void(0)">
                                <div class="bg-primary-100 px-3 py-1 text-sm font-medium text-primary-700">
                                    <p>All</p>
                                </div>
                            </a>
                            <a
                                class="ml-2 bg-slate-100 focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none sm:ml-2"
                                href="javascript:void(0)">
                                <div class="px-3 py-1 text-sm font-medium text-slate-600 hover:bg-primary-100 hover:text-primary-700">
                                    <p>Active</p>
                                </div>
                            </a>
                            <a
                                class="ml-2 bg-slate-100 focus:bg-primary-50 focus:ring-2 focus:ring-primary-800 focus:outline-none sm:ml-2"
                                href="javascript:void(0)">
                                <div class="px-3 py-1 text-sm font-medium text-slate-600 hover:bg-primary-100 hover:text-primary-700">
                                    <p>Pending</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="mt-2 overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <tbody>
                                <template v-for="clinic in clinics" :key="clinic.id">
                                    <tr class="h-16 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                        <!-- <td>
                                        <div class="ml-5">
                                            <div class="relative flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-sm bg-slate-200">
                                                <input
                                                    placeholder="checkbox"
                                                    type="checkbox"
                                                    class="checkbox absolute h-full w-full cursor-pointer opacity-0 focus:opacity-100" />
                                                <div class="check-icon hidden rounded-sm bg-indigo-700 text-white">
                                                    <svg
                                                        class="icon icon-tabler icon-tabler-check"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        fill="none"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z"></path>
                                                        <path d="M5 12l5 5l10 -10"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </td> -->
                                        <td class="">
                                            <div class="flex items-center pl-5">
                                                <p class="mr-2 text-base leading-none text-slate-700">{{ clinic.name }}</p>
                                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M6.66669 9.33342C6.88394 9.55515 7.14325 9.73131 7.42944 9.85156C7.71562 9.97182 8.02293 10.0338 8.33335 10.0338C8.64378 10.0338 8.95108 9.97182 9.23727 9.85156C9.52345 9.73131 9.78277 9.55515 10 9.33342L12.6667 6.66676C13.1087 6.22473 13.357 5.62521 13.357 5.00009C13.357 4.37497 13.1087 3.77545 12.6667 3.33342C12.2247 2.89139 11.6251 2.64307 11 2.64307C10.3749 2.64307 9.77538 2.89139 9.33335 3.33342L9.00002 3.66676"
                                                        stroke="#3B82F6"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M9.33336 6.66665C9.11611 6.44492 8.8568 6.26876 8.57061 6.14851C8.28442 6.02825 7.97712 5.96631 7.66669 5.96631C7.35627 5.96631 7.04897 6.02825 6.76278 6.14851C6.47659 6.26876 6.21728 6.44492 6.00003 6.66665L3.33336 9.33332C2.89133 9.77534 2.64301 10.3749 2.64301 11C2.64301 11.6251 2.89133 12.2246 3.33336 12.6666C3.77539 13.1087 4.37491 13.357 5.00003 13.357C5.62515 13.357 6.22467 13.1087 6.66669 12.6666L7.00003 12.3333"
                                                        stroke="#3B82F6"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg> -->
                                            </div>
                                        </td>
                                        <td class="pl-24">
                                            <!-- <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M9.16667 2.5L16.6667 10C17.0911 10.4745 17.0911 11.1922 16.6667 11.6667L11.6667 16.6667C11.1922 17.0911 10.4745 17.0911 10 16.6667L2.5 9.16667V5.83333C2.5 3.99238 3.99238 2.5 5.83333 2.5H9.16667"
                                                        stroke="#52525B"
                                                        stroke-width="1.25"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <circle
                                                        cx="7.50004"
                                                        cy="7.49967"
                                                        r="1.66667"
                                                        stroke="#52525B"
                                                        stroke-width="1.25"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"></circle>
                                                </svg>
                                                <p class="ml-2 text-sm leading-none text-slate-600">Urgent</p>
                                            </div> -->
                                            <!-- <Badge variant="secondary">Active</Badge> -->
                                        </td>
                                        <td class="pl-5">
                                            <!-- <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M7.5 5H16.6667"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M7.5 10H16.6667"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M7.5 15H16.6667"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M4.16669 5V5.00667"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M4.16669 10V10.0067"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M4.16669 15V15.0067"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="ml-2 text-sm leading-none text-slate-600">04/07</p>
                                        </div> -->
                                        </td>
                                        <td class="pl-5">
                                            <!-- <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M3.33331 17.4998V6.6665C3.33331 6.00346 3.59671 5.36758 4.06555 4.89874C4.53439 4.4299 5.17027 4.1665 5.83331 4.1665H14.1666C14.8297 4.1665 15.4656 4.4299 15.9344 4.89874C16.4033 5.36758 16.6666 6.00346 16.6666 6.6665V11.6665C16.6666 12.3295 16.4033 12.9654 15.9344 13.4343C15.4656 13.9031 14.8297 14.1665 14.1666 14.1665H6.66665L3.33331 17.4998Z"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M10 9.1665V9.17484"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M6.66669 9.1665V9.17484"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M13.3333 9.1665V9.17484"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="ml-2 text-sm leading-none text-slate-600">23</p>
                                        </div> -->
                                        </td>
                                        <td class="pl-5">
                                            <div class="flex items-center">
                                                <!-- <Users class="size-4 text-slate-400" /> -->
                                                <p class="ml-2 text-sm leading-none text-slate-600">0 Clients</p>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            <div class="flex items-center">
                                                <!-- <Users class="size-4 text-slate-400" /> -->
                                                <p class="ml-2 text-sm leading-none text-slate-600">0 Commissions</p>
                                            </div>
                                        </td>
                                        <td class="pl-5">
                                            <div v-if="clinic.coupons">
                                                <div
                                                    v-for="coupon in clinic.coupons"
                                                    :key="coupon.id"
                                                    class="inline-block bg-slate-200 p-1 text-sm font-medium text-slate-700">
                                                    <div class="flex items-center space-x-1">
                                                        <Tag class="size-4 text-slate-600" />
                                                        <div>{{ coupon.code }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pl-4">
                                            <div class="flex justify-end pr-4">
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger as-child>
                                                        <Button variant="secondary" size="sm" aria-label="More Options">
                                                            <MoreHorizontal />
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent class="w-56" align="end">
                                                        <!-- <DropdownMenuLabel>My Account</DropdownMenuLabel> -->
                                                        <!-- <DropdownMenuGroup>
                                                            <DropdownMenuItem>
                                                                Profile
                                                                <DropdownMenuShortcut>⇧⌘P</DropdownMenuShortcut>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem>
                                                                Billing
                                                                <DropdownMenuShortcut>⌘B</DropdownMenuShortcut>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem>
                                                                Settings
                                                                <DropdownMenuShortcut>⌘S</DropdownMenuShortcut>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem>
                                                                Keyboard shortcuts
                                                                <DropdownMenuShortcut>⌘K</DropdownMenuShortcut>
                                                            </DropdownMenuItem>
                                                        </DropdownMenuGroup> -->
                                                        <!-- <DropdownMenuSeparator /> -->
                                                        <DropdownMenuGroup>
                                                            <DropdownMenuItem>View</DropdownMenuItem>
                                                            <DropdownMenuItem>Edit</DropdownMenuItem>
                                                            <DropdownMenuItem>Add Coupon</DropdownMenuItem>
                                                            <!-- <DropdownMenuSub>
                                                                <DropdownMenuSubTrigger>Invite users</DropdownMenuSubTrigger>
                                                                <DropdownMenuPortal>
                                                                    <DropdownMenuSubContent>
                                                                        <DropdownMenuItem>Email</DropdownMenuItem>
                                                                        <DropdownMenuItem>Message</DropdownMenuItem>
                                                                        <DropdownMenuSeparator />
                                                                        <DropdownMenuItem>More...</DropdownMenuItem>
                                                                    </DropdownMenuSubContent>
                                                                </DropdownMenuPortal>
                                                            </DropdownMenuSub>
                                                            <DropdownMenuItem>
                                                                New Team
                                                                <DropdownMenuShortcut>⌘+T</DropdownMenuShortcut>
                                                            </DropdownMenuItem> -->
                                                        </DropdownMenuGroup>
                                                        <DropdownMenuSeparator />
                                                        <DropdownMenuItem>
                                                            Delete
                                                            <!-- <DropdownMenuShortcut>⇧⌘Q</DropdownMenuShortcut> -->
                                                        </DropdownMenuItem>
                                                    </DropdownMenuContent>
                                                </DropdownMenu>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- <tr class="h-2"></tr> -->
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
