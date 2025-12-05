<script setup lang="ts">
import StoreClinicController from '@/actions/App/Http/Controllers/Clinic/StoreClinicController'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

const breadcrumbs: BreadcrumbItem[] = [
    // {
    //     title: 'Integrations',
    //     href: IntegrationIndexController().url,
    // },
]

const loading = ref(false)

const form = useForm<Domain.Clinic.Requests.ClinicRequest>({
    name: '',
})

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
                <div class="mb-10">
                    <h1 class="text-3xl font-bold tracking-tight">Add Clinic</h1>
                    <p class="pt-1 text-slate-600">Integrate Fulfillr with your existing tools in just a few steps</p>
                </div>

                <form @submit.prevent="connectIntegration">
                    <div class="space-y-10">
                        <div>
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Connection Settings</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Enter your API credentials from your Unleashed account.<br />
                                    Don't know where to find these? Learn how to get your
                                    <span class="underline">Unleashed API key →</span>
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <Label for="name">Clinic Name</Label>
                                    <Input id="name" v-model="form.name" placeholder="Enter a clinics name" />
                                </div>
                            </div>
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
