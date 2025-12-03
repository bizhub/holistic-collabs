<script setup lang="ts">
import IntegrationIndexController from '@/actions/App/Http/Controllers/Integration/IntegrationIndexController'
import { Button } from '@/components/ui/button'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Plug } from 'lucide-vue-next'

defineProps<{}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Integrations',
        href: IntegrationIndexController().url,
    },
]
</script>

<template>
    <Head title="Integrations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold tracking-tight">Integrations</h1>
                    <!-- <Link :href="CreateIntegrationController()">
                            <Button size="sm"><Plug />Connect</Button>
                        </Link> -->
                </div>
                <p class="pt-1 text-slate-600">Connect Fulfillr to your existing tools to sync orders, products, and stock seamlessly</p>
            </div>

            <div class="flex w-full items-center justify-center rounded border-t border-slate-100 p-6">
                <div class="my-12 flex flex-col items-center">
                    <img src="/img/clouds.svg" width="250" />
                    <span class="mt-6 text-xl font-medium tracking-tight">Connect your first integration</span>
                    <p class="mb-6 text-slate-600">Get your integrations set up and start fulfilling orders faster</p>
                    <!-- <Link :href="CreateIntegrationController()"> -->
                    <Button size="sm"><Plug />Connect Integration</Button>
                    <!-- </Link> -->
                </div>
            </div>

            <!-- <div v-else class="grid grid-cols-1 gap-6 lg:grid-cols-2 2xl:grid-cols-3">
                    <div
                        v-for="integration in integrations"
                        :key="integration.id"
                        class="flex flex-col justify-between border bg-white p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="flex flex-1 items-center space-x-2">
                                <template v-if="integration.provider == 'unleashed'">
                                    <img src="/img/providers/unleashed.ico" alt="Unleashed" class="h-8 w-8" />
                                    <h2 class="text-lg font-medium">Unleashed</h2>
                                </template>
                                <template v-if="integration.provider == 'shopify'">
                                    <img src="/img/providers/shopify.svg" alt="Shopify" class="h-8 w-8" />
                                    <h2 class="text-lg font-medium">Shopify</h2>
                                </template>
                            </div>
                        </div>
                        <p v-if="integration.provider == 'unleashed'" class="mt-3 text-sm text-slate-700">
                            Import products and stock data from Unleashed. Ensure your inventory is always up to date when fulfilling orders.
                        </p>
                        <p v-if="integration.provider == 'shopify'" class="mt-3 text-sm text-slate-700">
                            Connect your Shopify store to automatically sync products, orders, and inventory.
                        </p>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex-1">
                                <Badge v-if="integration.status == 'pending'" variant="pending">
                                    <span class="relative mr-1 flex h-2.5 w-2.5">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-600"></span>
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-sky-600"></span>
                                    </span>
                                    Connecting
                                </Badge>
                                <Badge v-if="integration.status == 'active'" variant="success">
                                    Connected
                                </Badge>
                            </div>
                            <div class="space-x-2">
                                <Link :href="'/integrations/' + integration.provider + '/' + integration.id + '/edit'">
                                    <Button variant="outline" size="sm"><Settings />Configure</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div> -->
        </div>
    </AppLayout>
</template>
