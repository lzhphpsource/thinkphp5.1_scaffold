<style scoped lang="scss">
  .title {
    background: #000;
  }
</style>

<template>
  <section>
    <a href="#" @click="dialog.show = true">测试内容</a>
  </section>
</template>

<script>
  import Component from 'vue-class-component'

  @Component
  export default class Index extends Vue {
    dialog = {
      show: false
    }

  }
</script>
