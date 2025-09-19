<template>
  <div class="flex flex-center" style="height: 100vh;">
    <q-form @submit.prevent="login">
      <q-card>
        <q-toolbar>
          <q-toolbar-title>
            Partner Login
          </q-toolbar-title>
        </q-toolbar>
        <q-card-section
          class="column q-gutter-y-sm"
          :style="Screen.gt.sm ? 'width:40vw' : 'width:80vw'"
        >
          <q-input
            type="email"
            label="Email"
            dense
            outlined
            v-model="form.email"
            required
          ></q-input>
          <q-input
            :type="showPass ? 'text' : 'password'"
            label="Password"
            dense
            outlined
            v-model="form.password"
            required
          ></q-input>
        </q-card-section>
        <q-separator spaced></q-separator>
        <q-card-actions class="justify-between">
          <q-btn
            label="Register"
            color="secondary"
            to="/partner-portal/register"
          ></q-btn>
          <q-btn label="Sign In" color="primary" type="submit"></q-btn>
        </q-card-actions>
      </q-card>
    </q-form>
  </div>
</template>

<script setup>
import { Screen } from "quasar";
import callApi from "src/assets/call-api";
import { useStore } from "src/stores/store";
import { ref } from "vue";

const store = useStore();

const form = ref({
  email: null,
  password: null,
});

const showPass = ref(false);

const login = async () => {
  const response = await callApi({
    path: "/providers/login",
    method: "post",
    payload: form.value,
  });

  store.partner = response;

  store.router.push("/partner-portal");
};
</script>
