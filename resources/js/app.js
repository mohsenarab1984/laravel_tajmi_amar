import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Link, Head } from "@inertiajs/vue3";
import Layout from "@js/shared/Layout.vue";
import Layout_Admin from "@js/shared/Layout_Admin.vue";
import 'vue3-toastify/dist/index.css'; // Import the css  
import '../css/app.css'

const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

createInertiaApp({
    resolve: (name, route) => {
        // const pageImport = pages[`./Pages/${name}.vue`];
        // if (!pageImport) throw new Error(`Component "${name}" not found`);
        // return pageImport; // Explicit type assertion
       // console.log('1102 Navigating to:', name); 

       

       // console.log('1102 Navigating to component:', name); // Component name  
       

        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        ////////////////
        // if (name.startsWith('Admin/')) {  
        //     page.default.layout = page.default.layout || Layout_Admin;  
        // } else {  
        //     page.default.layout = page.default.layout || Layout;  
        // }  

        page.default.layout = page.default.layout || Layout;  

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
    title: (title) => "My App -" + title,
});
