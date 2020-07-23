import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home';
import Search from './pages/Search';
import UserProfile from './pages/user/Profile';

import CourseList from './pages/course/List';
import CourseAdd from './pages/course/Add';
import CourseDetail from './pages/course/Detail';
import CourseReview from './pages/course/Review';

import LessonList from './pages/lesson/List';
import LessonAdd from './pages/lesson/Add';
import LessonDetail from './pages/lesson/Detail';
import LessonReview from './pages/lesson/Review';

import TestList from './pages/test/List';
import TestExam from './pages/test/Exam';
import TestResult from './pages/test/Result';

import Report from './pages/Report';
import NotFound from './pages/NotFound';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            alias: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/search',
            name: 'search',
            component: Search,
            query: true
        },
        {
            path: '/me',
            name: 'me',
            component: UserProfile,
            auth: true
        },
        {
            path: '/user/:userId/profile',
            name: 'user-profile',
            component: UserProfile,
            params: true
        },

        {
            path: '/course',
            name: 'course-list',
            component: CourseList,
            params: true
        },
        {
            path: '/course/add',
            name: 'course-add',
            component: CourseAdd,
            params: true
        },
        {
            path: '/course/:courseName',
            name: 'course-details',
            component: CourseDetail,
            params: true
        },
        {
            path: '/course/:courseName/review',
            name: 'course-review',
            component: CourseReview,
            params: true
        },
        {
            path: '/course/:courseName/report',
            name: 'course-report',
            component: Report,
            auth: true,
            params: true
        },

        {
            path: '/course/:courseName/lessons',
            name: 'lesson-list',
            component: LessonList,
            params: true
        },
        {
            path: '/course/:courseName/add',
            name: 'lesson-add',
            component: LessonAdd,
            params: true
        },
        {
            path: '/course/:courseName/lesson/:lessonName',
            name: 'lesson-details',
            component: LessonDetail,
            params: true
        },
        {
            path: '/course/:courseName/lesson/:lessonName/review',
            name: 'lesson-review',
            component: LessonReview,
            params: true
        },
        {
            path: '/course/:courseName/lesson/:lessonName/report',
            name: 'lesson-report',
            component: Report,
            auth: true,
            params: true
        },

        {
            path: '/tests',
            name: 'test-list',
            component: TestList,
            auth: true,
            query: true,
            params: true
        },
        {
            path: '/test',
            name: 'test-exam',
            component: TestExam,
            auth: true,
            query: true
        },
        {
            path: '/test/:testId/result',
            name: 'test-result',
            component: TestResult,
            auth: true,
        },
        {
            path: '/performance',
            name: 'user-performance',
            component: require('./pages/performance/User'),
            auth: true,
        },

        {
            path: '*',
            name: '404',
            component: NotFound
        }
    ]
});

// Vue.use(routes);
