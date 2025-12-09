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

const ucfirst = (str: string) => {
    if (!str) return ''
    return str.charAt(0).toUpperCase() + str.slice(1)
}
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
                <div>
                    <Link v-if="shopify.status != 'connected'" :href="ShopifyConnectController()">
                        <Button><Plug /> Connect</Button>
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <Card>
                    <CardHeader>Status</CardHeader>
                    <CardContent>{{ ucfirst(shopify.status) }}</CardContent>
                </Card>
                <Card>
                    <CardHeader>Store</CardHeader>
                    <CardContent>{{ shopify.url }}</CardContent>
                </Card>
                <Card>
                    <CardHeader>Webhooks</CardHeader>
                    <CardContent>Active</CardContent>
                </Card>
            </div>

            <div class="w-full">
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
