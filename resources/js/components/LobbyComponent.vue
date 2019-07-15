<template>
  <div>
    <div class="card">
      <div class="card-header">Lobby</div>
      <div class="card-body">
        <div class="container">
          <div class="row justify-content-center">
            <button type="button" v-scroll-to="{ element: '#game', duration: 2000 }" style="display: none;" ref="scrollBtn"></button>
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
              <!-- <button class="btn btn-primary" @click="doReady()">Ready</button> -->
              <!-- <button class="btn btn-primary" @click="doUnready()">Unready</button> -->
              <!-- <div class="card">
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
              </div> -->
            </div>
            <!-- <div style="height: 500px;"></div> -->
          </div>
        </div>
      </div>
    </div>

    <div class="card" v-if="waiting || starting">
      <div class="card-header">Game
      <span class="float-right">{{ this.game.code }}</span></div>
      <div class="card-body">
        <div v-if="launch_game">
          <game-component :you="me" :is_initiator="is_initiator" :round="game"></game-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import GameComponent from './GameComponent.vue';
  var VueScrollTo = require('vue-scrollto');
  Vue.use(VueScrollTo);

  export default {
    props: ['logged_user'],
    components: {GameComponent},
    data() {
      return {
        me: this.logged_user,
        game: {},
        input_code: '',
        waiting: false,
        starting: false,
        is_initiator: false,
        launch_game: false
      }
    },
    created() {
      
      // Echo.join('PlayersOnline').here((users) => {
      //     this.users = users;
      //   }).joining((user) => {
      //     this.users.push(user);
      //   }).leaving((user) => {
      //     this.users = this.users.filter(u => (u.id !== user.id))
      //   });

      // this.scrollEvent();

      // Echo.private('lobby')
      //   .listen('Ready', (e) => {
      //     this.ready.push(e.user);
      //   })
      //   .listen('Unready', (e) => {
      //     this.ready = this.ready.filter(u => (u.id !== e.user.id))
      //   });        
    },
    methods: {
      // scrollEvent($event) {
      //   const elem = this.$refs.scrollBtn;
      //   elem.click();
      // },
      // doReady() {
      //   let user = this.logged_user;
      //   if(!(this.ready.indexOf(user) > -1)) {
      //     axios.get(`/ready/${user.id}`).then(response => {
      //       this.ready.push(user);
      //     }).catch(error => console.log(error.response.data));
      //   } else {
      //     alert("You're Ready!");
      //   }
      // },
      // doUnready() {
      //   let user = this.logged_user;
      //   if(!(this.ready.indexOf(user) < -1)) {
      //     axios.get(`/unready/${user.id}`).then(response => {
      //       this.ready = this.ready.filter(u => (u.id !== user.id))
      //     }).catch(error => console.log(error.response.data));
      //   } else {
      //     alert("You're Ready!");
      //   }
      // },
      create() {
        let user_id = this.logged_user.id;
        axios.post(`/api/rounds/create/${user_id}`, {}).then(response => {
          console.log(response.data);
          this.game = response.data;
          alert('Share this code '+this.game.code+' with your friend');
          this.is_initiator = this.waiting = true;
        }).catch(error => console.log(error.response.data));
      },
      join() {
        let input_code = this.input_code;
        let user_id = this.logged_user.id;
        if(input_code.length === 6) {
          axios.post(`/api/rounds/join/${user_id}`, {code: input_code}).then(response => {
            console.log(response.data);
            this.game = response.data;
            this.launch_game = this.starting = true;
          }).catch(error => console.log(error.response.data));
        } else {
          alert('Invalid Code!');
        }
      }
    }
  }
</script>
