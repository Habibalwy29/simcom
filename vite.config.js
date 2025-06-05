import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Pastikan jalur ke file CSS Anda benar
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // Hapus atau komentari bagian 'css.postcss' jika Anda ingin postcss.config.js yang mengatur plugin
    // css: {
    //     postcss: {
    //         plugins: [
    //             // Hapus ini jika Anda mengandalkan postcss.config.js
    //             // tailwindcss(),
    //         ],
    //     },
    // },
});