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
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#adv">Реклама</a>
                            </li>                                          
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="test">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Create</h3>
                                    </div>

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

                                        <hr>

                                        <div class="form-group __1">
                                            <div class="col">
                                                <label for="type">CHOOSE TEST TYPE </label>
                                                <select name="type" 
                                                        id="type" 
                                                        v-model="selectedType"
                                                        @change="onChangeType"
                                                        class="form-control" 
                                                  >
                                                      <option v-for="type in testTypes"
                                                              :value="type"                                              
                                                      >
                                                        {{type.type}}
                                                      </option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label for="questions">Questions:</label>
                                            <div class="questions-paramrtrs__wrapper">                                        
                                                <div class="col">
                                                    <label for="columns">Number of Questions</label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="columns" 
                                                           placeholder="Number of Questions" 
                                                           v-model="quizParams.columns"
                                                           min="1"
                                                           max="100" 
                                                           @input="setQuestionsOptions"
                                                        >
                                                </div>
                                                <div class="col">
                                                    <label for="rows">Answers for one question</label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="rows"
                                                           placeholder="Answers for one question" 
                                                           v-model="quizParams.rows"
                                                           min="1"
                                                           max="20" 
                                                           @input="setQuestionsOptions"
                                                        >
                                                </div>                                        
                                            </div>
                                            <div class="questions-wrapper">
                                                <ul class="nav nav-tabs"
                                                    >
                                                    <li v-for="(item, index) in questions"    
                                                        class="nav-item"
                                                        :class="index == 0 ? 'active' : ''"
                                                        >
                                                        <a class="nav-link" data-toggle="tab" :href="'#' + item.id ">№{{index }}</a>
                                                    </li>                                            
                                                </ul>
                                                <div class="tab-content">
                                                    <div v-for="(item, index) in questions"                                                    
                                                         class="tab-pane" 
                                                         :class="index == 0 ? 'active' : ''"
                                                         :id="item.id"
                                                        >
                                                        <span>Tabs for question № {{index}}</span>  

                                                        <div class="fields-wrapper">                                                            
                                                            <div class="input-group mb-3">
                                                                <label :for="'num_question' + item.id" class="required">Question</label>
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       placeholder="Question" 
                                                                        
                                                                       :name="'num_question' + item.id"
                                                                       required=""
                                                                       v-model="item.question" 
                                                                       @input="answerOnInput"
                                                                    >
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <label :for="'question_image' + index">Image for question №{{index}}</label>
                                                                <input
                                                                        type="file"
                                                                        class="form-control"
                                                                        @change="updateQuestionImage($event, index)"
                                                                >
                                                                <ul v-if="item.img" class="list-unstyled">
                                                                    <li>
                                                                        {{ item.img.name || item.img.file_name }}
                                                                        <button class="btn btn-xs btn-danger"
                                                                                type="button"
                                                                                @click="removeQuestionImage"
                                                                        >
                                                                            Remove file
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="answers-wrapper">
                                                                <div class="labels-wrapper">
                                                                    <label :for="'num_answer' + item.id" class="required">Answers</label>
                                                                    <label v-if="selectedType.id == 0">Correct</label>
                                                                    <label v-if="selectedType.id == 1">Sign</label>
                                                                </div>
                                                                <div v-for="(answer, index) in item.answers"
                                                                     class="mb-3">  
                                                                    <div class="fields-wrapper__internal">
                                                                        <div class="fields-wrapper__item">
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   :placeholder="'answer' + ' № ' + index"
                                                                                   
                                                                                   :name="'num_answer' + item.id + answer.id"
                                                                                   required=""
                                                                                   v-model="answer.dsc"
                                                                                   @input="answerOnInput"
                                                                                >
                                                                        </div>
                                                                        <div class="fields-wrapper__item"
                                                                             v-if="selectedType.id == 0"
                                                                            >  
                                                                            <label class="check-container">answer № {{index}}
                                                                                <input  type="radio" 
                                                                                        :name="'num_checked' + item.id"
                                                                                        
                                                                                        class="hidden"
                                                                                        @input="checkOnInput(item.id, index)"
                                                                                >
                                                                                <span class="checkmark"></span>
                                                                            </label>                               
                                                                        </div>
                                                                        <div class="fields-wrapper__item"
                                                                             v-if="selectedType.id == 1"
                                                                            >
                                                                            <!--<select name="sign" 
                                                                                  id="sign" 
                                                                                  v-model="answer.sign"
                                                                                  @change="onSignType"
                                                                                  class="form-control" 
                                                                            ><-- signs 
                                                                                <option v-for="sign in selectedSign"
                                                                                        :value="sign"                                              
                                                                                >
                                                                                  {{sign.result}}
                                                                                </option>                                                                                
                                                                            </select> -->                                                                            
                                                                            <treeselect
                                                                                name="sign"
                                                                                :multiple="true"
                                                                                value-format="object"
                                                                                v-model="answer.sign"
                                                                                :options="selectedSign"
                                                                                placeholder="Выберете признак"
                                                                                @select="onSignType"
                                                                                @deselect="onSignType"
                                                                            >                                                                                
                                                                            </treeselect>
                                                                        </div>
                                                                    </div>      
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                        </div>   
                                        
                                        <hr>

                                        <div class="form-group">
                                            <label for="results">Results:</label>
                                            <div class="questions-paramrtrs__wrapper __results">                                        
                                                <div class="col">
                                                    <label for="columns">Number of Results</label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="columns" 
                                                           placeholder="Number of Results" 
                                                           v-model="resultsRows"
                                                           min="1"
                                                           max="15" 
                                                           @input="setResultsOptions"
                                                        >
                                                </div>
                                                <div class="col">
                                                    <a href="https://www.resizepixel.com/ru" target="_blank">Image editor</a>
                                                </div>
                                            </div>
                                            <div class="results-fields__wrapper fields-wrapper">
                                                <div    v-for="(item, index) in results"
                                                        class="results-fields__item"                                             
                                                >
                                                    <div class="result-fields__internal">
                                                        <div class="input-group mb-3">
                                                            <!--<label :for="'num_result' + item.id" class="required">Result №{{index}}</label>-->
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   :placeholder="'Result № ' + index" 
                                                                    
                                                                   :name="'num_result' + item.id"
                                                                   required=""
                                                                   v-model="item.result" 
                                                                   @input="resultOnInput"
                                                                >
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <!--<textarea :name="'num_description' + index" 
                                                                      :id="'num-description' + index" 
                                                                      :placeholder="'Description for result № ' + index"
                                                                      cols="30" 
                                                                      rows="6"
                                                                      required="" 
                                                                      v-model="item.description"
                                                                      @input="resultOnInput"
                                                                    >                                                    
                                                            </textarea>-->
                                                            <text-editor :name="'num_description' + index" 
                                                                         :id="'num-description' + index" 
                                                                         :placeholder="'Description for result № ' + index"                       
                                                                         required="" 
                                                                         v-model="item.description"
                                                                         :textCallbak="textEditorOnInput"
                                                                         :num="index"
                                                                         @input="resultOnInput"
                                                            />
                                                            
                                                        </div>

                                                        <div class="form-group">
                                                            <label :for="'result_image' + index">Result Image №{{index}}</label>
                                                            <input
                                                                    type="file"
                                                                    class="form-control"
                                                                    @change="updateResultImage($event, index)"
                                                            >
                                                            <ul v-if="item.img" class="list-unstyled">
                                                                <li>
                                                                    {{ item.img.name || item.img.file_name }}
                                                                    <button class="btn btn-xs btn-danger"
                                                                            type="button"
                                                                            @click="removeResultImage"
                                                                    >
                                                                        Remove file
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div v-if="selectedType.id == 0" class="input-group mb-3">       
                                                            <label for="">Num of correct answers</label>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   :placeholder="'Max ' + quizParams.columns" 
                                                                   :name="'num_value' + item.id"
                                                                   required=""
                                                                   v-model="item.value"
                                                                   @input="resultOnInput"
                                                                   min="0"
                                                                   :max="quizParams.columns"
                                                                >
                                                        </div>
                                                    </div>
                                                    <div class="result-fields__img">
                                                        <div :id="'show-modal' + index" @click="onCreatorOpen(index, item);showModal = true" class="btn btn-primary btn-sm">Result Image Generator</div>                                                         
                                                        <img :src="results[index].resultThumb.src" alt="">
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>                        

                                        <create-image :showModal="showModal" 
                                                      :onCloseWindow="onCloseWindow" 
                                                      :title="txtTitle" 
                                                      :num="creatorData.index" 
                                                      :results="creatorData.results" 
                                                      :onApplyImage="onApplyImage"
                                        />

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
                            <div class="tab-pane" id="adv">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Реклама</h3>
                                    </div>

                                    <div class="box-body half-fields__wrapper">
                                        <TabAdvertisment />
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
import TabAdvertisment from "./Tabs/TabAdvertisment.vue";
import Treeselect from '@riophae/vue-treeselect'
import CreateImage from './createImage/CreateImage'
import TextEditor from '../../global/TextEditor'
import Vue from 'vue'

export default {    
    components: {    
        CreateImage,
        TextEditor,
        Treeselect,
        TabAdvertisment,
    },
    data() {
        return {
            // Code... 
            txtTitle: '', 
            showModal: false,  
            createdImg: '',
            tmpCanvas: '',        
            quizParams:{
                columns: 2,
                rows: 1,
            },
            resultsRows: 1,
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
            selectedType: {
                id: 0,
                type: 'knowledges',
            },
            selectedSign:[
              {
                id: 0,
                label: '',
              }
            ],
            SignsToStore: null,
            questions: [
                {
                    id: 0,
                    img: null,
                    question: '',
                    answers: [
                        {
                            id: 0,
                            dsc: '',
                            checked: false,
                            value: 0,
                            sign: null,
                        }
                    ]
                },
                {
                    id: 1,
                    question: '',
                    answers: [
                        {
                            id: 0,
                            dsc: '',
                            checked: false,
                            value: 0,
                            sign: null,
                        }
                    ]
                }
            ],
            results:[
                {
                    id: 0,
                    result: '',
                    img: '',
                    description: '',
                    value: 0,
                    sign: '',
                    resultThumb:{
                        src: '',
                    }
                }
            ],
            resultsThumbs:[
                {
                    src: ''
                }
            ],
            seo:{
                title: '',
                h1: '',
                description: '',
                keywords:'',
            },
            creatorData:{
                index: null,
                results: {
                    result: '',
                    description: ''
                }
            }
        }
    },
    computed: {
        ...mapGetters('TestsSingle', ['item', 'resultsItem', 'loading', 'categoriesAll'])
    },
    created() {
        this.fetchCategoriesAll();        
        this.setSeoMask();
        this.seoOnInput();
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('TestsSingle', ['storeData', 'resetState', 'setCategory', 'setTitle', 'setUrl', 'setPopularity', 'setType', 'setQuestions', 'setResults', 'setSeo', 'setResultsImage' ,'setMain_image', 'setBg_image', 'fetchCategoriesAll']),
        updateCategory(value) {
            this.setCategory(value)
        },
        updateTitle(e) {
            this.setTitle(e.target.value);
            this.txtTitle = e.target.value;
            this.setSeoMask();
            this.seoOnInput();
        },
        updateUrl(e) {
            this.setUrl(e.target.value);
        },
        checkNum( val ){
            if (val < 0 ){
              val = 0;
            }
            return val;
        },        
        onCloseWindow(data){
            this.showModal = data;
        },
        onCreatorOpen( num, data ){
            //console.log('1. onCreatorOpen - ', num, data );
            this.creatorData.index = num;
            this.creatorData.results.result = data.result;
            this.creatorData.results.description = data.description;
            //console.log(' creator -  ',this.creatorData);
        },
        onApplyImage(data){
            console.log('image data - ', data);
            this.results[data.num].resultThumb.src = data.src;
            console.log('result thumbs - ', this.results);
            this.setResults(this.results); 
            console.log('results store - ', this.resultsItem);           
        },
        updatePopularity(e){
            this.setPopularity(parseFloat(this.checkNum(e.target.value)));
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
        fileToJson( file ){
            let subFile = {
              'lastMod'    : file.lastModified,
              'lastModDate': file.lastModifiedDate,
              'name'       : file.name,
              'size'       : file.size,
              'type'       : file.type,
            }
            return subFile;
        },
        updateQuestionImage(e, index){           
            
            this.questions[index].img = e.target.files[0];
            console.log('1. questions img - ', this.questions);
            this.setQuestions(this.questions);
            console.log('2. questions store - ', this.item.questions);
        },
        updateResultImage(e, index){
            var reader  = new FileReader(),
                context = this,
                file = e.target.files[0],
                id = 'thumb' + index;                                    
            this.results[index].img = e.target.files[0];            
            this.setResults(this.results);
            console.log('results store - ', this.resultsItem);            
        },
        removeResultImage(e, id){

        },
        removeQuestionImage(e, id){

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
        setQuestionsOptions(){            
            let questions = this.quizParams.columns == '' ? 1 : parseInt(this.quizParams.columns),
                answers = this.quizParams.rows == '' ? 1 : parseInt(this.quizParams.rows);
            if(questions < 1) {
                questions = 1;
                this.quizParams.columns = questions;    
            }
            if(questions > 100) {
                questions = 100;
                this.quizParams.columns = questions;    
            }
            if(answers < 1){ 
                answers = 1;
                this.quizParams.rows = answers;
            }
            if(answers > 20){ 
                answers = 20;
                this.quizParams.rows = answers;
            }
            this.drawColumnsRows(questions, answers);            

        },
        setResultsOptions(){
            let results = this.resultsRows == '' ? 1 : parseInt(this.resultsRows);
            if(results < 1) {
                results = 1;
                this.resultsRows = results;   
            }
            if(results > 15) {
                results = 15;
                this.resultsRows = results;    
            }
            this.drawResultsRows(results);
        },
        drawResultsRows( results ){
            this.results = [];
            for( let i = 0; i < results; i++){
                this.results[i] = {
                    id: i,
                    result: '',
                    img: '',
                    description: '',
                    value: 0,
                    sign: '',
                    resultThumb:{
                        src: ''
                    }
                }
                this.resultsThumbs[i] = {
                    src: ''
                }
            };
            return this.results;
        },
        drawColumnsRows(questions, answers){            
            this.questions = [];
            for( let i = 0; i < questions; i++){
                this.questions[i] = {
                    id: i,
                    img: null,
                    question: '',
                    answers: []
                };                
                for(let j = 0; j < answers; j++){
                    this.questions[i].answers[j] = {
                        id: j,
                        dsc: '',
                        checked: false,
                        sign: null,                        
                    }
                }
            }            
            return this.questions;
        },
        onChangeType(){          
          let val = this.selectedType;
          this.setType(this.selectedType.type);          
        },
        updateQuestions() {
            this.setQuestions(this.questions);
            console.log('store', this.item.questions);
        },
        answerOnInput(){
            console.log('on input fields', this.questions);            
            this.updateQuestions();
        },
        onSignType(){
            console.log('onSignType', this.questions);
            this.setQuestions(this.questions);
        },
        checkOnInput( el , num){
            for (let i = 0; i < this.quizParams.rows; i++){
                if (  i == num ){
                    this.questions[el].answers[i].checked = true;
                } else{
                    this.questions[el].answers[i].checked = false;
                }
            }
            this.updateQuestions();
        },
        updateResults() {
            this.setResults(this.results);
            this.selectedSign = [];
            for(let i = 0; i < this.results.length; i++ ){
                console.log(i);
                this.selectedSign.push({
                    id: this.results[i].id,
                    label: this.results[i].result,
                })
            };
            console.log('opa - ', this.selectedSign);
            return this.selectedSign;
        },
        textEditorOnInput(data, num){
            this.results[num].description = data;
            this.updateResults();
        },
        resultOnInput(){          
            this.updateResults();
            
        },
        seoOnInput(){
            this.setSeo(this.seo);
        },
        setSeoMask(){
            let title = this.item.title == null ? '' : this.item.title;
            return this.seo = {
                title: `${title}`,
                h1: `Пройди тест ${title} на сайте letstestit.ru`,
                description: `Хочешь узнать о себе максимум. Тест ${title} поможет тебе в этом. Сконцентрируйся, и постарайся ответить на все вопросы честно на сайте letstestit.ru`,
                keywords:`тест ${title}, онлайн тест, пройти тест`,
            };
        },
        submitForm() {
            //this.item.questions = this.questions;
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'tests.index' })
                    this.$eventHub.$emit('create-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style lang="scss">
    @import '~@riophae/vue-treeselect/dist/vue-treeselect.css';
    .half-fields__wrapper{
        label{
            display: block;
            width: 100%;
            margin-bottom: 5px;
        }
        input,
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
    .vue-treeselect__control{
        height: 34px;
        border-radius: 0;
    }
    .vue-treeselect__menu{
        border-radius: 0;
    }
</style>
