<script setup lang="ts">
import StoreUserController from '@/actions/App/Http/Controllers/Admin/User/StoreUserController'
import { Head } from '@inertiajs/vue3'
import { Loader2 } from 'lucide-vue-next'

interface Props {
    user?: Domain.User.Data.UserData | null
    clinics: Domain.Clinic.Data.ClinicData[]
}

const props = defineProps<Props>()

const isCreate = !props.user

const loading = ref(false)

const form = useForm<Domain.User.Data.UserFormData>({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    password: '',
    password_confirmation: '',
    clinic_id: props.user?.clinic_id ?? '',
    is_admin: false,
})

const role = ref('clinic')

const submit = () => {
    loading.value = true

    if (isCreate) {
        form.transform(data => {
            return {
                ...data,
                is_admin: role.value == 'admin',
            }
        }).post(StoreUserController().url, {
            onError() {
                loading.value = false
            },
        })
    }

    // form.put(UpdateClinicController(props.user!.id).url)
}
</script>

<template>
    <Head title="Create Clinic" />

    <AppLayout>
        <div class="mx-auto w-full max-w-4xl px-6 py-4">
            <div class="relative flex-1">
                <div class="mb-10 border-b border-zinc-200 pb-4">
                    <h1 class="text-3xl font-bold tracking-tight">{{ isCreate ? 'Add' : 'Update' }} User</h1>
                </div>

                <form @submit.prevent="submit">
                    <div class="space-y-8">
                        <div class="">
                            <div class="mb-5">
                                <h2 class="text-xl font-medium tracking-tight">Details</h2>
                                <!-- <p class="pt-1 text-sm text-zinc-600">
                                    Add a new clinic and set up their referral code so new<br />
                                    clients can be automatically linked and tracked for future commissions.
                                </p> -->
                            </div>

                            <div class="space-y-6">
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="role">Role</Label>
                                        <Select v-model="role">
                                            <SelectTrigger>
                                                <SelectValue placeholder="Select a role" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="clinic">Clinic</SelectItem>
                                                <SelectItem value="admin">Admin</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="clinic_id">Clinic</Label>
                                        <Select v-model="form.clinic_id" :disabled="clinics.length == 0 || role == 'admin'">
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
                                </div>
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="name">Name</Label>
                                        <Input id="name" v-model="form.name" placeholder="Enter a name" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="email">Email</Label>
                                        <Input id="email" v-model="form.email" placeholder="Enter an email" />
                                    </div>
                                </div>
                                <div class="flex space-x-6">
                                    <div class="flex-1 space-y-2">
                                        <Label for="password">Password</Label>
                                        <Input id="password" type="password" v-model="form.password" placeholder="••••••••••••" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <Label for="confirm_password">Confirm Password</Label>
                                        <Input
                                            id="confirm_password"
                                            type="password"
                                            v-model="form.password_confirmation"
                                            placeholder="••••••••••••" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <Button type="submit" size="lg" :disabled="loading">
                            <div v-if="loading" class="flex items-center">
                                <Loader2 class="mr-2 h-4 w-4 animate-spin" />
                                <div>{{ isCreate ? 'Creating' : 'Updating' }}</div>
                            </div>
                            <div v-else>{{ isCreate ? 'Create' : 'Update' }}</div>
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
