<template>
   <transition     name="custom-classes-transition"
        enter-active-class="animated fadeInRight"
        leave-active-class="animated fadeOutLeft"
        mode="out-in">
              <router-view :urlVote="urlVote"></router-view>
              </transition>
</template>

<script>
export default {
  props: ['urlVote'],
   mounted: function(){
    Promise.all([
    this.$http.get('/api/proyectos?size=100&feasible=true'),
    ])
    .then(results => {
      this.$store.commit('bind',{
        proyectos: this.shuffleArray(results[0].data.data)
      })
    })
  },
  methods: {
     shuffleArray: function(arr) {
      return arr
        .map(a => [Math.random(), a])
        .sort((a, b) => a[0] - b[0])
        .map(a => a[1]);
    }
  }
}
</script>

<style>

</style>
