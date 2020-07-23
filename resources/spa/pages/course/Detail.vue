<template>
  <div>Course Detail</div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
  data() {
    return {
      courseName: this.$route.params.courseName
    }
  },
  created() {
    if (!this.course)
      this.$store.dispatch('fetchCourses');
  },
  methods: {
    ...mapGetters({
      getLessons: 'getLessons',
      getCourseBy: 'getCourseBy'
    })
  },
  computed: {
    course() {
      return this.courses && this.courses.find(course => course.title === this.courseName)
    },
    courseLessons() {
      return this.course && this.lessons && this.lessons.filter(lesson => lesson.course_id === this.course.id);
    },
    ...mapState(['courses', 'lessons'])
  }
}
</script>

<style>

</style>