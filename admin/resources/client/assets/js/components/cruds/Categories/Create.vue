<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Categories</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        
                        <div class="bt-wrapper">
                            <back-buttton></back-buttton>                        
                        </div>
                        <bootstrap-alert />

                        <ul class="nav nav-tabs"
                            >
                            <li class="nav-item active">
                                <a class="nav-link" data-toggle="tab" href="#category">Content</a>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#seo">SEO</a>
                            </li>                                          
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="category">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Create</h3>
                                    </div>                          

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
                                </div>
                            </div>
                            <div class="tab-pane" id="seo">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">SEO</h3>
                                    </div>

                                    <div class="box-body half-fields__wrapper">                                        
                                        <div class="form-group">
                                            <label for="seo_title">Title</label>
                                            <textarea name="seo_title" 
                                                      id="seo-title" 
                                                      placeholder=""
                                                      cols="60" 
                                                      rows="1"
                                                      required="" 
                                                      v-model="seo.title"
                                                      @input="seoOnInput"
                                                    >                                                    
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="seo_h1">H1</label>
                                            <textarea name="seo_h1" 
                                                      id="seo-h1" 
                                                      placeholder=""
                                                      cols="60" 
                                                      rows="1"
                                                      required="" 
                                                      v-model="seo.h1"
                                                      @input="seoOnInput"
                                                    >                                                    
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="seo_decsription">Description</label>
                                            <textarea name="seo_decsription" 
                                                      id="seo-decsription" 
                                                      placeholder=""
                                                      cols="60" 
                                                      rows="2"
                                                      required="" 
                                                      v-model="seo.description"
                                                      @input="seoOnInput"
                                                    >                                                    
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="seo_keywords">Keywords</label>
                                            <textarea name="seo_keywords" 
                                                      id="seo-keywords" 
                                                      placeholder=""
                                                      cols="60" 
                                                      rows="1"
                                                      required="" 
                                                      v-model="seo.keywords"
                                                      @input="seoOnInput"
                                                    >                                                    
                                            </textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bt-wrapper">
                            <vue-button-spinner
                                    class="btn btn-primary btn-sm"
                                    :isLoading="loading"
                                    :disabled="loading"
                                    >
                                Save
                            </vue-button-spinner>
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
            seo:{
                title: '',
                h1: '',
                description: '',
                keywords:'',
            },            
        }
    },
    computed: {
        ...mapGetters('CategoriesSingle', ['item', 'loading'])
    },
    created() {
        this.setSeoMask();
        this.seoOnInput();
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('CategoriesSingle', ['storeData', 'resetState', 'setTitle', 'setDescription', 'setUrl', 'setSeo', 'setCategory_image']),
        updateTitle(e) {
            this.setTitle(e.target.value);
            this.setSeoMask();
            this.seoOnInput();
        },
        updateDescription(e) {
            this.setDescription(e.target.value)
        },
        updateUrl(e) {
            this.setUrl(e.target.value)
        },
        seoOnInput(){
            this.setSeo(this.seo);
        },
        setSeoMask(){
            let title = this.item.title == null ? '' : this.item.title;
            return this.seo = {                
                title: `Самые интересные и популярные ${title} онлайн на сайте letstestit.ru`,
                h1: `${title}`,                 
                description: `На нашем сайте вы можете пройти все ${title} абсолютно бесплатно. Сайт letstestit.ru гарантирует мгновенный и точный результат.`,
                keywords:`Онлайн тест, ${title}, тесты бесплатно`,
            };
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
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'categories.index' })
                    this.$eventHub.$emit('create-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped lang="scss">

.half-fields__wrapper{
    label{
        display: block;
        width: 100%;
        margin-bottom: 5px;
    }
    textarea{
        width: 100%;
        max-width: 615px;
        padding: 6px 12px;
    }
}
.bt-wrapper{
    padding-bottom: 20px;
    &.__top{
        padding-top: 20px;
    }
}
.box{
    border-top: none;   
}

</style>
