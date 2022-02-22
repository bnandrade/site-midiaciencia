<template>
    <div>
        <Navbar />

        <div class="w-full min-h-screen container mx-auto flex flex-col max-w-6xl bg-white my-4 px-6 py-4 text-gray-500 rounded-t-lg">

            <a href="/" class="hover:underline text-red-400"><font-awesome-icon :icon="[ 'far', 'arrow-alt-circle-left' ]" /> Voltar</a>

            <div class="flex flex-col md:flex-row">
                <div class="p-4 w-full">
                    <img class="w-full" :src="$page.props.produto[0].capa" />
                </div>
            </div>

            <div class="mt-4 ">
                <p class="text-2xl font-bold">{{$page.props.produto[0].titulo}}</p>
                <p class="mt-2 text-lg">{{$page.props.produto[0].resumo}}</p>
            </div>

            <div class="mt-4 " >
                <p v-html="$page.props.produto[0].texto" class="my-2"></p>
            </div>
            <div class="mt-4 border-b mb-6" >
                <div v-if="$page.props.produto[0].fotos" class="w-full mt-4 flex flex-wrap">
                    <div v-for="(foto, index) in $page.props.produto[0].fotos" class=" p-2 rounded mr-1 w-64" :key="foto.id" >
                        <img  :src="foto.imagem" />

                    </div>
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
        produto: Array,
    },
    components: {
        Navbar,
        SearchFilter,
        Footer
    },
    data(){
        return {
        }
    },

}
</script>

<style scoped>

</style>
