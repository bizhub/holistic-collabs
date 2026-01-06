<script setup lang="ts">
import StoreInviteController from '@/actions/App/Http/Controllers/Admin/Invite/StoreInviteController'
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

interface Props {
    clinics: Domain.Clinic.Data.ClinicData[]
}

defineProps<Props>()

const loading = ref(false)

const form = useForm<Domain.Invite.Data.CreateInviteData>({
    clinic_id: '',
    name: '',
    email: '',
})

const submit = () => {
    loading.value = true

    form.post(StoreInviteController().url, {
        onError() {
            loading.value = false
        },
    })
}
</script>

<template>
    <Head title="Create Invitation" />

    <AppLayout>
        <div class="mx-auto w-full max-w-4xl px-6 py-4">
            <div class="relative flex-1">
                <div class="mb-10 border-b border-slate-200 pb-4">
                    <h1 class="text-3xl font-bold tracking-tight">Create Invitation</h1>
                </div>

                <form @submit.prevent="submit">
                    <div class="space-y-8">
                        <div class="">
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Clinic details</h2>
                                <p class="pt-1 text-sm text-slate-600">
                                    Add a new clinic and set up their referral code so new<br />
                                    clients can be automatically linked and tracked for future commissions.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <Label for="clinic_name">Clinic</Label>
                                    <Select v-model="form.clinic_id" :disabled="clinics.length == 0">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Select a clinic" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem v-for="clinic in clinics" :key="clinic.id" :value="clinic.id">
                                                {{ clinic.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="contact_name">Name</Label>
                                        <Input id="contact_name" v-model="form.name" placeholder="Enter a name" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="contact_email">Email</Label>
                                        <Input id="contact_email" v-model="form.email" placeholder="Enter a email" />
                                    </div>
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
                            <div v-else>Create & Send</div>
                        </Button>
                    </DialogFooter>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
