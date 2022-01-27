<template>
    <div>
        <toast :toast="$page.props.toast" :popstate="$page.popstate"></toast>

        <div class="min-h-screen pb-8 bg-gray-100">
            <nav class="bg-sistema-primary border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')">
                                    <jet-application-mark class="block h-9 w-auto" />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('home')" >
                                    Site Midiaciencia
                                </jet-nav-link>

                            </div>
                        </div>


                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white  hover:text-gray-400 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->

                                        <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                            API Tokens
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Sair
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu --><!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-2 mb-2">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div class="font-medium text-base text-white">{{ $page.props.user.name }}</div>
                                <div class="font-medium text-sm text-white">{{ $page.props.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-1 ">
                            <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                <i class="fas fa-home"></i> <span class="mx-2 font-medium">Página inicial</span>
                            </jet-responsive-nav-link>
                        </div>

                        <div class="mt-1 ">
                            <jet-responsive-nav-link :href="route('users')" :active="route().current('users')" v-if="$page.props.auth.user.can['usuario-listar'] || $page.props.auth.user.role['Super.Admin']">
                                <i class="fas fa-user"></i> <span class="mx-2 font-medium">Usuários</span>
                            </jet-responsive-nav-link>
                        </div>

                        <div class="mt-1 ">
                            <jet-responsive-nav-link :href="route('permissions')" :active="route().current('permissions')" v-if="$page.props.auth.user.can['permissao-listar'] || $page.props.auth.user.role['Super.Admin']">
                                <i class="fas fa-user-lock"></i> <span class="mx-2 font-medium">Permissões</span>
                            </jet-responsive-nav-link>
                        </div>

                        <div class="mt-1 ">
                            <jet-responsive-nav-link :href="route('roles')" :active="route().current('roles')" v-if="$page.props.auth.user.can['role-listar'] || $page.props.auth.user.role['Super.Admin']">
                                <i class="fas fa-users-cog"></i> <span class="mx-2 font-medium">Grupo de Permissões</span>
                            </jet-responsive-nav-link>
                        </div>

                        <div class="mt-4 ">

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Sair
                                </jet-responsive-nav-link>
                            </form>

                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <!--<header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>-->

            <!-- Page Content -->
            <main>
                <slot name="sidebar">
                    <div class="my-4">
                        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                            <div class=" sm:rounded-lg flex flex-row">

                                <sidebar></sidebar>
                                <slot></slot>

                            </div>
                        </div>
                    </div>

                </slot>

            </main>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>

        </div>
        <footer class="text-gray-600 body-font max-w-7xl mx-auto">
            <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
                <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg>
                    <span class="ml-3 text-xl">Sistema Intranet</span>
                </a>
                <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">© 2021 - Bruno Andrade
                </p>
            </div>
        </footer>
    </div>

</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import Sidebar from "@/Components/Sidebar"
    import Footer from "@/Components/Footer"
    import Toast from "@/Components/Toast"

    export default {
        components: {
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Sidebar,
            Footer,
            Toast,
        },
        props: {
            toast: Object
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>

<style>
.tooltip {
    display: block !important;
    z-index: 10000;
    font-size: small;
}

.tooltip .tooltip-inner {
    background: black;
    color: white;
    border-radius: 16px;
    padding: 5px 10px 4px;
}

.tooltip .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
    border-color: black;
    z-index: 1;
}

.tooltip[x-placement^="top"] {
    margin-bottom: 5px;
}

.tooltip[x-placement^="top"] .tooltip-arrow {
    border-width: 5px 5px 0 5px;
    border-left-color: transparent !important;
    border-right-color: transparent !important;
    border-bottom-color: transparent !important;
    bottom: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
}

.tooltip[x-placement^="bottom"] {
    margin-top: 5px;
}

.tooltip[x-placement^="bottom"] .tooltip-arrow {
    border-width: 0 5px 5px 5px;
    border-left-color: transparent !important;
    border-right-color: transparent !important;
    border-top-color: transparent !important;
    top: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
}

.tooltip[x-placement^="right"] {
    margin-left: 5px;
}

.tooltip[x-placement^="right"] .tooltip-arrow {
    border-width: 5px 5px 5px 0;
    border-left-color: transparent !important;
    border-top-color: transparent !important;
    border-bottom-color: transparent !important;
    left: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
}

.tooltip[x-placement^="left"] {
    margin-right: 5px;
}

.tooltip[x-placement^="left"] .tooltip-arrow {
    border-width: 5px 0 5px 5px;
    border-top-color: transparent !important;
    border-right-color: transparent !important;
    border-bottom-color: transparent !important;
    right: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
}

.tooltip.popover .popover-inner {
    background: #f9f9f9;
    color: black;
    padding: 24px;
    border-radius: 5px;
    box-shadow: 0 5px 30px rgba(black, .1);
}

.tooltip.popover .popover-arrow {
    border-color: #f9f9f9;
}

.tooltip[aria-hidden='true'] {
    visibility: hidden;
    opacity: 0;
    transition: opacity .15s, visibility .15s;
}

.tooltip[aria-hidden='false'] {
    visibility: visible;
    opacity: 1;
    transition: opacity .15s;
}
</style>
