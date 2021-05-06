<template>
    <div>
        <div class='lines-wrap' v-html='logs'></div>
    </div>
</template>

<script>
export default {
    name: "Lines",
    components: {
    },
    props: {
        lines: Array,
    },
    computed: {
        logs: function () {
            var html = '';

            for(var i = 0; i < this.lines.length; i++) {
                html += ("<div style='white-space: nowrap; overflow: hidden;  z-index:10; height:18px; line-height: 1'>"+this.lines[i]+"</div>")
            }

            return html
        }
    },
};
</script>

<style scoped>

.lines-wrap {
    line-height: 0;
    display: flex;
    justify-content: center;
    flex-direction: column;
}


</style>
