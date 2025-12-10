<script setup lang="ts">
import ClientIndexController from '@/actions/App/Http/Controllers/Client/ClientIndexController'
import ClinicIndexController from '@/actions/App/Http/Controllers/Clinic/ClinicIndexController'
import CommissionIndexController from '@/actions/App/Http/Controllers/Commission/CommissionIndexController'
import CouponIndexController from '@/actions/App/Http/Controllers/Coupon/CouponIndexController'
import OrderIndexController from '@/actions/App/Http/Controllers/Order/OrderIndexController'
import ShopifyIndexController from '@/actions/App/Http/Controllers/Shopify/ShopifyIndexController'
import UserIndexController from '@/actions/App/Http/Controllers/User/UserIndexController'
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar'
import { dashboard } from '@/routes'
import { type NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { ChartNoAxesCombined, Handshake, LayoutGrid, Settings, Store, Tags, Truck, Users, Zap } from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Commissions',
        href: CommissionIndexController().url,
        icon: ChartNoAxesCombined,
    },
    {
        title: 'Orders',
        href: OrderIndexController().url,
        icon: Truck,
    },
    {
        title: 'Clinics',
        href: ClinicIndexController().url,
        icon: Store,
    },
    {
        title: 'Users',
        href: UserIndexController().url,
        icon: Users,
    },
    {
        title: 'Coupons',
        href: CouponIndexController().url,
        icon: Tags,
    },
    {
        title: 'Clients',
        href: ClientIndexController().url,
        icon: Handshake,
    },
    {
        title: 'Shopify',
        href: ShopifyIndexController().url,
        icon: Zap,
    },
    {
        title: 'Settings',
        href: '/settings',
        icon: Settings,
    },
]

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
]
</script>

<template>
    <Sidebar collapsible="icon" variant="sidebar">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
