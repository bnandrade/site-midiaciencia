<template>
    <div class="flex justify-center">


        <button
            class="cursor-pointer text-sm text-gray-400 focus:outline-none mx-2"
            @click="updating = true" v-tooltip="'Editar categoria'"
            v-if="$page.props.auth.user.can['produto-editar'] || $page.props.auth.user.role['Super.Admin']">
            <font-awesome-icon :icon="[ 'far', 'edit' ]" />
        </button>
        <button
            class="cursor-pointer text-sm text-red-200 focus:outline-none mx-2"
            v-else
            v-tooltip="'Você não tem permissão de Editar'">
            <font-awesome-icon :icon="[ 'far', 'times-circle' ]" />
        </button>

        <button
            class="cursor-pointer  text-sm text-red-500 focus:outline-none mx-2"
            @click="destroying = true" v-tooltip="'Excluir categoria'"
            v-if="$page.props.auth.user.can['produto-deletar'] || $page.props.auth.user.role['Super.Admin']">
            <font-awesome-icon :icon="[ 'far', 'trash-alt' ]" />
        </button>
        <button
            class="cursor-pointer text-sm text-red-200 focus:outline-none mx-2"
            v-else
            v-tooltip="'Você não tem permissão de Deletar'">
            <font-awesome-icon :icon="[ 'far', 'times-circle' ]" />
        </button>

        <jet-dialog-modal :show="updating" @close="updating = false">
            <template #title>
                Atualizar categoria
            </template>

            <template #content>


                <div class="col-span-6 my-4 flex gap-4 items-center">
                    <div class="w-3/6">
                        <label class="block font-medium text-sm text-gray-700">Imagem de capa:</label>
                        <input type="file" class="form-input rounded-md shadow-sm block mt-1 p-2 w-full border focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-transparent " @change="onImageChange" >
                    </div>
                    <div class="w-3/6">
                        <div v-if="imagePreview">
                            <img class="rounded" :src="imagePreview"/>
                        </div>
                    </div>

                </div>

                <div class="mt-4">
                    <jet-label for="titulo" value="Título da Categoria" />
                    <jet-input id="titulo" type="text" class="mt-1 block w-full" v-model="updateForm.titulo"  />
                    <jet-input-error :message="updateForm.errors.titulo" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="resumo" value="Resumo da Categoria" />
                    <jet-input id="resumo" type="text" class="mt-1 block w-full" v-model="updateForm.resumo"  />
                    <jet-input-error :message="updateForm.errors.resumo" class="mt-2" />
                </div>

                <div class="col-span-6 mt-4 mb-4 ">
                    <jet-label for="content" value="Texto da Categoria" />
                    <quill-editor
                        ref="texto"
                        id="texto"
                        :value="texto"
                        :options="editorOption"
                        v-model:value="updateForm.texto"
                    />
                    <jet-input-error :message="updateForm.errors.texto" class="mt-2" />
                </div>

                <div class="col-span-3 ">
                    <jet-label for="ordem" value="Ordem de apresentação" />
                    <select v-model="updateForm.ordem"  class="form-input rounded-md shadow-sm block mt-1 p-3 w-full border focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-transparent " >
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
                    <jet-input-error :message="updateForm.errors.ordem" class="mt-2" />
                </div>


            </template>

            <template #footer>
                <jet-secondary-button @click.native="updating = false">
                    Cancelar
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="update" :class="{ 'opacity-25': updateForm.processing }" :disabled="updateForm.processing">
                    Salvar
                </jet-button>
            </template>

        </jet-dialog-modal>

        <jet-confirmation-modal :show="destroying" @close="destroying = false">
            <template #title>
                Deletar categoria
            </template>

            <template #content>
                Você tem certeza que deseja deletar?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="destroying = false">
                    Cancelar
                </jet-secondary-button>


                <jet-danger-button class="ml-2" @click.native="destroy" :class="{ 'opacity-25': updateForm.processing }" :disabled="updateForm.processing">
                    Deletar
                </jet-danger-button>
            </template>

        </jet-confirmation-modal>


    </div>
</template>


<script>
import JetButton from '@/Jetstream/Button'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import {quillEditor} from "vue-quill-editor";

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'

import dedent from 'dedent'

export default {
    props: {
        'categoria': Object,
    },

    components: {
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetDialogModal,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        quillEditor,
    },

    data() {
        return {
            updateForm: this.$inertia.form({
                capa: '',
                titulo: this.categoria.titulo,
                resumo: this.categoria.resumo,
                texto: this.categoria.texto,
                ordem: this.categoria.ordem,
            }),
            capa: '',
            imagem: '',
            imagePreview: this.categoria.capa,

            updating: false,

            destroyForm: this.$inertia.form(),
            destroying: false,


            editorOption: {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link',  'video']
                    ],
                    syntax: {
                        highlight: text => hljs.highlightAuto(text).value
                    }
                }
            },
            texto: dedent``,

        }
    },

    methods: {
        update() {

            const data = {
                _method : 'PUT',
                capa: this.capa,
                titulo: this.updateForm.titulo,
                resumo: this.updateForm.resumo,
                texto: this.updateForm.texto,
                ordem: this.updateForm.ordem,
            }

            this.$inertia.post(this.route('categoria.update', this.categoria), data, {
                errorBag: 'categoriaUpdate',
                preserveScroll: true,
                onSuccess: () => {
                    this.updateForm.reset()
                    this.updateForm.capa = ''
                    this.updateForm.titulo = ''
                    this.updateForm.resumo = ''
                    this.updateForm.texto = ''
                    this.updateForm.ordem = ''
                    this.formNewVisible = false
                    this.updating = false

                },
            })

        },
        onImageChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.capa = files[0];
            // this.createImage(files[0]);
        },

        destroy() {
            this.destroyForm.delete(route('categoria.destroy', this.categoria), {
                errorBag: 'default',
                preserveScroll: true,
                onSuccess: () => {
                    this.destroying = false

                    this.destroyForm.reset()
                }
            })
        },

    },
}
</script>
