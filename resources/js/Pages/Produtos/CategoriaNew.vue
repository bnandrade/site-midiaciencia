<template>

    <jet-form-section @submitted="store">

        <template #form>


            <div class="col-span-12">
                <label class="block font-medium text-sm text-gray-700">Imagem de capa da categoria:</label>
                <input type="file" class="form-input rounded-md shadow-sm block mt-1 p-2 w-full border focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-transparent " @change="onImageChange" >
                <jet-input-error :message="form.errors.capa" class="mt-2" />

                <div v-if="imagePreview" class="w-1/2 mx-auto">
                    <img :src="imagePreview" class="w-full" />
                </div>

            </div>

            <div class="col-span-6 ">
                <jet-label for="titulo" value="Titulo da categoria" />
                <jet-input id="titulo" type="text" class="mt-1 block w-full" v-model="form.titulo" autofocus  />
                <jet-input-error :message="form.errors.titulo" class="mt-2" />
            </div>

            <div class="col-span-3 ">
                <jet-label for="ordem" value="Ordem de apresentação" />
                <select v-model="form.ordem"  class="form-input rounded-md shadow-sm block mt-1 p-3 w-full border focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-transparent " >
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                </select>
                <jet-input-error :message="form.errors.ordem" class="mt-2" />
            </div>


        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Categoria criada
            </jet-action-message>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Criar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>

import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
    name: "New",
    props: {
    },
    components: {
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetActionMessage,
        JetSecondaryButton,
        JetSectionBorder,
    },
    data() {
        return {
            form: this.$inertia.form({
                capa: '',
                titulo: '',
                ordem: ''
            }),

            imagePreview: '',


        }
    },

    methods: {
        store() {
            this.form.post(route('categoria.store'), {
                errorBag: 'categoriaStore',
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                }
            });
        },

        onImageChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.form.capa = files[0];
        },

    },
    computed: {

    },
}
</script>

<style scoped>

</style>
