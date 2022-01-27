<template>
    <div class="flex justify-center">

        <button
            class="cursor-pointer text-sm text-gray-400 focus:outline-none mx-2"
            @click="updating = true" v-tooltip="'Editar banner'"
            v-if="$page.props.auth.user.can['banner-editar'] || $page.props.auth.user.role['Super.Admin']">
            <font-awesome-icon :icon="[ 'far', 'edit' ]" />
        </button>
        <button
            class="cursor-pointer  text-sm text-red-500 focus:outline-none mx-2"
            @click="destroying = true" v-tooltip="'Excluir banner'"
            v-if="$page.props.auth.user.can['banner-deletar'] || $page.props.auth.user.role['Super.Admin']">
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
                Atualizar Banner
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

                <div class="">
                    <jet-label for="titulo" value="Título" />
                    <jet-input id="titulo" type="text" class="mt-1 block w-full" v-model="updateForm.titulo"  />
                    <jet-input-error :message="updateForm.errors.titulo" class="mt-2" />
                </div>

                <div class="">
                    <jet-label for="subtitulo" value="Subtítulo" />
                    <jet-input id="subtitulo" type="text" class="mt-1 block w-full" v-model="updateForm.subtitulo"  />
                    <jet-input-error :message="updateForm.errors.subtitulo" class="mt-2" />
                </div>

                <div class="">
                    <jet-label for="url" value="URL externo (opcional)" />
                    <jet-input id="url" type="text" class="mt-1 block w-full" v-model="updateForm.url"  />
                    <jet-input-error :message="updateForm.errors.url" class="mt-2" />
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
                Deletar Banner
            </template>

            <template #content>
                Você tem certeza que deseja deletar?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="destroying = false">
                    Cancelar
                </jet-secondary-button>


                <jet-danger-button class="ml-2" @click.native="destroy" >
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


export default {
    props: {
        'banner': Object,
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
        JetSectionBorder
    },

    data() {
        return {
            updateForm: this.$inertia.form({
                imagem: '',
                titulo: this.banner.titulo,
                subtitulo: this.banner.subtitulo,
                url: this.banner.url,
            }),
            imagem: '',
            imagePreview: this.banner.imagem,

            updating: false,

            destroyForm: this.$inertia.form(),
            destroying: false,

        }
    },

    methods: {
        update() {

            const data = {
                _method : 'PUT',
                imagem: this.imagem,
                titulo: this.updateForm.titulo,
                subtitulo: this.updateForm.subtitulo,
                url: this.updateForm.url,
            }

            this.$inertia.post(this.route('banner.update', this.banner), data, {
                errorBag: 'bannerUpdate',
                preserveScroll: true,
                onSuccess: () => {
                    this.updateForm.reset()
                    this.updateForm.imagem = ''
                    this.updateForm.titulo = ''
                    this.updateForm.subtitulo = ''
                    this.updateForm.url = ''
                    this.formNewVisible = false
                    this.updating = false

                },
            })

        },
        onImageChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.imagem = files[0];
            // this.createImage(files[0]);
        },

        destroy() {
            this.destroyForm.delete(route('banner.destroy', this.banner), {
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
