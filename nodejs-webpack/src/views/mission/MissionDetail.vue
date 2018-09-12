<template>
  <main>
    传入id {{ id }}
  </main>
</template>

<script>
  export default {
    name: 'MissionDetail',
    data() {
      return {
      
      };
    },
    created() {
    },
    mounted() {
    },
    computed: {
      id() {
        return this.$route.params.id;
      }
    },
    watch: {
      id(newValue) {
        if (newValue !== undefined) {
          console.log(newValue);
        }
      }
    }
  }
</script>

<style scoped>

</style>
