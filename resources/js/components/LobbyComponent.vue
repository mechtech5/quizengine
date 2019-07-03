<template>
  <div>
    <div class="card">
      <div class="card-header">Lobby</div>
        <div class="card-body">
          <div class="container">
            <div class="row justify-content-center">
              <button type="button" v-scroll-to="{ element: '#game', duration: 2000 }" style="display: none;" ref="scrollBtn"></button>
              <div class="col-md-8">
                <button class="btn btn-primary" @click="doReady()">Ready</button>
                <button class="btn btn-primary float-right" @click="doUnready()">Unready</button>
                <div class="card">
                  <div class="card-header">Players online</div>
                  <div class="card-body">
                    <a href="#" v-for="user in users" class="badge badge-primary" v-text="user.name"></a>
                  </div>
                </div>
                <hr>
                <div class="card">
                  <div class="card-header">Players ready</div>
                  <div class="card-body">
                    <a href="#" v-for="user in ready" class="badge badge-primary" v-text="user.name"></a>
                  </div>
                </div>
                <hr>
                <div class="card">
                  <div class="card-header">Players in-game</div>
                  <div class="card-body">
                    <a href="#" v-for="user in in_game" class="badge badge-primary" v-text="user.name"></a>
                  </div>
                </div>
              </div>
              <div style="height: 500px;"></div> 
            </div>
          </div>
        </div>
    </div>

    <div class="card">
      <div class="card-header">Game</div>
      <div class="card-body">
        <span id="game">
          <game-component></game-component>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
  import GameComponent from './GameComponent.vue';
  var VueScrollTo = require('vue-scrollto');
  Vue.use(VueScrollTo)
  export default {
    props: ['logged_user'],
    components: {GameComponent},
    data() {
      return {
        users: [],
        ready: [],
        in_game: []
      }
    },
    mounted() {
      Echo.join('PlayersOnline').here((users) => {
          this.users = users;
        }).joining((user) => {
          this.users.push(user);
        }).leaving((user) => {
          this.users = this.users.filter(u => (u.id !== user.id))
        });

        this.scrollEvent();

      Echo.private('lobby')
		    .listen('Ready', (e) => {
		        console.log(e.user);
		        this.ready.push(e.user);
		    });  
    },
    methods: {
      scrollEvent($event) {
        const elem = this.$refs.scrollBtn;
        elem.click();
      },
      doReady() {
        let user = this.logged_user;
        if(!(this.ready.indexOf(user) > -1)){
          axios.get(`/ready/${this.logged_user.id}`).then(response => {
            
          }).catch(error => console.log(error.response.data));

          this.ready.push(this.logged_user);
        }else{
          alert("You're Ready!");
        }
      },
      doUnready() {
        this.ready = this.ready.filter(u => (u.id !== this.logged_user.id))
      }
    }
  }
</script>
