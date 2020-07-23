<template>
  <div>
      <span>Search</span>
      <div class="form-group">
        <label for="search">Search</label>
        <input type="text" v-model="searchKey" class="form-control" name="search" id="search" aria-describedby="SearchId" placeholder="Search by">
        <small id="SearchId" class="form-text text-muted">Write the search term here</small>
      </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            searchKey: ''
        }
    }
}
</script>

<style>

</style>