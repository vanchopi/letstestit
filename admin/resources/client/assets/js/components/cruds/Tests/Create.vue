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
                                <h3 class="box-title">Create</h3>
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
                                                    <div class="answers-wrapper">
                                                        <div class="labels-wrapper">
                                                            <label :for="'num_answer' + item.id" class="required">Answers</label>
                                                            <label v-if="selectedType.id == 0">Correct</label>
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
                                    </div>
                                    <div class="results-fields__wrapper fields-wrapper">
                                        <div    v-for="(item, index) in results"
                                                class="results-fields__item"                                             
                                        >
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
                                                <textarea :name="'num_description' + index" 
                                                          :id="'num-description' + index" 
                                                          :placeholder="'Description for result № ' + index"
                                                          cols="30" 
                                                          rows="6"
                                                          required="" 
                                                          v-model="item.description"
                                                          @input="resultOnInput"
                                                        >                                                    
                                                </textarea>
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
                                        </div>
                                    </div>
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
                id: null,
                type: '',
            },
            questions: [
                {
                    id: 0,
                    question: '',
                    answers: [
                        {
                            id: 0,
                            dsc: '',
                            checked: false,
                            value: 0,
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
                }
            ]
        }
    },
    computed: {
        ...mapGetters('TestsSingle', ['item', 'resultsItem', 'loading', 'categoriesAll'])
    },
    created() {
        this.fetchCategoriesAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('TestsSingle', ['storeData', 'resetState', 'setCategory', 'setTitle', 'setType', 'setQuestions', 'setResults', 'setResultsImage' ,'setMain_image', 'setBg_image', 'fetchCategoriesAll']),
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
        updateResultImage(e, index){            
            let imgRecord = {
                //img: this.fileToJson(e.target.files[0]),
                img: e.target.files[0],
                id: index
            }
            console.log('imgRecord - ', imgRecord);
            this.setResultsImage(imgRecord);
            console.log('results store - ', this.resultsItem);
        },
        removeResultImage(e, id){

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
                }
            };
            return this.results;
        },
        drawColumnsRows(questions, answers){            
            this.questions = [];
            for( let i = 0; i < questions; i++){
                this.questions[i] = {
                    id: i,
                    question: '',
                    answers: []
                };                
                for(let j = 0; j < answers; j++){
                    this.questions[i].answers[j] = {
                        id: j,
                        dsc: '',
                        checked: false,
                        sign: '',                        
                    }
                }
            }            
            return this.questions;
        },
        onChangeType(){          
          let val = this.selectedType;
          switch(val.id) {
            case 0:  
              
              break;
            case 1:
              
              break
          }
        },
        updateQuestions() {
            this.setQuestions(this.questions);
            console.log('store', this.item.questions);
        },
        answerOnInput(){
            console.log('on input fields', this.questions);            
            this.updateQuestions();
        },
        checkOnInput( el , num){
            console.log('on check changed', el, ' + ' , num);
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
            //console.log('results store - ', this.resultsItem);
        },
        resultOnInput(){
            //console.log('on input fields', this.results);
            this.updateResults();
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


<style scoped lang="scss">
    .questions-paramrtrs__wrapper{
        display: flex;
        align-items: center;
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
            .col{
                &:last-child{
                    margin-left: 0px;
                }
            }   
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
                border-top: 1px solid #d8d2d2;
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
