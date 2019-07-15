<template>
	<div class="row">
		<div class="col-3">
			<p v-text="player_1.name"></p>
			<p v-text="game.score_1"></p>
		</div>
		<div class="col-6">
			<p v-text="game.question"></p>
			<button class="btn" v-for="(value, name) in game.options" @click="check(name)" v-text="value"></button>
		</div>
		<div class="col-3 text-right">
			<p v-text="player_2.name"></p>
			<p v-text="game.score_2"></p>
		</div>
		
	</div>
</template>

<script>
	export default {
		props: ['you', 'opponent', 'round', 'is_initiator'],
		data() {
			return {
				timer: 10,
				questions: [],
				game: {},
				player_1: {},
				player_2: {}
			}
		},
		mounted() {
			this.game = this.round;
			this.setPlayer();
		},
		methods: {
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
			setPlayer() {
				if(this.is_initiator) {
					this.player_1 = this.you;
					this.player_2 = this.opponent;
				} else {
					this.player_2 = this.you;
					this.player_1 = this.opponent;
				} 
			},
			getPlayerDetails(id) {
				axios.get(`/api/users/${id}`).then(response => {
					this.player_2 = response.data;
				}).catch(error => console.log(error.response.data));
			}
		}
	}
</script>