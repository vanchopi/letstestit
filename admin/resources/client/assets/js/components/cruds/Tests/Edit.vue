<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Tests</h1>
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
                                    <label for="category">Category id</label>
                                    <v-select
                                            name="category"
                                            label="title"
                                            @input="updateCategory"
                                            :value="item.category"
                                            :options="categoriesAll"
                                            />
                                </div>
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
                                    <label for="main_image">Main image</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateMain_image"
                                    >
                                    <ul v-if="item.main_image" class="list-unstyled">
                                        <li>
                                            {{ item.main_image.name || item.main_image.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeMain_image"
                                            >
                                                Remove file
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="bg_image">Bg image</label>
                                    <input
                                            type="file"
                                            class="form-control"
                                            @change="updateBg_image"
                                    >
                                    <ul v-if="item.bg_image" class="list-unstyled">
                                        <li>
                                            {{ item.bg_image.name || item.bg_image.file_name }}
                                            <button class="btn btn-xs btn-danger"
                                                    type="button"
                                                    @click="removeBg_image"
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
        ...mapGetters('TestsSingle', ['item', 'loading', 'categoriesAll']),
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
        ...mapActions('TestsSingle', ['fetchData', 'updateData', 'resetState', 'setCategory', 'setTitle', 'setMain_image', 'setBg_image']),
        updateCategory(value) {
            this.setCategory(value)
        },
        updateTitle(e) {
            this.setTitle(e.target.value)
        },
        removeMain_image(e, id) {
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
                    this.setMain_image('');
                }
            })
        },
        updateMain_image(e) {
            this.setMain_image(e.target.files[0]);
            this.$forceUpdate();
        },
        removeBg_image(e, id) {
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
                    this.setBg_image('');
                }
            })
        },
        updateBg_image(e) {
            this.setBg_image(e.target.files[0]);
            this.$forceUpdate();
        },
        submitForm() {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'tests.index' })
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
