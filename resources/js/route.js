import Vue from 'vue';
import VueRouter from 'vue-router';
import { store } from './store'

import PageLayout from './layout/pageLayout.vue';
import AdminLayout from './layout/adminLayout.vue';
import HomeLayout from './layout/HomeLayout.vue';
import SinglePageLayout from './layout/singlePageLayout.vue';
import SubPageLayout from './layout/subPageLayout.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        // {
        //     path: '/',
        //     component: HomeLayout,
        //     children: [{
        //             path: '',
        //             name: 'Home',
        //             component: () =>
        //                 import ('./home/overview/Index.vue'),
        //         },


        //     ],
        // },
        {
            path: '/',
            component: PageLayout,
            children: [{
                    path: '',
                    name: 'Home',
                    component: () =>
                        import ('./home/overview/Index.vue'),
                },


            ],
        },

        {
            path: '/',
            component: SinglePageLayout,
            children: [ //single
                {
                    path: 'contact-us',
                    name: 'Contact Us',
                    component: () =>
                        import ('./pages/Contact.vue'),
                },
                {
                    path: 'about-us',
                    name: 'About Us',
                    component: () =>
                        import ('./pages/About.vue'),
                },
                {
                    path: 'join-group',
                    name: 'Join Group',
                    component: () =>
                        import ('./home/single/JoinGroup.vue'),
                },
                

            ],
        },


        {
            path: '/pages',
            component: PageLayout,
            children: [{
                    path: '/login',
                    name: 'Login',
                    component: () =>
                        import ('./pages/Login.vue'),
                },
                {
                    path: '/register',
                    name: 'Register',
                    component: () =>
                        import ('./pages/Register.vue'),
                },

                {
                    path: '/forget_password',
                    name: 'ForgetPassword',
                    component: () =>
                        import ('./pages/ForgetPassword.vue'),
                }, {
                    path: '/validate_code',
                    name: 'Validate Code',
                    component: () =>
                        import ('./pages/ValidateResetPasswordCode.vue'),
                }, {
                    path: '/reset_password',
                    name: 'Reset Password',
                    component: () =>
                        import ('./pages/ResetPassword.vue'),
                }, {
                    path: '/contact',
                    name: 'Contact Form',
                    component: () =>
                        import ('./pages/ContactUs.vue'),
                },

            ],
        },


        {
            path: '/admin',
            component: AdminLayout,
            meta: { requiresAuth: true },
            children: [{
                    path: '/index',
                    name: 'Index',
                    component: () =>
                        import ('./admin/overview/Dashboard.vue'),
                    meta: { requiresAuth: true },
                }, {
                    path: '/user-business',
                    name: 'User Business',
                    component: () =>
                        import ('./admin/inventory/Business.vue'),
                }, {
                    path: '/user-event',
                    name: 'User Event',
                    component: () =>
                        import ('./admin/inventory/Event.vue'),
                }, {
                    path: '/user-job',
                    name: 'User Job',
                    component: () =>
                        import ('./admin/inventory/Job.vue'),
                }, {
                    path: '/user-service',
                    name: 'User Service',
                    component: () =>
                        import ('./admin/inventory/Service.vue'),
                }, {
                    path: '/user-professional',
                    name: 'User Professional',
                    component: () =>
                        import ('./admin/inventory/Professional.vue'),
                }, {
                    path: '/view-professional',
                    name: 'View Professional',
                    component: () =>
                        import ('./admin/single/Professional.vue'),
                }, {
                    path: '/view-service',
                    name: 'View Service',
                    component: () =>
                        import ('./admin/single/Service.vue'),
                }, {
                    path: '/view-event',
                    name: 'View Event',
                    component: () =>
                        import ('./admin/single/Event.vue'),
                }, {
                    path: '/view-job',
                    name: 'View Job',
                    component: () =>
                        import ('./admin/single/Job.vue'),
                }, {
                    path: '/view-business',
                    name: 'View Business',
                    component: () =>
                        import ('./admin/single/Business.vue'),
                },
                {
                    path: '/view-membership',
                    name: 'View MemberShip',
                    component: () =>
                        import ('./admin/single/Membership.vue'),
                },{
                    path: '/manage_membership',
                    name: 'Manage Memberships',
                    component: () =>
                        import ('./admin/inventory/Membership.vue'),
                }, {
                    path: '/membership_commission',
                    name: 'Membership Commissions',
                    component: () =>
                        import ('./admin/single/MembershipDiscount.vue'),
                }, {
                    path: '/category',
                    name: 'Category',
                    component: () =>
                        import ('./admin/inventory/Category.vue'),
                }, {
                    path: '/user-files',
                    name: 'User Profiles',
                    component: () =>
                        import ('./admin/system/UserFile.vue'),
                }, {
                    path: '/user-skills',
                    name: 'User Skills',
                    component: () =>
                        import ('./admin/system/Skill.vue'),
                }, {
                    path: '/findme-request',
                    name: 'UserRequest',
                    component: () =>
                        import ('./admin/system/FindRequestPage.vue'),
                },  {
                    path: '/role',
                    name: 'Role',
                    component: () =>
                        import ('./admin/inventory/Role.vue'),
                }, {
                    path: '/Permission',
                    name: 'Permissions',
                    component: () =>
                        import ('./admin/inventory/Permission.vue'),
                }, {
                    path: '/users',
                    name: 'Users',
                    component: () =>
                        import ('./admin/system/Users.vue'),
                }, {
                    path: '/area',
                    name: 'Area',
                    component: () =>
                        import ('./admin/inventory/Area.vue'),
                }, {
                    path: '/country',
                    name: 'Country',
                    component: () =>
                        import ('./admin/inventory/Country.vue'),
                }, {
                    path: '/region',
                    name: 'Region',
                    component: () =>
                        import ('./admin/inventory/Region.vue'),
                }, {
                    path: '/district',
                    name: 'District',
                    component: () =>
                        import ('./admin/inventory/District.vue'),
                }, {
                    path: '/area-boss',
                    name: 'Area Boss',
                    component: () =>
                        import ('./admin/inventory/AreaBoss.vue'),
                }, {
                    path: '/area-boy',
                    name: 'Area Boy',
                    component: () =>
                        import ('./admin/inventory/AreaBoy.vue'),
                }, {
                    path: '/area-manager',
                    name: 'Area Manager',
                    component: () =>
                        import ('./admin/inventory/AreaManager.vue'),
                }, {
                    path: '/district-manager',
                    name: 'District Manager',
                    component: () =>
                        import ('./admin/inventory/DistrictManager.vue'),
                }, {
                    path: '/regional-manager',
                    name: 'Regional Manager',
                    component: () =>
                        import ('./admin/inventory/RegionalManager.vue'),
                }, {
                    path: '/commission',
                    name: 'Commision',
                    component: () =>
                        import ('./admin/inventory/Commission.vue'),
                }, {
                    path: '/promotion',
                    name: 'Promotion',
                    component: () =>
                        import ('./admin/inventory/Promotion.vue'),
                }, {
                    path: '/payment-channel',
                    name: 'Payment Channel',
                    component: () =>
                        import ('./admin/inventory/PaymentChannel.vue'),
                }, {
                    path: '/verification',
                    name: 'Verification',
                    component: () =>
                        import ('./admin/inventory/Verification.vue'),
                }, {
                    path: '/flag',
                    name: 'Flag',
                    component: () =>
                        import ('./admin/inventory/Flag.vue'),
                },

            ],
        }, {
            path: "*",
            name: 'NotFound',
            component: HomeLayout,
            children: [{
                path: "*",
                name: "NotFoundPath",
                component: () =>
                    import ('./layout/notFound.vue')
            }]
        }
    ],
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const token = store.getters['auth/getToken'];

    // if (requiresAuth && !token) {
    //     next({ name: 'Login' });
    // } else if (to.name == 'Login' && token) {
    //     next({ name: 'Index' });
    // } else if (to.name == 'Register' && token) {
    //     next({ name: 'Index' });
    // } else {
    //     next();
    // }
    next();
});

export default router;