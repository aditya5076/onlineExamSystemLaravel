<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Online Examination
                        <span class="float-right">{{questionIndex}}/{{questions.length}}</span>
                    </div>

                    <div class="card-body">
                       <span class="float-right" style="color:red;" v-show="questionIndex!=questions.length">{{time}}</span>


                        <div v-for="(question,index) in questions">
                            <div v-show="index===questionIndex">

                            {{question.question}}
                            <ol>
                            <li v-for="choice in question.answers">
                                <label>
                                    <input type="radio"
                                    :value="choice.is_correct==true?true:choice.answer"
                                    :name="index"
                                    v-model="userResponses[index]"
                                    @click="choices(question.id,choice.id)"



                                    >
                                    {{choice.answer}}

                                </label>

                            </li>
                        </ol>



                        </div>
                    </div>

                    <div v-show="questionIndex!=questions.length">

                        <button   v-if="questionIndex>0" class="btn btn-success"@click="prev">Prev</button>
                        <button class="btn btn-success float-right"@click="next();postuserChoice()">Next</button>

                    </div>
                    {{submission()}}
                    <div v-show="questionIndex===questions.length">
                        <p>
                            <center>
                                You got:{{score()}}/{{questions.length}}
                            </center>
                        </p>


                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props:['quizid','quizQuestions','hasQuizPlayed','times'],
        data(){
            return{
                questions:this.quizQuestions,
                questionIndex:0,
                userResponses:Array(this.quizQuestions.length).fill(false),
                currentQuestion:0,
                currentAnswer:0,
                clock: moment((10 * 1000)-(30*60*1000)),
            }
        },


        mounted() {
            var timer=setInterval(() => {
                if(this.questionIndex<this.questions.length){
                    this.clock = moment(this.clock.subtract(1, 'seconds'))
            }
            }, 1000);

            setInterval(()=>{
                if(this.questionIndex<this.questions.length){
                    this.next();
                }
            },10000)
        },

            computed: {
            time: function(){
                var minsec=this.clock.format('mm:ss');
                return minsec
            }
        },
        methods:{
            next(){
                this.questionIndex++,
                this.clock=moment((10 * 1000)-(30*60*1000))
            },
            prev(){
                this.questionIndex--
            },
            choices(question,answer){
                this.currentAnswer=answer,
                this.currentQuestion=question
            },

            postuserChoice(){
                axios.post('/quiz/create',{
                    answerId:this.currentAnswer,
                    questionId:this.currentQuestion,
                    quizId :this.quizid

                }).then((response)=>{
                    console.log(response)
                }).catch((error)=>{
                    alert("Error!")
                });
            },
             score(){
                return this.userResponses.filter((val)=>{
                    return val===true;
                }).length

            },
            submission(){
                if(this.questionIndex===this.questions.length){
                    this.postuserChoice();
                }
            }

        }
    }

// // to disable back-button and also to prevent for refresh
// history.pushState(null, null, document.URL);
//    window.addEventListener('popstate', function () {
//    history.pushState(null, null, document.URL);
// });

// //   diable refresh
// function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

// $(document).ready(function(){
//      $(document).on("keydown", disableF5);
// });

</script>
