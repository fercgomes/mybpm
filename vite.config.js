import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/modeler.css",
                "resources/js/app.js",
                "resources/js/modeler.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
});
