<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Tests</h1>
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
                                <a class="nav-link" data-toggle="tab" href="#test">Content</a>
                            </li>  
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#seo">SEO</a>
                            </li>                                          
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="test">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Edit</h3>
                                    </div>

                                    <div class="box">                            

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
                                            <label for="url">Url</label>
                                            <input
                                                    type="text"
                                                    class="form-control"
                                                    name="url"
                                                    placeholder="Enter Url"
                                                    :value="item.url"
                                                    @input="updateUrl"
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

                                            <div class="form-group">
                                                <label for="popularity">Popularity (step - 0.00001)</label>
                                                <input  type="number"
                                                        step="0.00001"
                                                        class="form-control"
                                                        name="popularity"
                                                        placeholder="Enter Popularity(float)"
                                                        :value="item.popularity"
                                                        @input="updatePopularity"
                                                        min="0"
                                                        >
                                            </div>

                                            <div class="form-group __1">
                                                <div class="col">
                                                    <label for="type">CHOOSE TEST TYPE </label>
                                                    <select name="type" 
                                                            id="type" 
                                                            disabled="" 
                                                            v-model="selectedType"
                                                            @change="onChangeType"
                                                            class="form-control" 
                                                      >
                                                          <option v-for="type in testTypes"
                                                                  :value="type.type"
                                                          >
                                                            {{type.type}}
                                                          </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>
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
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
import CreateImage from './createImage/CreateImage'
import TextEditor from '../../global/TextEditor'

export default {
    components: {    
        CreateImage,
        TextEditor,
    },
    data() {
        return {
            txtTitle: '', 
            showModal: false,
            begin: true,
            selectedType: '',
            testTypes: [
              { 
                id: 0,
                type: 'knowledges',
              },
              {
                id: 1,
                type: 'tree',
              }
            ],
            seo:{
                title: '',
                h1: '',
                description: '',
                keywords:'',
            },
        }
    },
    computed: {
        ...mapGetters('TestsSingle', ['item','resultsItem', 'loading', 'categoriesAll']),
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
        },
        "item": function(){
            if(this.begin){
                this.seo = this.item.seo;
                this.selectedType = this.item.test_type;
                this.begin = false;
            }
        },
    },
    methods: {
        ...mapActions('TestsSingle', ['fetchData', 'updateData', 'resetState', 'setCategory', 'setTitle', 'setUrl', 'setType', 'setPopularity', 'setMain_image', 'setBg_image']),
        updateCategory(value) {
            this.setCategory(value)
        },
        updateTitle(e) {
            this.setTitle(e.target.value)
        },
        updateUrl(e) {
            this.setUrl(e.target.value);
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
        updatePopularity(e){
            //this.setPopularity(parseFloat(this.checkNum(e.target.value)));
        },
        onChangeType(){          
          /*let val = this.selectedType;
          this.setType(this.selectedType.type);*/          
        },
        seoOnInput(){

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
    .questions-paramrtrs__wrapper{
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;        
        margin: 15px 0 30px 0;
        padding-top: 15px;
        border-top: 1px solid #d8d2d2;        
        .col{
            width: 45%;
            max-width: 300px;
            &:last-child{
                margin-left: 15px;
            }
        }
        &.__results{
            flex-direction: column;
            .col{
                &:last-child{
                    margin-left: 0px;
                }
            }   
        }
        a{
            margin-top: 15px;
            display: block;
        }
    }
    .tab-pane > span{
        display: block;
        margin: 15px 0;
    }
    .fields-wrapper{
        .input-group{
            width: 100%;
            max-width: 615px;
            margin-bottom: 15px;
        }
        &.results-fields__wrapper{            
            textarea{
                width: 100%;
                max-width: 615px;
                padding: 6px 12px;
            }
            .results-fields__item{
                margin: 15px 0 15px 0;
                padding-top: 15px;
                border-top: 1px solid black;
                display: flex;
                justify-content: flex-start;
                align-items: flex-start;
            }
            .result-fields__internal{
                width: 100%;
                max-width: 615px;
            }
            .result-fields__img{
                width: calc(100% - 615px);
                padding-left: 20px;
                display: flex;
                align-items: flex-start;
                justify-content: flex-start;
                flex-direction: column;
                .img-wrp{
                    width: 300px;
                    img{
                        width: 100%;
                    }
                }
                img{
                    width: 100%;
                    max-width: 512px;
                }
                .btn{
                    margin: 2px 0 17px 0;
                }
            }
        }
    }
    .form-group{
      &.__1{        
        display: flex;
        justify-content: space-between;
        .col{
          width: calc(50% - 10px);
        }        
      }
    }
    .fields-wrapper__internal{
        display: flex;
        justify-content: flex-start;
        .fields-wrapper__item{
            width: calc(50% - 10px);
            max-width: 615px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 15px;
            &:first-child{
                margin-right: 10px;
            }
        }
    }
    .labels-wrapper{
        display: flex;
        justify-content: flex-start;
        label{
          width: calc(50% - 10px);
            max-width: 615px;
            display: flex;
            justify-content: flex-start;
            align-items: center;            
            &:first-child{
                margin-right: 10px;
            }
        }
    }
</style>
