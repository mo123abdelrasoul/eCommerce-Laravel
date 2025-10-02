import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/adminlte.css',
                'resources/js/app.js',
                'resources/js/adminlte.js',
                'resources/js/home.js',
                'resources/js/checkout.js',
                'resources/js/cart.js',
            ],
            refresh: true,
        }),
    ],
});
