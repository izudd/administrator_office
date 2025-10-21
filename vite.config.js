import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"], // sesuaikan
            refresh: true,
        }),
        react(), // kalau pakai React
    ],
    base: "/", // ← PENTING: jangan '/public/' atau '/build/'
    build: {
        outDir: "public/build",
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
