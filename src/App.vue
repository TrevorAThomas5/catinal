
<template>
  <div id="app">
    <component v-bind:loginSwitch='this.logoutPage' v-bind:accountPage="this.accountPage" :is="choosePage" v-bind:money='this.money' v-bind:userid='this.userid' v-bind:login='this.login' v-bind:logoutPage='this.logoutPage'></component> 
  </div>
</template>

<script>
/* eslint-disable vue/no-unused-components */
import Catinal from './components/Catinal.vue'
import Login from './components/Login.vue'
import NewAccount from './components/NewAccount.vue'

export default {
  name: 'App',
  components: {
    Catinal,
    Login,
    NewAccount,
  },
  data: function() {
    return {
        page: 'login',
        userid: 0,
        money: 0,
    };
  },
  computed: {
    choosePage: function() {
        switch(this.page) {
            case 'login':
                return 'Login';
            case 'catinal':
                return 'Catinal';
            case 'newaccount':
                return 'NewAccount';
        }
        return 'Login';
    }
  },
  methods: {
    accountPage: function() {
        this.page = 'newaccount';
    },
    login: function(userid, money) {
        this.userid = userid;
        this.money = money;
        this.page = 'catinal';
    },
    logoutPage: function() {
        this.page = 'login';
    }
  },
}
</script>

<style>

html, body {
    height: 100%;
    overflow: hidden;
}

pre, code { font-family: Hack, monospace; }

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: white;
  width: 100%;
  background-color: #eac8af;
  margin-top: 60px;
}

body {
  background-color: #eac8af;
}

</style>
