<template>
    <div class="bg-white rounded-lg text-sm hidden md:flex md:flex-col w-64 h-screen px-4 py-4 border-r dark:bg-gray-800 dark:border-gray-600" v-if="showMenu">

        <!--<div class="relative mt-2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
            <input type="text" class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-red-500 dark:focus:border-red-500 focus:outline-none focus:ring-red-500" placeholder="Pesquisar"/>
        </div>-->

        <i class="fas fa-long-arrow-alt-left cursor-pointer" v-tooltip="'Fechar menu'" @click="showMenu = false"></i>
        <div class="flex flex-col justify-between flex-1 mt-2">
            <nav>
                <sidebar-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                    <span class="mx-2 font-bold">Página inicial</span>
                </sidebar-nav-link>

                <hr class="my-6 dark:border-gray-600" />

                <sidebar-nav-link :href="route('users')" :active="route().current('users')">
                    <font-awesome-icon :icon="[ 'far', 'user' ]" />
                    <span class="mx-2 font-medium">Usuários</span>
                </sidebar-nav-link>

                <sidebar-nav-link :href="route('banners')" :active="route().current('banners')">
                    <font-awesome-icon :icon="[ 'far', 'list-alt' ]" />
                    <span class="mx-2 font-medium">Banner</span>
                </sidebar-nav-link>

                <sidebar-nav-link :href="route('produtos')" :active="route().current('produtos')">
                    <font-awesome-icon :icon="[ 'far', 'list-alt' ]" />
                    <span class="mx-2 font-medium">Produtos</span>
                </sidebar-nav-link>

                <hr class="my-6 dark:border-gray-600" />

            </nav>

        </div>
    </div>

    <div class="bg-white rounded-lg text-sm hidden md:flex h-8 p-3 border-r dark:bg-gray-800 dark:border-gray-600 cursor-pointer" v-tooltip="'Abrir menu'" @click="showMenu = true" v-else><i class="fas fa-bars"></i></div>
</template>

<script>
import SidebarNavLink from './SidebarNavLink'

export default {
    name: "Sidebar",

    components: {
        SidebarNavLink,
    },
    data(){
        return {
            showMenu:true,
        }
    },

}
</script>

<style scoped>

</style>
