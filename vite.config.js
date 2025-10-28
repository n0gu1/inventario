// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: '/build/', // URLs relativas correctas para producción
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',     // Carpeta de salida para assets
        manifest: true,             // Laravel necesita este archivo
        manifestDir: '.',           
        emptyOutDir: true,          // Limpia /build antes de generar
        rollupOptions: {
            input: 'resources/js/app.js', // Punto de entrada
        },
    },
});
