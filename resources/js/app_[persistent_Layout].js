import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
// import "bootstrap";
// @import "../sass/app.scss";

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
