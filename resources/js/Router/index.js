import { createWebHistory, createRouter } from "vue-router";

export const routes = [
    {
        name:'store',
        path:'/store',
        component: ()=> import('../Pages/Store.vue')
    },
    {
        name:'pos',
        path:'/pos',
        component: ()=> import('../Pages/Pos.vue')
    },
    {
        name:'transection',
        path:'/transection',
        component: ()=> import('../Pages/Transection.vue')
    },
    {
        name:'report',
        path:'/report',
        component: ()=> import('../Pages/Report.vue')
    },
    {
        name:'no_page',
        path:'/:pathMacth(.*)*',
        component: ()=> import('../Pages/NoPage.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

export default router