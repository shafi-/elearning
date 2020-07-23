<template>
  <div class="container">
    <app-header />
    <div class="text-center" v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <router-view />
    <div class="text-center pb-3">
        <span>All right reserved &copy; E-learning.com</span>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import AppHeader from './comps/AppHeader'

export default {
  components: { AppHeader },
  computed: {
    ...mapState(['loading'])
  }
}
</script>

<style>

</style>