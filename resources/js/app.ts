import { createInertiaApp } from '@inertiajs/vue3'
import { configureEcho } from '@laravel/echo-vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { initializeTheme } from './composables/useAppearance'

import Vue3Toastify, { toast, type ToastContainerOptions, type ToastOptions } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import '../css/app.css'

configureEcho({
    broadcaster: 'reverb',
})

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: title => (title ? `${title} - ${appName}` : appName),
    resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Vue3Toastify, {
                autoClose: 4000,
            } as ToastContainerOptions)
            .mount(el)

        router.on('flash', event => {
            if (event.detail.flash) {
                toast.success(event.detail.flash.success, {
                    // hideProgressBar: true,
                    autoClose: 4000,
                    transition: toast.TRANSITIONS.SLIDE,
                    position: toast.POSITION.BOTTOM_RIGHT,
                } as ToastOptions)
            }
        })
    },
    progress: {
        color: '#4B5563',
    },
})

// This will set light / dark mode on page load...
initializeTheme()
