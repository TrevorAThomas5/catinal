<template>
    <div class="term-wrap">
        <div class="term">
            <Lines :lines='this.lines'/>
            <Type :logLine='this.logLine'/>
        </div>
    </div>
</template>

<script>
import Lines from './Lines.vue';
import Type from './Type.vue';
import axios from 'axios';

export default {
    name: "Terminal",
    components: {
        Lines,
        Type, 
    },
    data: function() {
        return {
            lines: [], 
        };
    },
    computed: {
        
    }, 
    props: {
        logout: Function,
        cat: Object,
        userid: String,
        changeMoney: Function,
    },
    created: function() {
        window.addEventListener("resize", this.resize);
    },
    destroyed: function() {
        window.removeEventListener("resize", this.resize);
    },
    methods: {
        resize: function() {
            // trim to fit terminal
            while((window.innerHeight * 0.5) < (18 * this.lines.length)) {
                this.lines.splice(0, 1);
            }
        },
        logLine: function(line) {
            this.lines.push(String.fromCodePoint(0x1F408) + ' ' + line);
            var words = line.split(' ');

            var lines = this.lines;
            var cat = this.cat;
            var term = this;
            
            if(words[0] === 'logout') {
                this.logout();
            
            }
            
            else if(this.cat['hunger'] == 0 || this.cat['happiness'] == 0) {
                this.lines.push("Your cat has died.");
                this.lines.push("Please make a new account to continue playing.");
                this.lines.push("Type logout to quit.");
                return;
            }


            // commands
            switch(words[0]) {
                case 'logout':
                    this.logout();
                    break;
                case  'leaderboard':
                    axios.get('http://tina.hanaroenterprise.com/api/leaderboard.php')
                    .then(function(response) {
                        var res = response.data;

                        var leaders = res.split("\n");

                        for(var x = 0; x < leaders.length; x++)
                            lines.push(leaders[x]);

                        // trim to fit terminal
                        while((window.innerHeight * 0.5) < (18 * lines.length)) {
                            lines.splice(0, 1);
                        }

                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                    break;
                case 'echo':
                    words.splice(0, 1);
                    this.lines.push(words.join(' '));
                    break;
                case 'pet':
                    this.lines.push('Meow!');

                    axios.get('http://tina.hanaroenterprise.com/api/pet.php',
                    {
                        params: {
                            'userid': this.userid,
                            'cat': this.cat['name'],
                        },
                    })
                    .then(function(response) {
                        var res = response.data;

                        console.log(res);
                        
                        if(res == 404) {
                            lines.push(cat['name'] + " doesn't want to be pet.");
                            lines.push("Try petting them tomorrow.");
                        }
                        else if(cat['happiness'] < 10) {
                            cat['happiness'] = res;
                            lines.push(cat['name'] + "'s happiness went up by 2."); 
                        }

                        // trim to fit terminal
                        while((window.innerHeight * 0.5) < (18 * lines.length)) {
                            lines.splice(0, 1);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

                    break;
                case 'feed':
                    this.fedCom = true;

                    this.lines.push('What would you like to feed ' + this.cat['name'] + "?");
                    this.lines.push('&emsp;1. Cat Food: $1');
                    this.lines.push('&emsp;2. Fish: $2');
                    this.lines.push('&emsp;3. Cake: $5');
                    break;
                case '1':
                    if(this.fedCom) {
                        axios.get('http://tina.hanaroenterprise.com/api/feed.php',
                        {
                            params: {
                                'userid': this.userid,
                                'cat': this.cat['name'],
                                'food': 1,
                            },
                        })
                        .then(function(response) {
                            var res = response.data;

                            console.log(JSON.stringify(res));
                            
                            if(res == 404)
                                lines.push(cat['name'] + " is full. Try feeding them tomorrow.");
                            else if(res == 405)
                                lines.push("You don't have enough money.");
                            else if(cat['hunger'] < 10 && res) {
                                cat['hunger'] = res['hunger'];
                                term.changeMoney(res['money']);
                                lines.push(cat['name'] + "'s hunger increased by 1.");
                                lines.push("Your money decreased by 1.");
                            }

                            // trim to fit terminal
                            while((window.innerHeight * 0.5) < (18 * lines.length)) {
                                lines.splice(0, 1);
                            }

                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                    }
                    else
                        this.lines.push('Unknown command: ' + words[0]);
                    break;
                case '2':
                    if(this.fedCom) {
                        axios.get('http://tina.hanaroenterprise.com/api/feed.php',
                        {
                            params: {
                                'userid': this.userid,
                                'cat': this.cat['name'],
                                'food': 2,
                            },
                        })
                        .then(function(response) {
                            var res = response.data;

                            console.log(JSON.stringify(res));
                            
                            if(res == 404){
                                lines.push(cat['name'] + " is full. Try feeding them tomorrow.");
                            }
                            else if(res == 405)
                                lines.push("You don't have enough money.");
                            else if(cat['hunger'] < 10 && res) {
                                cat['hunger'] = res['hunger'];
                                term.changeMoney(res['money']);
                                lines.push(cat['name'] + "'s hunger increased by 3.");
                                lines.push("Your money decreased by 2.");
                            }
                            // trim to fit terminal
                            while((window.innerHeight * 0.5) < (18 * lines.length)) {
                                lines.splice(0, 1);
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                    }
                    else
                        this.lines.push('Unknown command: ' + words[0]);
                    break;
                case '3': 
                    if(this.fedCom) {
                        axios.get('http://tina.hanaroenterprise.com/api/feed.php',
                        {
                            params: {
                                'userid': this.userid,
                                'cat': this.cat['name'],
                                'food': 3,
                            },
                        })
                        .then(function(response) {
                            var res = response.data;

                            console.log(JSON.stringify(res));
                            
                            if(res == 404){
                                lines.push(cat['name'] + " is full. Try feeding them tomorrow.");
                            }
                            else if(res == 405)
                                lines.push("You don't have enough money.");
                            else if(cat['hunger'] < 10 && res) {
                                cat['hunger'] = res['hunger'];
                                term.changeMoney(res['money']);
                                lines.push(cat['name'] + " became full.");
                                lines.push("Your money decreased by 5.");
                            }

                            // trim to fit terminal
                            while((window.innerHeight * 0.5) < (18 * lines.length)) {
                                lines.splice(0, 1);
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                    }
                    else
                        this.lines.push('Unknown command: ' + words[0]);
                    break;
                case 'status':
                    this.lines.push('Current Status:');
                    this.lines.push('&emsp;Name: ' + this.cat['name']);
                    this.lines.push('&emsp;Age: ' + this.cat['age'] + ' days');
                    
                    var hunger = '&emsp;Hunger: ';
                    for(var i = 0; i < this.cat['hunger']; i++)
                        hunger += '▮';
                    for(i = this.cat['hunger']; i < 10; i++)
                        hunger += '▯';
                    this.lines.push(hunger);
                    
                    var happy = '&emsp;Happiness: ';
                    for(i = 0; i < this.cat['happiness']; i++)
                        happy += '▮';
                    for(i = this.cat['happiness']; i < 10; i++)
                        happy += '▯';
                    this.lines.push(happy);
                    break;
                case 'clear':
                    this.lines = [];
                    break;
                case 'help':
                    this.lines.push('List of commands:');
                    this.lines.push('&emsp;clear: clear the terminal');
                    this.lines.push("&emsp;status: show your current cat's status");
                    this.lines.push("&emsp;feed: feed your cat");
                    this.lines.push("&emsp;pet: pet your cat");
                    this.lines.push("&emsp;leaderboard: show the top cat owners");
                    this.lines.push("&emsp;logout: logout of catinal");
                    break;
                default:
                    this.lines.push('Unknown command: ' + words[0]);
                    break;
            }

            if(words[0] != 'feed')
                this.fedCom = false;

            // trim to fit terminal
            while((window.innerHeight * 0.5) < (18 * this.lines.length)) {
                this.lines.splice(0, 1);
            }
        }
    },
};
</script>

<style scoped>

.term {
    font-family: "Roboto Mono", monospace;
    text-align: left;
    padding: 20px;
    font-size: 16px;
    padding-left: 30px;
    padding-right: 30px;
    border-radius: 10px;
    width: 40vw;
    height: 50vh;
    color: white;
    background-color: #1b2021;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 30px 90px;
}

</style>
