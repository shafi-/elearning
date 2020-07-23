<template>
  <div class="row">
    <table class="table table-striped table-inverse table-sm">
      <thead class="thead-inverse">
        <tr>
          <th>Id</th>
          <th>Title</th>
          <!-- <th>Description</th> -->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="col-12">
        <tr v-for="course in courses" :key="course.id" class="">
          <td scope="row">{{ course.id }}</td>
          <td class="btn-link" @click="gotoCourseDetails(course)">{{ course.title }}</td>
          <!-- <td class="text-truncate">{{ course.description }}</td> -->
          <td>
            <a class="btn btn-sm btn-outline-secondary" @click="(e) => e.preventDefault()" role="button">
              &laquo; Edit
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'

export default {
  data() {
    return {
    }
  },
  created() {
    if (!this.courses)
      this.fetchCourses();
  },
  methods: {
    gotoCourseDetails(course) {
      this.$router.push({
        name: 'course-details',
        params: { courseName: this.getSlug(course.title) }
      });
    },
    /**
     * @param {string} course
     * @returns {string}
     */
    getSlug(course) {
      return course;
      // return course.replace(' ', '-');
    },
    ...mapGetters(['getCourses']),
    ...mapActions(['fetchCourses'])
  },
  computed: {
    ...mapState(['courses'])
  }
}
</script>

<style>

</style>