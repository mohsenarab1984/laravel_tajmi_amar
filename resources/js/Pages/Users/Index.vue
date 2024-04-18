<template>
    <Head> <title>Users</title> </Head>

    <div class="flex justify-between">
        <h2>Users</h2>
        <input
            v-model="search"
            type="text"
            name=""
            id=""
            placeholder="Search..."
            class="x-2 border rounded-lg"
        />
    </div>
    <!-- <ul>
        <li v-for="user in users" :key="user.id" v-text="user.name"></li>
    </ul> -->
    <table class="table-auto">
        <thead>
            <tr>
                <!-- <th>Song</th>
      <th>Artist</th>
      <th>Year</th> -->
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users.data" :key="user.id" style="">
                <td>{{ user.name }}</td>
                <td class=" " style="margin-left: 100px">Edit</td>
                <td style="margin-left: 30px; display: block">{{ user.id }}</td>
            </tr>
        </tbody>
    </table>
    <Pagination :links="users.links" class="mt-5" />
    <!-- <div style="display: flex; gap: 30px">
        <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in users.links"
            :href="link.url"
            :key="link.label"
            v-html="link.label"
            :class="link.url ? '' : 'text-gray-500'"
        />
    </div> -->
</template>
<script setup>
import Pagination from "@js/shared/Pagination.vue";
import { ref, watch } from "vue";
// import { Link } from "@inertiajs/vue3";
import Nav from "@js/shared/Nav.vue";

////// import { Head } from "@inertiajs/vue3"; /// ok
/////// import Layout from "../shared/Layout.vue"; //// ok
/////// defineOptions({ layout: Layout }); //// ok

// import { Inertia } from "@inertiajs/inertia";// ok
import { router } from "@inertiajs/vue3";
// const { post } = useInertia();
const props = defineProps({ users: Object, filters: Object });
const search = ref(props.filters.search);
watch(search, (value) => {
    console.log("value: ", value);
    router.get(
        "/users",
        { search: value },
        { preserveState: true, replace: true }
    );
});
console.log("users: ", props.users);
console.log("users.links: ", props.users.links);
</script>
