<template>
  <div class="layout">
    <header-bar></header-bar>
    <div class="content">
      <transition name="fade"><router-view></router-view></transition>
    </div>
    <footer-bar></footer-bar>
  </div>
</template>
<script>
  import HeaderBar from './HeaderBar'
  import FooterBar from './FooterBar'

  export default {
    components: {
      HeaderBar,
      FooterBar
    }
  }
</script>

