<template>
  <div>
    <div>Experts will review this course here</div>
    <div>There will be list of reports, if any</div>
  </div>
</template>

<script>
export default {
  beforeCreate() {
    this.courseName = this.$route.params.courseName
  }
}
</script>

<style>

</style>