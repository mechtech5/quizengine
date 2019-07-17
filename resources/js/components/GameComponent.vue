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
				<span class="row" v-if="started">
		    	<div class="col-3">
		    		<p v-text="me.name"></p>
		    		<p v-text="round.score_1"></p>
		    	</div>
		    	<div class="col-6">
		    		<p v-text="round.question"></p>
		    		<button class="btn" v-for="(value, name) in round.options" @click="check(name)" v-text="value"></button>
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
          let id = this.round.id;
          axios.get(`/api/rounds/${id}`).then(response => {
            this.round = response.data;
            console.log('FriendIsHere', response.data);
          })
          this.opponent = e.user;
          this.started = true;
      });
		},
		methods: {
			create() {
        axios.post(`/api/rounds/create/${this.me.id}`, {}).then(response => {
          console.log('Create', response.data);
          this.round = response.data;
          this.is_initiator = true;
          alert('Share this code '+this.round.code+' with your friend');
        }).catch(error => console.log(error.response.data));
      },

      join() {
        if(this.input_code.length === 6) {
          axios.post(`/api/rounds/join/${this.me.id}`, {code: this.input_code}).then(response => {
            console.log('Join', response.data);
            this.round = response.data;
            axios.get(`/api/users/${response.data.player_1}`).then(response => {
              this.opponent = response.data;
            })
            this.started = true;
          }).catch(error => console.log(error.response.data));
        } else {
          alert('Invalid Code!');
        }
      },

			ask() {

			},
			check() {

			},

			// Utils
			getQuestions(topic_id) {
				axios.get(`/api/questions/${topic_id}`).then(response => {
					this.questions = response.data;
				}).catch(error => console.log(error.response.data));
			},
			getPlayerDetails(id) {
				axios.get(`/api/users/${id}`).then(response => {
					this.player_2 = response.data;
				}).catch(error => console.log(error.response.data));
			}
		}
	}
</script>