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
const temp2 = ref('')

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
        <div class="mx-auto w-full max-w-4xl px-6 py-4">
            <div class="relative flex-1">
                <div class="mb-10 border-b border-slate-200 pb-4">
                    <h1 class="text-3xl font-bold tracking-tight">Add Clinic</h1>
                </div>

                <form @submit.prevent="connectIntegration">
                    <div class="space-y-8">
                        <div class="border-b border-slate-200 pb-10">
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Clinic details</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Add a new clinic and set up their referral code so new<br />
                                    clients can be automatically linked and tracked for future commissions.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <Label for="clinic_name">Clinic Name</Label>
                                    <Input id="clinic_name" v-model="form.name" placeholder="Enter a clinics name" />
                                </div>
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="contact_name">Contact Name</Label>
                                        <Input id="contact_name" v-model="temp" placeholder="Enter a contact name" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="contact_email">Email</Label>
                                        <Input id="contact_email" v-model="temp2" placeholder="Enter a contact email" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Coupon Code</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Choose an available Shopify discount code. Can't find the one you need? Refresh the list.
                                </p>
                                <p class="pt-0.5 text-sm text-slate-600">This field is optional, you can always add coupons later.</p>
                                <p class="pt-0.5 text-sm text-slate-600">Note: each discount code can only be assigned to a single clinic.</p>
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
