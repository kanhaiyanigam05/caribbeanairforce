import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/js/compose.js",
                "resources/js/echo.js",
            ],
            refresh: true,
        }),
    ],
});
