<template>
    <app-layout>
        <div class="w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.auth.user.can['produto-criar'] || $page.props.auth.user.role['Super.Admin']">
                    <div v-if="!formNewVisible" class="flex items-center justify-end px-4 py-3 text-right sm:px-0 ">
                        <button class="inline-flex items-center p-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" @click="formNewVisible = true" v-tooltip="'Cadastrar Categoria'">
                            <font-awesome-icon :icon="[ 'far', 'plus-square' ]" /></button>
                    </div>

                    <div v-if="formNewVisible" class="flex items-center justify-end px-4 py-3 text-right sm:px-0 ">
                        <button class="inline-flex items-center p-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" @click="formNewVisible = false" v-tooltip="'Fechar formulário'">
                            <font-awesome-icon :icon="[ 'far', 'minus-square' ]" /></button>
                    </div>
                </div>
                <div v-else class="flex items-center justify-end px-4 py-3 text-right sm:px-0 ">
                    <button class="inline-flex items-center p-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                            v-tooltip="'Você não tem permissão de Criar'">
                        <font-awesome-icon :icon="[ 'far', 'times-circle' ]" />
                    </button>
                </div>

                <new-categoria  v-if="formNewVisible" class="mb-10"></new-categoria>
                <list-categorias :categorias="categorias" :filters="filters"
                               v-if="$page.props.auth.user.can['produto-listar'] || $page.props.auth.user.role['Super.Admin']"></list-categorias>
                <button v-else
                        class="cursor-pointer text-sm text-red-200 focus:outline-none mx-2"
                        v-tooltip="'Você não tem permissão de Listar'">
                    <i class="fas fa-lock"></i>
                </button>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import NewCategoria from "./CategoriaNew"
import ListCategorias from "./CategoriaList"

export default {
    props: {
        'categorias': Object,
        'filters': Object,
    },
    components: {
        AppLayout,
        JetSectionBorder,
        NewCategoria,
        ListCategorias,
    },
    data(){
        return {
            formNewVisible:false,
        }
    },
}
</script>
