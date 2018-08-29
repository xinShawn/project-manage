import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/components/HelloWorld'
import main from '../views/main/main'
import missions from '../views/missions/missions'
import projects from '../views/projects/projects'
import backend from '../views/backend/backend'

Vue.use(Router)

let router = new Router({
  routes: [
    {
      path: '/',
      redirect: 'main'
    },
    {
      path: '/main',
      name: 'main',
      component: main
    },
    {
      path: '/missions',
      name: 'missions',
      component: missions
    },
    {
      path: '/projects',
      name: 'projects',
      component: projects
    },
    {
      path: '/backend',
      name: 'backend',
      component: backend
    }
  ],
});

/**
 * 路由判断
 */
router.beforeEach((to, from, next) => {
  console.log(to, from, next);
});

export default router
