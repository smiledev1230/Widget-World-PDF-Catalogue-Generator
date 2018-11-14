const layout = [{
    path: '/',
    component: resolve => require(['pages/index'], resolve),
    meta: {
        title: "Welcome James",
        bgColor: true,
    }
}, {
    path: '/recent',
    component: resolve => require(['pages/recent'], resolve),
    meta: {
        title: "Recent Catalogues",
    }
}, {
    path: '/new_catalogue',
    component: resolve => require(['pages/new_catalogue'], resolve),
    meta: {
        title: "Create a New Catalogue",
        isShowTitle: false,
    }
}, {
    path: '/select_products',
    component: resolve => require(['pages/select_products'], resolve),
    meta: {
        title: "Select Your Products",
        catalogue: true
    }
}, {
    path: '/build_catalogue',
    component: resolve => require(['pages/build_catalogue'], resolve),
    meta: {
        title: "Build Your Catalogue",
        catalogue: true
    }
}, {
    path: '/catalogue_preview',
    component: resolve => require(['pages/catalogue_preview'], resolve),
    meta: {
        title: "Catalogue Preview",
        catalogue: true
    }
}, {
    path: 'user_profile',
    component: resolve => require(['pages/user_profile'], resolve),
    meta: {
        title: "User Profile",
    }
}, {
    path: 'edit_user',
    component: resolve => require(['pages/edit_user'], resolve),
    meta: {
        title: "Edit User",
    }
}]

export default layout
