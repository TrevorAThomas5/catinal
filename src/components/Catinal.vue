<template>
    <div class="cat-term">
        <div class="cat-icon">
            <img src="/black-cat.svg" />
        </div>
        <h1 class="title">Catinal.io</h1>
        <p class="instr">type help to start</p>

        <h1 class='money'>${{this.money}}</h1>

        <div
            onclick="location.href='https://github.com/TrevorAThomas5/catinal'"
            class="git-icon"
        >
            <img src="/github-brands.svg" />
        </div>

        <Terminal :changeMoney='this.changeMoney' :userid='this.userid' :cat='this.cat' :logout='logout'/>
        <Cat v-bind:imgSrc='imgSrc' class="cat" />
    </div>
</template>

<script>
import Terminal from "./Terminal.vue";
import Cat from "./Cat.vue";
import axios from "axios";

export default {
    name: "Catinal",
    components: {
        Terminal,
        Cat,
    },
    props: {
        logoutPage: Function,
        userid: String,
        money: Number,
    },
    data: function() {
        return {
            cat: null,
            imgSrc: '/cat.svg',
        };
    },
    mounted: function() {
        var catinal = this;

        // get this users cat
        axios.get('http://tina.hanaroenterprise.com/api/getcat.php',
            {
                params: {
                    'userid': this.userid,
                },
            })
            .then(function(response) {
                var catData = response.data;

                if(catData === 404){
                    alert("This user doesn't have a cat!");
                    this.logoutPage();
                }
                else {

                    if(catData['hunger'] == 0 || catData['happiness'] == 0)
                        catinal.imgSrc = '/gravestone.svg';

                    catinal.cat = catData;
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    },
    methods: {
        changeMoney: function(money) {
            this.money = money;
        },
        logout: function() {
            this.logoutPage();
        },
    },
};
</script>

<style scoped>

.money {
    text-align: right;
    color: #1b2021;
    position: absolute;
    top: 5px;
    right: 30px;
}

.git-icon {
    height: 15px;
    width: auto;
    position: absolute;
    top: 76px;
    left: 34px;
    cursor: pointer;
}

.cat {
    margin-left: 3vw;
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

.cat-term {
    margin-top: 20vh;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
