// import { createApp, h } from "vue";
// import { createInertiaApp } from "@inertiajs/inertia-vue3";
// import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// createInertiaApp({
//     resolve: (name) =>
//         resolvePageComponent(
//             `./Pages/${name}.vue`,
//             import.meta.glob("./Pages/**/*.vue")
//         ),
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el);
//     },
// });

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

createInertiaApp({
    resolve: (name) => {
        const pageImport = pages[`./Pages/${name}.vue`];
        if (!pageImport) throw new Error(`Component "${name}" not found`);
        return pageImport; // Explicit type assertion
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
