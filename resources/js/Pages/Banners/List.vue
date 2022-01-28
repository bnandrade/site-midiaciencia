<template>
    <jet-action-section class="sm:mt-0">

        <template #content>
            <div class="flex justify-between mb-4">
                <h1 class="my-2 font-semibold">Banner</h1>

            </div>

            <div class="space-y-6" v-if="banners.data.length > 0">
                <div class="flex" >
                    <div class="w-full flex flex-col items-start ">
                        <table class="table-fixed text-left w-full">
                            <thead>
                            <tr>
                                <th class="w-2/6 border border-light-blue-500 px-4 py-2 text-light-blue-600">
                                    <div class="flex justify-between">
                                        Banner
                                        <div class="flex flex-col ">
                                            <div @click="order('nameC')"  class=" cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-up" v-tooltip="'Ordem crescente'"></i></div>
                                            <div @click="order('nameD')"  class="cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-down " v-tooltip="'Ordem decrescente'"></i></div>
                                        </div>
                                    </div>
                                </th>
                                <th class="w-2/6 border border-light-blue-500 px-4 py-2 text-light-blue-600">
                                    <div class="flex justify-between">
                                        Título
                                        <div class="flex flex-col ">
                                            <div @click="order('nameC')"  class=" cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-up" v-tooltip="'Ordem crescente'"></i></div>
                                            <div @click="order('nameD')"  class="cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-down " v-tooltip="'Ordem decrescente'"></i></div>
                                        </div>
                                    </div>
                                </th>
                                <th class="w-2/6 border border-light-blue-500 px-4 py-2 text-light-blue-600">
                                    <div class="flex justify-between">
                                        Subtítulo
                                        <div class="flex flex-col ">
                                            <div @click="order('nameC')"  class=" cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-up" v-tooltip="'Ordem crescente'"></i></div>
                                            <div @click="order('nameD')"  class="cursor-pointer hover:text-sistema-primary h-2"><i class="fas fa-sort-down " v-tooltip="'Ordem decrescente'"></i></div>
                                        </div>
                                    </div>
                                </th>
                                <th class="w-2/6 border border-light-blue-500 px-4 py-2 text-light-blue-600">
                                    <div class="flex justify-between">
                                        URL
                                    </div>
                                </th>
                                <th class="w-1/6 border border-light-blue-500 px-4 py-2 text-light-blue-600 text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(banner, index) in banners.data" class="hover:bg-gray-100" :key="banner.id" >
                                <td class=" border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium"><img :src="banner.imagem" /></td>
                                <td class=" border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ banner.titulo }}</td>
                                <td class=" border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ banner.subtitulo }}</td>
                                <td class=" border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium"><a :href="banner.url" target="_blank">clique aqui</a></td>
                                <td class=" border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium text-center"><item :banner="banner"></item></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="flex justify-center">
                    <pagination :links="banners.links"></pagination>
                </div>
            </div>
        </template>

    </jet-action-section>
</template>

<script>

import JetActionSection from '@/Jetstream/ActionSection'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import Pagination from '@/Components/Pagination'
import SearchFilter from '@/Components/SearchFilter'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import JetInput from '@/Jetstream/Input'
import Item from "./Item"

export default {
    components: {
        JetActionSection,
        JetSectionBorder,
        Pagination,
        SearchFilter,
        JetInput,
        Item,
    },
    props: {
        'banners': Object,
    },
    data() {
        return {

        }
    },

}
</script>

<style scoped>

</style>
