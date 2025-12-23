<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

interface Props {
    user?: Domain.User.Data.UserData | null
}

const props = defineProps<Props>()

const isCreate = !props.user

const loading = ref(false)

const form = useForm<Domain.User.Data.UserFormData>({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    password: '',
    clinic_id: props.user?.clinic_id ?? '',
})

const temp = ref('')
const temp2 = ref('')

const submit = () => {
    loading.value = true

    // if (isCreate) {
    //     form.post(StoreClinicController().url)
    //     return
    // }

    // form.put(UpdateClinicController(props.user!.id).url)
}
</script>

<template>
    <Head title="Create Clinic" />

    <AppLayout>
        <div class="mx-auto w-full max-w-4xl px-6 py-4">
            <div class="relative flex-1">
                <div class="mb-10 border-b border-slate-200 pb-4">
                    <h1 class="text-3xl font-bold tracking-tight">{{ isCreate ? 'Add' : 'Update' }} Clinic</h1>
                </div>

                <form @submit.prevent="submit">
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
                                    <Label for="clinic_name">Name</Label>
                                    <Input id="clinic_name" v-model="form.name" placeholder="Enter a users name" />
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
                                <h2 class="text-xl font-medium tracking-tight">Commission</h2>
                                <p class="pt-1 text-sm text-slate-600">Define the commission percentage for this clinic.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <Label for="clinic_name">Commission rate (%)</Label>
                                    <Input id="clinic_name" v-model="form.commission_rate" placeholder="Enter a commission rate percentage" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <DialogFooter class="mt-10">
                        <Button type="submit" size="lg" :disabled="loading">
                            <div v-if="loading" class="flex items-center">
                                <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                                <div>{{ isCreate ? 'Creating' : 'Updating' }}</div>
                            </div>
                            <div v-else>{{ isCreate ? 'Create' : 'Update' }}</div>
                        </Button>
                    </DialogFooter>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
