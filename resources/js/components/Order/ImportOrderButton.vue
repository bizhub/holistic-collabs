<script setup lang="ts">
import ImportOrderFromShopifyController from '@/actions/App/Http/Controllers/Admin/Order/ImportOrderFromShopifyController'
import { Loader2, Zap } from 'lucide-vue-next'

const form = useForm({
    shopify_id: '',
})

const submit = () => {
    form.post(ImportOrderFromShopifyController().url, {
        onSuccess() {
            form.reset()
        },
    })
}
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button variant="secondary">
                <Zap />
                Import from Shopify
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Import Order</DialogTitle>
                <DialogDescription class="space-y-2">
                    <p>Use this form to import a Shopify order that wasn't processed correctly.</p>
                    <p>
                        Enter the Shopify Order ID, which you can find by opening the order in Shopify and copying the number at the end of the URL.
                    </p>
                    <p>Orders can only be imported once.</p>
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="submit">
                <div class="mt-2 space-y-2">
                    <Label for="shopify-order-id">Shopify Order ID</Label>
                    <Input id="shopify-order-id" type="text" placeholder="1234567890" v-model="form.shopify_id" />
                </div>

                <div class="mt-4 flex justify-end">
                    <Button type="submit">
                        <div v-if="form.processing" class="flex items-center">
                            <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                            <div>Importing</div>
                        </div>
                        <div v-else>Import Order</div>
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
