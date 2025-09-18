<template>
  <div class="flex flex-center" style="height: 100vh;">
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
          type="text"
          label="Email"
          dense
          outlined
          v-model="form.email"
        ></q-input>
        <q-input
          :type="showPass ? 'text' : 'password'"
          label="Password"
          dense
          outlined
          v-model="form.password"
        ></q-input>
      </q-card-section>
      <q-separator spaced></q-separator>
      <q-card-actions class="justify-between">
        <q-btn
          label="Register"
          color="secondary"
          to="/partner-portal/register"
        ></q-btn>
        <q-btn label="Sign In" color="primary"></q-btn>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
import { Screen } from "quasar";
import { ref } from "vue";

const form = ref({
  email: null,
  password: null,
});

const showPass = ref(false);
</script>
