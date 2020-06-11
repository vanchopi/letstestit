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
                                                        <label :for="'num_answer' + item.id" class="required">Answers</label>
                                                        <div v-for="(answer, index) in item.answers"
                                                             class="input-group mb-3">                                                            
                                                            <input type="text"
                                                                   class="form-control"
                                                                   :placeholder="'answer' + ' № ' + index"
                                                                   
                                                                   :name="'num_answer' + item.id + answer.id"
                                                                   required=""
                                                                   v-model="answer.dsc"
                                                                   @input="answerOnInput"
                                                                >
                                                        </div>
                                                    </div>
                                                </div>
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
            questions: [
                {
                    id: 0,
                    question: 'asd',
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
                    question: 'dsa',
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
        }
    },
    computed: {
        ...mapGetters('TestsSingle', ['item', 'loading', 'categoriesAll'])
    },
    created() {
        this.fetchCategoriesAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('TestsSingle', ['storeData', 'resetState', 'setCategory', 'setTitle', 'setMain_image', 'setBg_image', 'fetchCategoriesAll']),
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
                        value: 0,                        
                    }
                }
            }            
            return this.questions;
        },
        answerOnInput(){
            console.log('on input fields', this.questions);
        },
        submitForm() {
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
    }
</style>
