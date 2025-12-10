<script setup lang="ts">
import ShopifyConnectController from '@/actions/App/Http/Controllers/Shopify/ShopifyConnectController'
import ShopifyIndexController from '@/actions/App/Http/Controllers/Shopify/ShopifyIndexController'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { Plug } from 'lucide-vue-next'

interface Props {
    shopify: Domain.Shopify.Data.ShopifyData
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shopify',
        href: ShopifyIndexController().url,
    },
]
</script>

<template>
    <Head title="Shopify" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Shopify Integration</h1>
                    </div>
                    <p class="pt-1 text-slate-600">Connect Holistic Collabs to Shopify</p>
                </div>
                <div></div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div v-if="shopify.status == 'connected'" class="flex flex-col border-green-200 bg-green-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-green-800">Shopify connected</div>
                    <div class="flex flex-1 items-center justify-center border border-green-200 bg-white p-6 shadow-sm shadow-green-100">
                        <div class="flex flex-col items-center text-center">
                            <!-- <div>
                                <div class="flex size-6 items-center justify-center rounded-full bg-green-400">
                                    <Check class="size-5 text-white" />
                                </div>
                            </div> -->
                            <div>{{ shopify.url }}</div>
                            <div class="text-xs font-medium text-slate-500 italic">Last Successful API Call: 08/08/25</div>
                            <div class="mt-6">
                                <Button variant="outline">Disconnect</Button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex flex-col border-red-200 bg-red-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-red-800">Shopify disconnected</div>
                    <div class="flex flex-1 items-center justify-center border border-red-200 bg-white p-6 shadow-sm shadow-red-100">
                        <div class="flex flex-col items-center text-center">
                            <!-- <div>
                                <div class="flex size-6 items-center justify-center rounded-full bg-green-400">
                                    <Check class="size-5 text-white" />
                                </div>
                            </div> -->
                            <!-- <div>{{ shopify.url }}</div> -->
                            <div>Your Shopify connection is not active</div>
                            <div class="text-xs font-medium text-slate-500 italic">Last Successful API Call: 00/00/0000</div>
                            <div class="mt-6">
                                <Link :href="ShopifyConnectController()">
                                    <Button variant="outline"><Plug /> Connect</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col border-red-200 bg-red-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-red-800">Webhooks disconnected</div>
                    <div class="flex flex-1 items-center justify-center border border-red-200 bg-white p-6 shadow-sm shadow-red-100">
                        <div class="flex flex-col items-center text-center">
                            <!-- <div>
                                <div class="flex size-6 items-center justify-center rounded-full bg-red-400">
                                    <Check class="size-5 text-white" />
                                </div>
                            </div> -->
                            <!-- <div>{{ shopify.url }}</div> -->
                            <div>Webhook status cannot be determined</div>
                            <div class="text-xs font-medium text-slate-500 italic">Last Successful API Call: 08/08/25</div>
                            <div class="mt-6">
                                <Button variant="outline">Refresh</Button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col border-slate-200 bg-slate-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-slate-800">Webhooks disconnected</div>
                    <div class="flex flex-1 items-center justify-center border border-slate-200 bg-white p-6 shadow-sm shadow-slate-100">
                        <div class="flex flex-col items-center text-center">
                            <!-- <div>
                                <div class="flex size-6 items-center justify-center rounded-full bg-red-400">
                                    <Check class="size-5 text-white" />
                                </div>
                            </div> -->
                            <div>{{ shopify.url }}</div>
                            <div class="text-xs font-medium text-slate-500 italic">Last Successful API Call: 08/08/25</div>
                            <div class="mt-6">
                                <Button variant="outline">Refresh</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden w-full">
                <div class="bg-white">
                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full whitespace-nowrap shadow-sm shadow-slate-100">
                            <tbody>
                                <tr class="h-12 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td width="200">
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">20/01/2025</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">Order #52525B processed</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="h-12 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td width="200">
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">20/01/2025</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">Order #9CA3AF processed</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="h-12 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td width="200">
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">20/01/2025</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">Order #3B82F6 processed</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="h-12 rounded border border-slate-200 hover:bg-slate-50 focus:outline-none">
                                    <td width="200">
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">20/01/2025</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 text-sm leading-none text-slate-700">Connected to Shopify</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
