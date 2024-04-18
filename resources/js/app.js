import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Link, Head } from "@inertiajs/vue3";
import Layout from "@js/shared/Layout.vue";
import Layout_Admin from "@js/shared/Layout_Admin.vue";
// import CKEditor from "@ckeditor/ckeditor5-vue";

// import "../assets/css/vendor/bootstrap.min.css";
// import "../assets/css/swiper-bundle.min.css";
// import "../assets/css/slick.css";
// import "../assets/css/ionicons.min.css";
// import "../assets/css/font.awesome.css";
// import "../assets/css/icofont.min.css";
// import "../assets/css/elegant-icons.min.css";
// import "../assets/css/animate.css";
// import "../assets/css/nice-select.css";
// import "../assets/css/magnific-popup.css";
// import "../assets/css/jquery-ui.min.css";
// import "../assets/css/style.css";

// import "../assets/js/vendor/modernizr-3.7.1.min.js";

// import "../assets/js/vendor/jquery-3.4.1.min.js";
// import "../assets/js/vendor/popper.js";
// import "../assets/js/vendor/bootstrap.min.js";
// import "../assets/js/swiper-bundle.min.js";
// import "../assets/js/slick.min.js";
// import "../assets/js/wow.min.js";
// import "../assets/js/jquery.scrollup.min.js";
// import "../assets/js/images-loaded.min.js";
// import "../assets/js/jquery.nice-select.js";
// import "../assets/js/jquery.magnific-popup.min.js";
// import "../assets/js/mailchimp-ajax.js";
// import "../assets/js/jquery.counterup.min.js";
// import "../assets/js/jquery-waypoints.js";
// import "../assets/js/jquery-ui.min.js";
// import "../assets/js/ajax-mail.js";

// import "../assets/js/main.js";

// import "bootstrap";
// @import "../sass/app.scss";


const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

createInertiaApp({
    resolve: (name) => {
        // const pageImport = pages[`./Pages/${name}.vue`];
        // if (!pageImport) throw new Error(`Component "${name}" not found`);
        // return pageImport; // Explicit type assertion
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        ////////////////
        if (name.startsWith('Admin/')){
            page.default.layout ??= Layout_Admin;
           }else{
            page.default.layout = page.default.layout || Layout;
           }
           ///////////////////////////////
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
