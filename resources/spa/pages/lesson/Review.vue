<template>
  <div>
    <div>Experts will review this lesson here</div>
    <div>There will be list of reports, if any</div>
  </div>
</template>

<script>
export default {
  beforeCreate() {
    this.lessonName = this.$route.params.lessonName
  }
}
</script>

<style>

</style>