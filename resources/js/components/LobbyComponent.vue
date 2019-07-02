<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Players Waiting</div>

                    <div class="card-body">
                        <p v-for="user in users" v-text="user.name"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        users: []
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
    }
  }
</script>
