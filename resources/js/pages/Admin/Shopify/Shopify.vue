<script setup lang="ts">
import DisconnectShopifyController from '@/actions/App/Http/Controllers/Admin/Shopify/DisconnectShopifyController'
import ShopifyConnectController from '@/actions/App/Http/Controllers/Admin/Shopify/ShopifyConnectController'
import SubscribeToShopifyWebhooksController from '@/actions/App/Http/Controllers/Admin/Shopify/SubscribeToShopifyWebhooksController'
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { Plug, Zap } from 'lucide-vue-next'

interface Props {
    shopify: Domain.Shopify.Data.ShopifyData
    activity: Domain.Shopify.Data.ShopifyActivityData[]
    webhook_status: Domain.Shopify.Enums.WebhookStatus
}

const props = defineProps<Props>()

const lastActivityAt = computed(() => {
    if (!props.activity.length) return null

    return props.activity[0].created_at
})

const disconnectShopify = () => {
    if (!confirm('Are you sure you want to disconnect from Shopify?')) {
        return
    }

    router.delete(DisconnectShopifyController())
}
</script>

<template>
    <Head title="Shopify" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6 flex items-center">
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-3xl font-bold tracking-tight">Shopify Integration</h1>
                    </div>
                    <p class="pt-1 text-muted-foreground">Connect Holistic Collabs to Shopify for real-time synchronizing</p>
                </div>
                <div></div>
            </div>

            <div class="mb-6 grid grid-cols-2 gap-6">
                <div v-if="shopify.status == 'connected'" class="flex flex-col border-green-200 bg-green-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-green-800">Shopify</div>
                    <div class="flex flex-1 items-center justify-center border border-green-200 bg-white p-6 shadow-sm shadow-green-100">
                        <div class="flex flex-col items-center text-center">
                            <div>Holistic Collabs is connected to Shopify</div>
                            <div class="text-xs font-medium text-zinc-500 italic">
                                Last successful API call: {{ dayjs(lastActivityAt).format('DD/MM/YYYY h:mma') }}
                            </div>
                            <div class="mt-6">
                                <Button variant="outline" @click="disconnectShopify">Disconnect</Button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex flex-col border-red-200 bg-red-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-red-800">Shopify Disconnected</div>
                    <div class="flex flex-1 items-center justify-center border border-red-200 bg-white p-6 shadow-sm shadow-red-100">
                        <div class="flex flex-col items-center text-center">
                            <div>Your Shopify connection is not active</div>
                            <div class="text-xs font-medium text-zinc-500 italic">
                                Last successful API call: {{ dayjs(lastActivityAt).format('DD/MM/YYYY h:mma') }}
                            </div>
                            <div class="mt-6">
                                <Link :href="ShopifyConnectController()">
                                    <Button variant="outline"><Plug /> Connect</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="webhook_status == 'connected'" class="flex flex-col border-green-200 bg-green-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-green-800">Webhooks</div>
                    <div class="flex flex-1 items-center justify-center border border-green-200 bg-white p-6 shadow-sm shadow-green-100">
                        <div class="flex flex-col items-center text-center">
                            <div>Shopify webhooks are active</div>
                            <div class="text-xs font-medium text-zinc-500 italic">
                                Last successful request: {{ dayjs(lastActivityAt).format('DD/MM/YYYY h:mma') }}
                            </div>
                            <div class="mt-6">
                                <Link :href="SubscribeToShopifyWebhooksController()">
                                    <Button variant="outline">Refresh</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="flex flex-col border-red-200 bg-red-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-red-800">Webhooks disconnected</div>
                    <div class="flex flex-1 items-center justify-center border border-red-200 bg-white p-6 shadow-sm shadow-red-100">
                        <div class="flex flex-col items-center text-center">
                            <div>No Shopify webhooks are currently installed</div>
                            <div class="text-xs font-medium text-zinc-500 italic">
                                Last successful API call: {{ dayjs(lastActivityAt).format('DD/MM/YYYY h:mma') }}
                            </div>
                            <div class="mt-6">
                                <Link :href="SubscribeToShopifyWebhooksController()">
                                    <Button variant="outline">Subscribe</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="flex flex-col border-zinc-200 bg-zinc-100/80 p-1">
                    <div class="flex justify-center py-2 font-medium text-zinc-800">Health check</div>
                    <div class="flex flex-1 items-center justify-center border border-zinc-200 bg-white p-6 shadow-sm shadow-zinc-100">
                        <div class="flex flex-col items-center text-center">
                            <div>{{ shopify.url }}</div>
                            <div class="text-xs font-medium text-zinc-500 italic">
                                Last successful API call: {{ dayjs(lastActivityAt).format('DD/MM/YYYY h:mma') }}
                            </div>
                            <div class="mt-6">
                                <Button variant="outline">Refresh</Button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <div v-if="activity.length > 0" class="w-full">
                <div class="bg-white">
                    <div class="mt-3 overflow-x-auto border border-zinc-200 py-3 shadow-sm shadow-zinc-100">
                        <table class="w-full whitespace-nowrap">
                            <tbody>
                                <tr v-for="log in activity" :key="log.id" class="h-8 rounded hover:bg-zinc-50 focus:outline-none">
                                    <td width="200">
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 font-mono text-sm leading-none text-zinc-700">
                                                {{ dayjs(log.created_at).format('DD/MM/YYYY h:mma') }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center pl-5">
                                            <p class="mr-2 font-mono text-sm leading-none text-zinc-700">{{ log.description }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <Empty v-else class="border border-dashed">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <Zap />
                    </EmptyMedia>
                    <EmptyTitle>No Activity Yet</EmptyTitle>
                    <EmptyDescription> Your Shopify integration hasn't recorded any activity yet. </EmptyDescription>
                </EmptyHeader>
            </Empty>
        </div>
    </AppLayout>
</template>
