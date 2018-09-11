<template>
  <main>
    啊哈哈
  </main>
</template>

<script>
  export default {
    name: 'MissionDetail',
    data() {
      return {
        id: undefined
      };
    },
    created() {
      console.log(this.$route.params);
    },
    mounted() {
    }
  }
</script>

<style scoped>

</style>
