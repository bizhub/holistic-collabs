import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'
import Icons from 'unplugin-icons/vite'
import { run } from 'vite-plugin-run'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            dirs: ['resources/js/components', 'resources/js/layouts'],
            dts: 'resources/js/types/components.d.ts',
            resolvers: [],
        }),
        AutoImport({
            dts: 'resources/js/types/auto-imports.d.ts',
            imports: [
                'vue',
                '@vueuse/core',
                'pinia',
                {
                    '@inertiajs/vue3': ['router', 'usePage', 'useForm'],
                },
            ],
            defaultExportByFilename: true,
            dirs: ['resources/js/services'],
        }),
        Icons({
            autoInstall: true,
        }),
        run([
            {
                name: 'typescript transform',
                run: ['php', 'artisan', 'typescript:transform'],
                pattern: ['app/**/*Data.php', 'app/**/Enums/**/*.php', 'app/**/*Request.php'],
            },
        ]),
    ],
});
