<script setup lang="ts">
import StoreClinicController from '@/actions/App/Http/Controllers/Clinic/StoreClinicController'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

interface Props {
    available_coupons: Domain.Coupon.Data.AvailableCouponData[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
    // {
    //     title: 'Integrations',
    //     href: IntegrationIndexController().url,
    // },
]

const loading = ref(false)

const form = useForm<Domain.Clinic.Data.ClinicFormData>({
    name: '',
    coupon_shopify_id: '',
})

const temp = ref('')

const connectIntegration = () => {
    loading.value = true

    form.post(StoreClinicController().url)

    // router.post(
    //     ConnectIntegrationController(),
    //     {
    //         provider: provider.value,
    //         data,
    //     },
    //     {
    //         onError() {
    //             loading.value = false
    //         },
    //     }
    // )
}
</script>

<template>
    <Head title="Create Clinic" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-4xl px-6 py-12">
            <div class="relative flex-1">
                <div class="mb-10 border-b border-slate-200 pb-4">
                    <h1 class="text-3xl font-bold tracking-tight">Add Clinic</h1>
                    <p class="pt-1 text-slate-600">Integrate Fulfillr with your existing tools in just a few steps</p>
                </div>

                <form @submit.prevent="connectIntegration">
                    <div class="space-y-12">
                        <div>
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Clinic details</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Add a new clinic and set up their referral code so new<br />
                                    clients can be automatically linked and tracked for future commissions.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <Label for="name">Clinic Name</Label>
                                    <Input id="name" v-model="form.name" placeholder="Enter a clinics name" />
                                </div>
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="name">Contact Name</Label>
                                        <Input id="name" v-model="temp" placeholder="Enter a clinics name" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="name">Email</Label>
                                        <Input id="name" v-model="temp" placeholder="Enter a clinics name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Coupon Code</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Select an available Shopify discount code. If you don't see yours, refresh the list.<br />
                                    This field is optional, you can add coupons later.
                                </p>
                            </div>

                            <Select v-model="form.coupon_shopify_id" :disabled="available_coupons.length == 0">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a coupon code" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="coupon in available_coupons" :key="coupon.code" :value="coupon.shopify_id">
                                        {{ coupon.code }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>

                    <DialogFooter class="mt-10">
                        <Button type="submit" size="lg" :disabled="loading">
                            <div v-if="loading" class="flex items-center">
                                <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                                <div>Creating</div>
                            </div>
                            <div v-else>Create</div>
                        </Button>
                    </DialogFooter>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
