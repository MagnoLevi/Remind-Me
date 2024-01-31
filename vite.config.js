import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/base_styles.css',
                'resources/css/login.css',

                'resources/js/app.js',
                'resources/js/remind_me/top_menu.js',
                'resources/js/remind_me/login.js',
                'resources/js/remind_me/to_do.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ]
});
