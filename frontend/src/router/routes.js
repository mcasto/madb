import { useStore } from "src/stores/store";

const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [{ path: "", component: () => import("pages/IndexPage.vue") }],
  },
  {
    path: "/partner-portal/login",
    component: () => import("pages/PartnerLogin.vue"),
  },
  {
    path: "/partner-portal/register",
    component: () => import("pages/PartnerRegister.vue"),
  },
  {
    path: "/verify-email",
    component: () => import("pages/VerifyEmail.vue"),
  },
  {
    path: "/partner-portal",
    component: () => import("layouts/PartnerLayout.vue"),
    beforeEnter: (to, from, next) => {
      const store = useStore();
      if (!store.partner?.token) {
        if (to.path != "/partner-portal/login") {
          next("/partner-portal/login");
          return;
        }
        next();
        return;
      }

      next();
    },
    children: [
      {
        path: "",
        alias: "dashboard",
        component: () => import("pages/PartnerDashboard.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
