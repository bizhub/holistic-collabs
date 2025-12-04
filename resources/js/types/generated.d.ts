declare namespace Domain.Client.Data {
    export type ClientData = {
        id: string
    }
}
declare namespace Domain.Clinic.Data {
    export type ClinicData = {
        id: string
        name: string
    }
}
declare namespace Domain.Commission.Data {
    export type CommissionData = {
        id: string
    }
    export type CommissionGroupData = {
        clinic: Domain.Clinic.Data.ClinicData
        commissions: Array<Domain.Commission.Data.CommissionData>
    }
}
declare namespace Domain.Coupon.Data {
    export type CouponData = {
        id: string
    }
}
declare namespace Domain.Order.Data {
    export type OrderData = {
        id: string
    }
}
declare namespace Domain.Shopify.Enums {
    export type ConnectionStatus = 'active' | 'disconnected'
}
declare namespace Domain.User.Data {
    export type UserData = {
        id: string
    }
}
