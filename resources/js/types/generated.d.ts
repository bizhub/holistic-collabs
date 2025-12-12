declare namespace Domain.Client.Data {
    export type ClientData = {
        id: string
        name: string
        email: string
    }
}
declare namespace Domain.Clinic.Data {
    export type ClinicData = {
        id: string
        name: string
        coupons: any | null
    }
    export type ClinicFormData = {
        name: string
        coupon_shopify_id: string
        commission_rate: number
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
    }
}
declare namespace Domain.Order.Data {
    export type OrderData = {
        id: string
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
    export type UserData = {
        id: string
    }
}
