<template>
    <div>
        <Navbar />

        <div class="w-full min-h-screen container mx-auto flex flex-col max-w-6xl bg-white my-4 px-6 py-4 text-gray-500 rounded-t-lg">

            <a href="/" class="hover:underline text-red-400"><font-awesome-icon :icon="[ 'far', 'arrow-alt-circle-left' ]" /> Voltar</a>

            <div class="flex flex-col md:flex-row">
                <div class="p-4 w-full">
                    <img class="w-full" :src="$page.props.categoria[0].capa" />
                </div>
            </div>

            <div class="mt-4 mx-4">
                <p class="text-2xl font-bold">{{$page.props.categoria[0].titulo}}</p>
                <p class="mt-2 text-lg">{{$page.props.categoria[0].resumo}}</p>
            </div>

            <div class="mt-4 mx-4" >
                <p v-html="$page.props.categoria[0].texto" class="my-2"></p>
            </div>


            <div class="mt-8">
                <div class="p-4 flex flex-col sm:grid sm:grid-cols-3 sm:gap-8">
                    <!-- GRID PRODUTO -->
                    <div v-for="(produto, index) in $page.props.categoria[0].produtos" :key="produto.id" class="my-4 sm:my-0 p-2 flex flex-col cursor-pointer">
                        <a :href="route('detalhes.produto', produto.slug)" class="cursor-pointer">
                            <!-- <img :src="produto.url_foto">-->
                            <div class="my-4 relative flex flex-col "><img class="object-cover h-64 w-full rounded-2xl shadow " :src="carregaImagem(produto.capa)" /></div>
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
    name: "Detalhes",
    props: {
        categoria: Array,
        produto: Array,

    },
    components: {
        Navbar,
        SearchFilter,
        Footer
    },
    data(){
        return {
            capa: '',
        }
    },
    methods: {
        carregaImagem(slug){
            var url = slug.split('public/');
            return '../storage/'+url[1];
        },
    }

}
</script>

<style scoped>

</style>
