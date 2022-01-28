<template>
    <!--Nav-->
    <nav id="header" class=" w-full top-0 bg-white text-black p-4 shadow-lg mb-4">

        <div class="w-full container items-center max-w-6xl mx-auto flex justify-between px-2">
            <div>
                <a href="/">MIDIACIENCIA</a>
            </div>
            <div class="max-w-md text-right">
                <p class="text-blue-900 text-base md:text-2xl">Projeto de popularização da ciência</p>
            </div>
        </div>

    </nav>
</template>

<script>
export default {
    name: "Navbar",
    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>

<style scoped>

</style>
