import Vue from 'vue'
import Router from 'vue-router'
import before from "./before"
// import HelloWorld from '@/components/HelloWorld'
import main from '../views/main/main'
import missions from '../views/missions/missions'
import projects from '../views/projects/projects'
import backend from '../views/backend/backend'
import init from '../views/login/init'
import login from '../views/login/login'

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
    },
    {
      path: '/login',
      component: login
    }
  ],
});
//
// /**
//  * 路由守卫
//  */
// router.beforeEach(before);

export default router
