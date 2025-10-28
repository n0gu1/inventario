import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: '/build/', // 👈 asegúrate de que Vite genere URLs relativas correctas
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // 👈 genera los assets y manifest aquí
        manifest: true,         // 👈 Laravel necesita este manifest en producción
        rollupOptions: {
            input: 'resources/js/app.js', // 👈 punto de entrada
        },
    },
});
