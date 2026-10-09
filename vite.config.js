import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Grenze Gotisch', {
                    weights: [600, 800],
                    subsets: ['latin', 'latin-ext'],
                }),
                bunny('Cinzel', {
                    weights: [700],
                    subsets: ['latin', 'latin-ext'],
                }),
                bunny('Atkinson Hyperlegible', {
                    weights: [400, 700],
                    subsets: ['latin', 'latin-ext'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
