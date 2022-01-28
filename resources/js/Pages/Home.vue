<template>
    <div>
        <Navbar />

        <div class="w-full container mx-auto flex flex-col max-w-6xl bg-white my-4 px-6 py-4 text-gray-500 rounded-t-lg">

            <div class="relative  p-6">
                <div class="relative  font-medium ">
                    <img :src="$props.bannerImagem">
                    <div class="absolute top-0 left-0  bg-white  shadow-lg rounded-xl p-4 mt-4 ml-4 text-rose-50">
                        <div class="mt-4 p-6 max-w-lg">
                            <div class="mb-5">
                                <h1 class="text-5xl font-bold">{{$props.bannerTitulo}}</h1>
                                <p class="lead text-xl mt-8">{{$props.bannerSubtitulo}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="p-4 flex flex-col sm:grid sm:grid-cols-3 sm:gap-8">
                    <!-- GRID PRODUTO -->
                    <div v-for="(produto, index) in produtos" :key="produto.id" class="my-4 sm:my-0 p-2 flex flex-col cursor-pointer">
                        <a :href="route('detalhes.produto', produto.slug)" class="cursor-pointer">
                            <!-- <img :src="produto.url_foto">-->
                            <div class="my-4 relative flex flex-col "><img class="object-cover h-64 w-full rounded-2xl shadow " :src="produto.capa" /></div>
                            <h1 class="my-4 font-bold text-gray-800 text-2xl">{{ produto.titulo }}</h1>
                            <p class="text-gray-400">{{ produto.resumo }}</p>
                        </a>

                    </div>
                    <!-- GRID produto -->
                </div>
            </div>

        </div>

        <Footer />
    </div>
</template>

<script>

import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
import SearchFilter from '@/Components/SearchFilter'
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
    name: "Home",
    props: {
        bannerImagem: String,
        bannerTitulo: String,
        bannerSubtitulo: String,
        bannerUrl: String,
        produtos: Array,
        filters: Object
    },
    components: {
        Navbar,
        SearchFilter,
        Footer
    },
    data(){
        return {
            form: {
                search: this.filters.search,
                order: this.filters.order,
            },
        }
    },
    methods: {
        order(ord) {
            this.form.order = ord
        },
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
    watch: {
        form: {
            handler: _.debounce(function() {
                let query = pickBy(this.form);
                let route = this.route('home', Object.keys(query).length ? query : { remember: 'forget' });
                this.$inertia.get(route, {}, { preserveScroll: true, preserveState: true })
            }, 150),
            deep: true,
        },
    },
}
</script>

<style scoped>

</style>
