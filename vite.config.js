import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': [
                        'axios',
                        '@coreui/coreui',
                    ],
                    'charts': [
                        'chart.js',
                        '@coreui/chartjs',
                        '@coreui/utils',
                    ],
                },
            },
        },
        chunkSizeWarningLimit: 1000,
    },
    optimizeDeps: {
        exclude: [
            '@coreui/icons/svg/flag/*.svg',
        ],
    },
});
