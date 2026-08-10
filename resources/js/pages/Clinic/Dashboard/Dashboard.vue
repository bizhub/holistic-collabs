<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import { ChartNoAxesCombined, ChevronRight, Handshake, Tag, Truck } from 'lucide-vue-next'
import { toast, type ToastOptions } from 'vue3-toastify'

type Tabs = 'orders' | 'clients' | 'payouts'

const props = defineProps<{
    auth: {
        clinic: {
            name: string
        }
    }

    client_count: number
    commission_count: number
    commission_earned: number

    orders: Domain.Order.Data.OrderData[]
    clients: Domain.Client.Data.ClientData[]
    payouts: Domain.Commission.Data.PayoutData[]
    upcoming_payout_amount: number

    commission_percentage_change?: number
    coupon_code: string | null
}>()

dayjs.extend(utc)
dayjs.extend(timezone)

const currentTab = ref<Tabs>('orders')

const currentOrderExpanded = ref<string>('')
const toggleOrderExpanded = (id: string) => {
    currentOrderExpanded.value = currentOrderExpanded.value == id ? '' : id
}

const addCouponCodeToClipboard = () => {
    if (!props.coupon_code) return

    navigator.clipboard.writeText(props.coupon_code)

    toast.success('Copied to clipboard', {
        autoClose: 4000,
        transition: toast.TRANSITIONS.SLIDE,
        position: toast.POSITION.BOTTOM_RIGHT,
    } as ToastOptions)
}

const addCouponLinkToClipboard = () => {
    navigator.clipboard.writeText(`https://holisticbeauty.co.nz/discount/${props.coupon_code}`)

    toast.success('Copied to clipboard', {
        autoClose: 4000,
        transition: toast.TRANSITIONS.SLIDE,
        position: toast.POSITION.BOTTOM_RIGHT,
    } as ToastOptions)
}
</script>

<template>
    <Head title="Overview" />

    <ClinicLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Overview</h1>
                    </div>
                    <p class="pt-1 text-muted-foreground">Earn commissions through orders using your clinic code</p>
                </div>
                <div>
                    <Dialog v-if="coupon_code">
                        <DialogTrigger>
                            <Button size="lg">
                                <Tag />
                                Clinic Code & Link
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Clinic Code</DialogTitle>
                            </DialogHeader>
                            <div class="mt-2 text-sm text-slate-700">
                                Share this code with your clients to enter at checkout for $10 off their first purchase, and to link them to your
                                clinic.
                            </div>
                            <div class="flex items-center justify-between border bg-zinc-50 px-4 py-3">
                                <code class="min-w-0 flex-1 pr-6 font-mono text-sm font-medium break-all">{{ coupon_code }}</code>
                                <Button size="sm" @click="addCouponCodeToClipboard">Copy</Button>
                            </div>
                            <div class="mt-4 text-sm text-slate-700">
                                Share this link with your clients to automatically apply your clinic code at checkout - saves them having to manually
                                enter it.
                            </div>
                            <div class="flex items-center border bg-zinc-50 px-4 py-3">
                                <code class="min-w-0 flex-1 pr-6 font-mono text-sm font-medium break-all">
                                    https://holisticbeauty.co.nz/discount/{{ coupon_code }}
                                </code>
                                <Button size="sm" @click="addCouponLinkToClipboard">Copy</Button>
                            </div>
                            <p class="mt-4 text-sm text-slate-700">
                                Clients only need to use this code once to be linked to your clinic - all future orders they place under the same
                                account (email address) will automatically generate commissions for you.
                            </p>
                        </DialogContent>
                    </Dialog>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-3 gap-6">
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">referrals</h6>
                        <span class="text-3xl font-semibold">{{ client_count }}</span>
                    </div>
                    <div>
                        <Handshake class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">commissions</h6>
                        <span class="text-3xl font-semibold">{{ commission_count }}</span>
                        <span v-if="commission_percentage_change" class="ml-2 inline-block rounded-md bg-green-100 px-2 py-px text-xs text-green-500">
                            +{{ commission_percentage_change }}%
                        </span>
                    </div>
                    <div>
                        <ChartNoAxesCombined class="size-12 text-zinc-200" />
                    </div>
                </div>
                <div class="flex items-center justify-between border border-zinc-200/80 bg-white p-4">
                    <div>
                        <h6 class="text-xs leading-none font-medium tracking-wider text-muted-foreground uppercase">Upcoming payout</h6>
                        <span class="text-3xl font-semibold">${{ upcoming_payout_amount.toFixed(2) }}</span>
                    </div>
                    <div>
                        <Truck class="size-12 text-zinc-200" />
                    </div>
                </div>
            </div>

            <div class="mb-3 flex items-center gap-6">
                <button
                    @click="currentTab = 'orders'"
                    class="cursor-pointer border-b-4 text-3xl font-medium tracking-tight hover:text-black"
                    :class="[currentTab == 'orders' ? 'border-slate-300' : 'border-transparent text-black/60']">
                    Orders
                </button>
                <button
                    @click="currentTab = 'clients'"
                    class="cursor-pointer border-b-4 text-3xl font-medium tracking-tight hover:text-black"
                    :class="[currentTab == 'clients' ? 'border-slate-300' : 'border-transparent text-black/60']">
                    Referrals
                </button>
                <button
                    @click="currentTab = 'payouts'"
                    class="cursor-pointer border-b-4 text-3xl font-medium tracking-tight hover:text-black"
                    :class="[currentTab == 'payouts' ? 'border-slate-300' : 'border-transparent text-black/60']">
                    Payouts
                </button>
            </div>

            <div v-if="currentTab == 'orders'">
                <div v-if="orders.length > 0" class="w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                    <td class="pl-5">Order</td>
                                    <td class="pl-5">Date</td>
                                    <td class="pl-5">Client</td>
                                    <td class="pl-5">Clinic code used</td>
                                    <td class="pr-10 pl-5">
                                        <div class="flex justify-end">Subtotal</div>
                                    </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="order in orders" :key="order.id">
                                    <tr
                                        @click="toggleOrderExpanded(order.id)"
                                        class="h-16 cursor-pointer rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                        <td class="pl-5">
                                            <p class="text-sm leading-none">#{{ order.order_number }}</p>
                                        </td>
                                        <td class="pl-5">
                                            <p class="text-sm leading-none">
                                                {{ dayjs.utc(order.created_at).local().format('DD/MM/YYYY h:mma') }}
                                            </p>
                                        </td>
                                        <td class="space-y-1.5 pl-5">
                                            <p class="text-sm leading-none">{{ order.client?.name }}</p>
                                            <p class="text-sm leading-none text-slate-700">{{ order.client?.email }}</p>
                                        </td>
                                        <td class="pl-5">
                                            <div v-if="order.coupon_code" class="inline-block bg-zinc-200 px-3 py-1.5">
                                                <div class="flex items-center space-x-1">
                                                    <Tag class="size-4 text-zinc-600" />
                                                    <div class="text-sm font-medium text-zinc-600">{{ order.coupon_code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pr-10 pl-5">
                                            <div class="flex items-center justify-end">
                                                <p class="text-sm leading-none">
                                                    ${{
                                                        order.subtotal_price.toLocaleString(undefined, {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        })
                                                    }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <ChevronRight
                                                class="size-5"
                                                :class="{
                                                    'rotate-90': currentOrderExpanded == order.id,
                                                }" />
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="currentOrderExpanded == order.id && order.items && order.items.length > 0"
                                        class="border border-zinc-200 bg-zinc-100 focus:outline-none">
                                        <td colspan="5" class="py-10 pr-10 pl-5">
                                            <div v-for="item in order.items" :key="item.id" class="flex justify-between py-1">
                                                <div>
                                                    {{ item.name }}
                                                    <span class="text-sm text-zinc-500"> × {{ item.quantity }} </span>
                                                </div>
                                                <div class="text-sm">
                                                    ${{
                                                        item.price.toLocaleString(undefined, {
                                                            minimumFractionDigits: 2,
                                                            maximumFractionDigits: 2,
                                                        })
                                                    }}
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Empty v-else class="border">
                    <EmptyHeader>
                        <EmptyMedia variant="icon">
                            <Handshake />
                        </EmptyMedia>
                        <EmptyTitle>No orders yet</EmptyTitle>
                        <EmptyDescription>Earn commissions through orders using your clinic code.</EmptyDescription>
                    </EmptyHeader>
                </Empty>
            </div>

            <div v-if="currentTab == 'clients'">
                <div v-if="clients.length > 0" class="w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                    <td class="pl-5">Name</td>
                                    <td class="pl-5">Email</td>
                                    <td class="pl-5">Commissions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="client in clients" :key="client.id">
                                    <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                        <td class="pl-5">
                                            <p class="text-sm leading-none">{{ client.name }}</p>
                                        </td>
                                        <td class="pl-5">
                                            <p class="text-sm leading-none">{{ client.email }}</p>
                                        </td>
                                        <td class="pl-5">
                                            <div class="flex items-center">
                                                <div class="flex size-6 items-center justify-center bg-zinc-200 text-sm leading-none font-medium">
                                                    {{ client.commissions_count }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Empty v-else class="border">
                    <EmptyHeader>
                        <EmptyMedia variant="icon">
                            <Handshake />
                        </EmptyMedia>
                        <EmptyTitle>No clients yet</EmptyTitle>
                        <EmptyDescription>Earn commissions through orders using your clinic code.</EmptyDescription>
                    </EmptyHeader>
                </Empty>
            </div>

            <div v-if="currentTab == 'payouts'">
                <div v-if="payouts.length > 0" class="w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="h-8 border border-zinc-200 bg-zinc-50 text-xs font-medium text-muted-foreground uppercase">
                                    <td class="pl-5">Date</td>
                                    <td class="pr-5">
                                        <div class="flex justify-end">Amount</div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="payout in payouts" :key="payout.id">
                                    <tr class="h-16 rounded border border-zinc-200 hover:bg-zinc-50 focus:outline-none">
                                        <td class="pl-5">
                                            <p class="text-sm leading-none">
                                                {{ dayjs(payout.paid_at).format('DD MMM YYYY') }}
                                            </p>
                                        </td>
                                        <td class="pr-5">
                                            <div class="flex items-center justify-end">
                                                <p class="text-sm leading-none">${{ payout.total_amount.toFixed(2) }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Empty v-else class="border">
                    <EmptyHeader>
                        <EmptyMedia variant="icon">
                            <Handshake />
                        </EmptyMedia>
                        <EmptyTitle>No payouts yet</EmptyTitle>
                        <EmptyDescription>Earn commissions through orders using your clinic code</EmptyDescription>
                    </EmptyHeader>
                </Empty>
            </div>
        </div>
    </ClinicLayout>
</template>
