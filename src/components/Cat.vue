<template>
    <div>
        <img class='shadow' :src='imgSrc' alt=''/>
    </div>
</template>

<script>
export default {
    name: "Cat",
    components: {
    },
    props: {
        imgSrc: String,
    },
    mounted: function() {
        document.querySelector(".shadow").contentDocument.getElementById("spot").setAttribute("fill", "red")

    },
};
</script>

<style scoped>

.shadow {
  filter: drop-shadow(0px 30px 90px rgba(0, 0, 0, 0.4));
}

</style>
