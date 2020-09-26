<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Categories</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="title"
                                            placeholder="Enter Title"
                                            :value="item.title"
                                            @input="updateTitle"
                                            >
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="description"
                                            placeholder="Enter Description"
                                            :value="item.description"
                                            @input="updateDescription"
                                            >
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="url"
                                            placeholder="Enter URL"
                                            :value="item.url"
                                            @input="updateUrl"
                                            >
                                </div>
                                
                                <div class="form-group">
                                    <label for="category_image">Category image</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateCategory_image"
                                    >
                                    <ul v-if="item.category_image" class="list-unstyled">
                                        <li>
                                            {{ item.category_image.name || item.category_image.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeCategory_image"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('CategoriesSingle', ['item', 'loading']),
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('CategoriesSingle', ['fetchData', 'updateData', 'resetState', 'setTitle', 'setDescription', 'setUrl', 'setCategory_image']),
        updateTitle(e) {
            this.setTitle(e.target.value)
        },
        updateDescription(e) {
            this.setDescription(e.target.value)
        },
        updateUrl(e) {
            this.setUrl(e.target.value)
        },
        removeCategory_image(e, id) {
            this.$swal({
                title: 'Are you sure?',
                text: "To fully delete the file submit the form.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd4b39',
                focusCancel: true,
                reverseButtons: true
            }).then(result => {
                if (typeof result.dismiss === "undefined") {
                    this.setCategory_image('');
                }
            })
        },
        updateCategory_image(e) {
            this.setCategory_image(e.target.files[0]);
            this.$forceUpdate();
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'categories.index' })
                    this.$eventHub.$emit('update-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
