<template>
    <div class="type-wrap">
        <h1 class="tri">{{String.fromCodePoint(0x1F408)}}</h1>
        <input id='prompt' v-on:keyup="enterDown" v-model='line' class="prompt" type='text' autofocus>
    </div>
</template>

<script>
export default {
    name: "Type",
    components: {
    },
    props: {
        logLine: Function,
    },
    data: function() {
        return {
            line: '',
        }
    },
    methods: {
        enterDown: function(e) {
            if (e.keyCode === 13) {
                this.logLine(this.line);
                document.getElementById('prompt').value = '';
                this.line = '';
            }
        }
    },
};
</script>

<style scoped>

.prompt {
    font-family: "Roboto Mono", monospace;
    font-size: 16px;
    width: 100%;
    margin-left: 7px;
    background-color: #1b2021;
    border: none;
    color: white;
    line-height: 0;
}

.prompt:focus {
    outline-width: 0;
}

.tri {
    line-height: 0;
    margin: 0px;
    font-size: 16px;
    color: white;
}

.type-wrap {
    align-items: center;
    justify-content: center;
    height:18px;
    margin: 0px;
    font-size: 12px;
    display: flex;

    color: white;
}

</style>
