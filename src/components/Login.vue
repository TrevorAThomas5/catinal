<template>
    <div class='login-wrap'>
        <div class="cat-icon">
            <img src="/black-cat.svg" />
        </div>
        <h1 class="title">Catinal.io</h1>
        <p class="instr">type help to start</p>

        <div
            onclick="location.href='https://github.com/TrevorAThomas5/catinal'"
            class="git-icon"
        >
            <img src="/github-brands.svg" />
        </div>

        <div class='login-card'>
            <div class='look-wrap'>
                <img class='look-img' src="/cat.svg" />
            </div>
            <h3 >Username</h3>
            <input v-on:keyup='this.enterPress' v-model='username' type='text'>
            <h3 >Password</h3>
            <input v-on:keyup='this.enterPress' v-model='password' type='password'>
            <button v-on:click='this.loginClick'>Log in</button> 
            <div class="no-acc-wrap">
                <h3 class='no-acc'>No account?</h3>
                <h3 v-on:click='this.switchAccount' class='a'>Create one</h3>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Login",
    components: {
    },
    props: {
        login: Function,
        accountPage: Function,
    },
    data: function() {
        return {
            username: '',
            password: '',
        };
    },
    methods: {
        switchAccount: function() {
            this.accountPage();
        },
        enterPress: function(e) {
            if(e.keyCode == 13) {
                this.loginClick();
            }
        },
        loginClick: function() {
            var login = this.login;


            axios.get('http://tina.hanaroenterprise.com/api/login.php',
                {
                    params: {
                        'username': this.username,
                        'password': this.password,
                    },
                })
                .then(function(response) {
                    var userData = response.data;

                    if(userData !== 404) {
                        console.log(userData)
                        login(userData['userid'], userData['money']);
                    }
                    else {
                        alert('Wrong username/password!');
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    },
};
</script>

<style scoped>


.new-acc {
    position: absolute;
    display: flex;
    flex-direction: row;
    text-align: center;
    align-items: center;
    justify-content: center;
    top: 60vh;
    left: 50vw;
    transform: translate(-50%, 900%);
}

.no-acc {
    font-size: 20px;
    color: #1b2021;
    margin: 0px;
    line-height: 1;
}

.a {
    cursor: pointer;
    font-size: 20px;
    font-weight: bold;
    line-height: 1;
    text-decoration: none;
    color: #5f939a;
    margin: 0px;
    transition: 0.3s;
    margin-left: 10px;
}

.a:hover {
    filter: brightness(150%);
}

.look-wrap {
    overflow: hidden;
    margin-top: 30px;
    border: solid 5px #eac8af;
    align-self: center;
    border-radius:100px;
    width: 175px;
    height: 175px;
    background: white;
}

.git-icon {
    height: 15px;
    width: auto;
    position: absolute;
    top: 76px;
    left: 34px;
    cursor: pointer;
}

.cat-icon {
    height: 30px;
    width: auto;
    position: absolute;
    top: 30px;
    left: 30px;
}

.title {
    color: #1b2021;
    position: absolute;
    top: 5px;
    left: 60px;
}

.instr {
    color: #1b2021;
    position: absolute;
    top: 47px;
    left: 34px;
    font-size: 12px;
}

.login-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-card {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    position: absolute;
    top: 50vh;
    left: 50vw;
    transform: translate(-50%, -50%);
    text-align: left;
    background-color: #1b2021;
    width: 350px;
    height: 520px;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 30px 90px;
}

h3 {
    font-size: 17px;
    margin: 0px;
    margin-left: 40px;
    margin-bottom: 5px;
    margin-top: 20px;
}

input {
    text-indent: 10px;
    font-weight: bold;
    color: #1b2021;
    font-size: 17px;
    height: 44px;
    margin-left: 40px;
    margin-right: 40px;
    border-radius: 3px;
    border: none;
}

input:focus {
    outline: none;
    filter: drop-shadow(0 0 0.15rem white);
}

.look-img {
    overflow: hide;
    transform: scale(0.7) translate(-122px, -70px);
}

button {
    border: none;
    border-radius: 3px;
    background: #eac8af;
    color: #1b2021;
    font-size: 20px;
    font-weight: bold;
    height: 50px;
    margin-left: 40px;
    margin-right: 40px;
    margin-top: 30px;
      cursor: pointer;
}

button:focus {
    outline: none;
}

button:active {
    background-color: #d8ac9c;
}

.no-acc-wrap {
    display: flex;
    flex-direction: row;
    align-self: center;
    text-align: center;
    transform: translate(0px, 50px);
}

</style>
