<script setup lang="ts">
import ClientIndexController from '@/actions/App/Http/Controllers/Admin/Client/ClientIndexController'
import ClinicIndexController from '@/actions/App/Http/Controllers/Admin/Clinic/ClinicIndexController'
import CommissionIndexController from '@/actions/App/Http/Controllers/Admin/Commission/CommissionIndexController'
import CouponIndexController from '@/actions/App/Http/Controllers/Admin/Coupon/CouponIndexController'
import DashboardIndexController from '@/actions/App/Http/Controllers/Admin/Dashboard/DashboardIndexController'
import InviteIndexController from '@/actions/App/Http/Controllers/Admin/Invite/InviteIndexController'
import OrderIndexController from '@/actions/App/Http/Controllers/Admin/Order/OrderIndexController'
import ShopifyIndexController from '@/actions/App/Http/Controllers/Admin/Shopify/ShopifyIndexController'
import UserIndexController from '@/actions/App/Http/Controllers/Admin/User/UserIndexController'
import ClinicDashboardIndexController from '@/actions/App/Http/Controllers/Clinic/Dashboard/DashboardIndexController'
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar'
import { type NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { ChartNoAxesCombined, Handshake, LayoutGrid, Mails, Settings, Store, Tags, Truck, Users, Zap } from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'

const page = usePage()

const user = computed(() => page.props.auth.user)
// const clinic = computed(() => page.props.auth.clinic)

const mainNavItems: NavItem[] = user.value.is_admin
    ? [
          //   {
          //       title: 'Dashboard',
          //       href: DashboardIndexController().url,
          //       icon: LayoutGrid,
          //   },
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
              title: 'Invites',
              href: InviteIndexController().url,
              icon: Mails,
          },
          {
              title: 'Clients',
              href: ClientIndexController().url,
              icon: Handshake,
          },
          {
              title: 'Commissions',
              href: CommissionIndexController().url,
              icon: ChartNoAxesCombined,
          },
          {
              title: 'Coupons',
              href: CouponIndexController().url,
              icon: Tags,
          },
          {
              title: 'Orders',
              href: OrderIndexController().url,
              icon: Truck,
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
    : [
          {
              title: 'Dashboard',
              href: ClinicDashboardIndexController().url,
              icon: LayoutGrid,
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
                        <Link :href="DashboardIndexController()">
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
