// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  base: '/build/',
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  build: {
    outDir: 'public/build',
    manifest: true,
    emptyOutDir: true,
    rollupOptions: {
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
    },
  },
  // 👇 esto evita que se cree la subcarpeta .vite/
  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
});
