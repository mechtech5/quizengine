<template>
  <div class="card">
    <div class="card-header">QuizEngine
		<span class="float-right" v-text="this.round.code"></span>
    </div>
      <div class="card-body">
        <div class="container" v-if="!started">
          <div class="row justify-content-center">
						<div class="col-md-8">
				      <div class="text-center">
				        <button class="btn btn-outline-secondary" @click="create()">Create</button>
				      </div>
				      <br>
				      <p class="text-center">OR</p>
				      <div class="input-group mb-3">
				        <input type="text" class="form-control" placeholder="Enter the code" v-model="input_code">
				        <div class="input-group-append">
				          <button class="btn btn-outline-secondary" type="button" @click="join()">
				          Join</button>
				        </div>
				      </div>
				    </div>
					</div>		
				</div>
				<hr>
				<span class="row">
		    	<div class="col-3">
		    		<p v-text="me.name"></p>
		    		<p v-text="round.score_1"></p>
		    	</div>
		    	<div class="col-6 text-center">
		    		<span v-for="quest in questions" :key="quest.id">
		    			<p>Question No. {{ quest.id }}</p>
		    			<h3 v-text="quest.ques"></h3>
		    			<button class="btn btn-primary m-2" 
		    				v-for="(value, name) in JSON.parse(quest.options)" 
		    				@click="checkAnswer(quest name)" 
		    				v-text="value"></button>
		    		</span>
		    		
		    	</div>
		    	<div class="col-3 text-right">
		    		<p v-text="opponent.name"></p>
		    		<p v-text="round.score_2"></p>
		    	</div>
		    </span>
			</div>
		</div>
</template>

<script>
	export default {
		props: ['logged_user'],
		data() {
			return {
				// Game
				round: {},
				started: false,
				is_initiator: false,
				input_code: '',
				started: false,

				// Players
				me: {},
				opponent: {},

				// Quiz
				timer: 10,
				questions: [],
			}
		},
		mounted() {
			this.me = this.logged_user;

			Echo.channel('game')
        .listen('FriendIsHere', (e) => {
          this.startGame();
      });  
		},
		methods: {
			create() {
        axios.post(`/api/rounds/create/${this.me.id}`, {}).then(response => {
          console.log('Create', response.data);
          this.round = response.data.round;
          this.questions = response.data.questions;
          this.is_initiator = true;
          alert('Share this code '+this.round.code+' with your friend');
        }).catch(error => console.log(error.response.data));
      },

      join() {
        if(this.input_code.length === 6) {
          axios.post(`/api/rounds/join/${this.me.id}`, {code: this.input_code}).then(response => {
            console.log('Join', response.data);
            this.round = response.data.round;
            this.opponent = response.data.opponent;
            this.questions = response.data.questions;
            this.started = true;
          }).catch(error => console.log(error.response.data));
        } else {
          alert('Invalid Code!');
        }
      },
			ask() {

			},
			checkAnswer(ans) {

			},

			// Utils
			startGame() {
				axios.post(`/api/rounds/start/${this.round.id}`).then(response => {
					this.round = response.data.round;
					this.opponent = response.data.opponent;
					this.started = true;
				}).catch(error => console.log(error.response.data));
			},
		}
	}
</script>