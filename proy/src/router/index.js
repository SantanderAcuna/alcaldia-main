import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: function () {
      return import(/* webpackChunkName: "about" */ "../views/AboutView.vue");
    },
  },


  // Alcaldes Routes

  {
    path: '/alcaldes',
    name: 'Alcaldes',
    component: () => import('../views/alcalde/AlcaldeView.vue') 
  },
  {
    path: '/alcaldes/:id',
    name: 'AlcaldeDetalle',
    component: () => import('../views/alcalde/AlcaldeDetail.vue'),
    props: true
  }
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
