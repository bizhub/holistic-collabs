declare namespace Domain.Client.Data {
    export type ClientData = {
        id: string
        name: string
        email: string
        clinic: Domain.Clinic.Data.ClinicData | null
        commissions_count: number | null
    }
}
declare namespace Domain.Clinic.Data {
    export type ClinicData = {
        id: string
        name: string
        commission_rate: number
        coupons: any | null
        commissions_count: number | null
        clients_count: number | null
        users_count: number | null
    }
    export type ClinicFormData = {
        name: string
        coupon_shopify_id: string | null
        commission_rate: number
    }
    export type SharedClinicData = {
        name: string
    }
}
declare namespace Domain.Commission.Data {
    export type CommissionData = {
        id: string
        status: Domain.Commission.Enums.CommissionStatus
        amount: number
    }
    export type CommissionGroupData = {
        clinic: Domain.Clinic.Data.ClinicData
        commissions: Array<Domain.Commission.Data.CommissionData>
    }
}
declare namespace Domain.Commission.Enums {
    export type CommissionStatus = 'paid' | 'pending'
}
declare namespace Domain.Coupon.Data {
    export type AvailableCouponData = {
        code: string
        shopify_id: string
    }
    export type CouponData = {
        id: string
        code: string
        clinic: Domain.Clinic.Data.ClinicData | null
        commissions_count: number | null
    }
}
declare namespace Domain.Invite.Data {
    export type AcceptInviteData = {
        name: any
        email: any
        password: any
    }
    export type CreateInviteData = {
        clinic_id: string
        name: string
        email: string
    }
    export type InviteData = {
        id: string
        name: string
        email: string
        clinic: Domain.Clinic.Data.ClinicData | null
    }
}
declare namespace Domain.Order.Data {
    export type OrderData = {
        id: string
        coupon_code: string | null
        subtotal_price: number
        clinic: Domain.Clinic.Data.ClinicData | null
        client: Domain.Client.Data.ClientData | null
    }
}
declare namespace Domain.Shopify.Context {
    export type CouponContext = {
        coupon: any | null
        amount: number
    }
}
declare namespace Domain.Shopify.Data {
    export type ShopifyActivityData = {
        id: string
        description: string
        created_at: any
    }
    export type ShopifyData = {
        status: Domain.Shopify.Enums.ConnectionStatus
        url: string
    }
}
declare namespace Domain.Shopify.Enums {
    export type ConnectionStatus = 'connected' | 'disconnected'
    export type WebhookStatus = 'connected' | 'partial' | 'disconnected' | 'error'
}
declare namespace Domain.User.Data {
    export type SharedUserData = {
        is_admin: boolean
        name: string
        email: string
    }
    export type UserData = {
        id: string
        is_admin: boolean
        clinic_id: string | null
        name: string
        email: string
        clinic: Domain.Clinic.Data.ClinicData | null
    }
}
