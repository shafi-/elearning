import Vue from 'vue'
import Vuex from 'vuex'
import * as HttpService from '../services/http';
import { matchString } from '../utils';

Vue.use(Vuex);

// Mutation Types
export const LOADING = 'loading';

export const SEARCH = 'search';

export const LOGGED_IN = 'logged_in';
export const LOGGED_OUT = 'logged_out';

export const LESSON_FETCH_LIST = 'lesson_fetch';
export const LESSON_FETCH_DETAILS = 'lesson_fetch_details';
export const LESSON_UPDATE = 'lesson_update';
export const LESSON_REPORT = 'lesson_report';
export const LESSON_REVIEWED = 'lesson_reviewed';

export const COURSE_FETCH_LIST = 'course_fetch_list';
export const COURSE_FETCH_DETAILS = 'course_fetch';
export const COURSE_UPDATE = 'course_update';
export const COURSE_REPORT = 'course_report';
export const COURSE_REVIEWED = 'course_reviewed';

export const TEST_FETCH_LIST = 'test_fetch_list';
export const TEST_START = 'test_start';
export const TEST_SUBMIT = 'test_submit';

export default new Vuex.Store({
  strict: true,
  plugins: [],
  modules: {},
  actions: {
    getAuth({ commit, state }) {
      return {}
    },
    fetchCourses({ commit }) {
      commit(LOADING, true);

      HttpService.get('/courses').then(data => {
        commit(COURSE_FETCH_LIST, data);
        commit(LOADING, false);
      })
    },
    getLessons({ commit }) {
      commit(LOADING, true);
    },
    fetchCourse({ getters, commit }) {
      commit(LOADING, true);
      commit(LOADING, false);
    }
  },
  state: {
    loading: false,
    search: '',
    auth: {},
    user: {},
    courses: null,
    lessons: null,
    tests: null
  },
  mutations: {
    [SEARCH](state, payload) {
      state.courses = payload;
    },
    [LOGGED_IN](state, user) {
      state.auth = user;
    },
    [LOGGED_OUT](state) {
      state.auth = null;
    },
    [LOADING](state, status) {
      state.loading = status
    },
    [COURSE_FETCH_LIST](state, courses) {
      state.courses = courses
    }
  },
  getters: {
    getCourses(state) {
      return (authorId) => {
        if (!authorId) return state.courses;
        return state.courses.filter(course => course.authorId === authorId);
      }
    },
    getCourseBy(state) {
      return (courseId, field = 'id') => {
        if (state.courses)
          return state.courses.find(course => course[field] === courseId);
      }
    },
    getLessons(state) {
      return (courseId) => {
        if (!courseId) return state.lessons;
        return state.lessons && state.lessons.filter(lesson => lesson.courseId === courseId);
      }
    }
  },
})
