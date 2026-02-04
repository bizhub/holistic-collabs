<script setup lang="ts">
import StartShopifyOAuthController from '@/actions/App/Http/Controllers/Admin/Shopify/StartShopifyOAuthController'
import { Button } from '@/components/ui/button'
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

interface Props {
    shopify: Domain.Shopify.Data.ShopifyData
}

defineProps<Props>()

const shopifyUrl = ref('')
const loading = ref(false)
const connect = () => {
    loading.value = true

    router.post(StartShopifyOAuthController(), {
        url: shopifyUrl.value,
    })
}
</script>

<template>
    <Head title="Shopify" />

    <AppLayout>
        <div class="mx-auto flex h-full w-full max-w-4xl flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-6">
                <div class="flex items-center space-x-6">
                    <h1 class="text-3xl font-bold tracking-tight">Shopify Integration</h1>
                </div>
                <p class="pt-1 text-muted-foreground">Connect Holistic Collabs to Shopify</p>
            </div>

            <form @submit.prevent="connect">
                <div class="space-y-10">
                    <div>
                        <div class="mb-5">
                            <h2 class="text-xl font-medium tracking-tight">Shopify Connection</h2>
                            <p class="pt-1 text-sm text-muted-foreground">Enter your Shopify store domain to connect your store</p>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <Label for="shopifyUrl">Store URL</Label>
                                <Input id="shopifyUrl" v-model="shopifyUrl" placeholder="e.g. myshop.myshopify.com" />
                            </div>
                        </div>
                    </div>
                </div>

                <DialogFooter class="mt-10">
                    <Button type="submit" size="lg" :disabled="loading">
                        <div v-if="loading" class="flex items-center">
                            <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                            <div>Connecting</div>
                        </div>
                        <div v-else>Connect</div>
                    </Button>
                </DialogFooter>
            </form>
        </div>
    </AppLayout>
</template>
