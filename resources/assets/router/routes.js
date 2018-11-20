import layout_routes from './layout'

const routes = [{
    path: '/',
    component: resolve => require(['src/layout'], resolve),
    children: layout_routes
    }, {
        path: '/login',
        component: resolve => require(['pages/login'], resolve),
        meta: {
            title: "Login",
        }
    }, {
        path: '/500',
        component: resolve => require(['pages/500'], resolve),
        meta: {
            title: "500",
        }
    },
    {
        path: '*',
        component: resolve => require(['pages/404'], resolve),
        meta: {
            title: "404",
        }
    }
]
export default routes
