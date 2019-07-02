<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <button class="btn btn-primary" @click="ready()">Ready</button>
        <button class="btn btn-primary" @click="unready()">Unready</button>
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
            <a href="#" v-for="user in waiting" class="badge badge-primary" v-text="user.name"></a>
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
    </div>
  </div>
</template>

<script>
  export default {
    props: ['logged_user'],
    data() {
      return {
        users: [],
        waiting: [],
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
    },
    methods: {
      ready() {
        let user = this.logged_user;
        if(!(this.waiting.indexOf(user) > -1))
          this.waiting.push(this.logged_user);
        else
          alert("You're Ready!");
      },
      unready() {
        this.waiting = this.waiting.filter(u => (u.id !== this.logged_user.id))
      }
    }
  }
</script>
