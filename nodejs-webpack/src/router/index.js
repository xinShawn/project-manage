import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/components/HelloWorld'
import main from '../components/main/main'
import missions from '../components/missions/missions'
import projects from '../components/projects/projects'
import backend from '../components/backend/backend'

Vue.use(Router)

export default new Router({
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
  ]
})
