<template>
  <div class="flex flex-center" style="height: 100vh;">
    <q-card>
      <q-form @submit.prevent="registerProvider">
        <q-toolbar>
          <q-toolbar-title>
            Partner Registration
          </q-toolbar-title>
        </q-toolbar>
        <q-card-section
          class="column q-gutter-y-sm"
          :style="Screen.gt.sm ? 'width:40vw' : 'width:80vw'"
        >
          <q-input
            type="text"
            label="Name"
            dense
            outlined
            v-model="form.name"
            :error="errors.name.active"
            :error-message="errors.name.message"
            @update:model-value="resetErrors"
          ></q-input>
          <q-input
            type="email"
            label="Email"
            dense
            outlined
            v-model="form.email"
            :error="errors.email.active"
            :error-message="errors.email.message"
            @update:model-value="resetErrors"
          ></q-input>
          <q-input
            :type="showPass ? 'text' : 'password'"
            label="Password"
            dense
            outlined
            v-model="form.password"
            :error="errors.password.active"
            :error-message="errors.password.message"
            @update:model-value="resetErrors"
          >
            <template #append>
              <q-btn
                :icon="showPass ? 'visibility_off' : 'visibility'"
                @click="showPass = !showPass"
              ></q-btn>
            </template>
          </q-input>
          <q-input
            :type="showPass ? 'text' : 'password'"
            label="Confirm Password"
            dense
            outlined
            v-model="form.password_confirmation"
            @update:model-value="resetErrors"
          ></q-input>
        </q-card-section>
        <q-separator spaced></q-separator>
        <q-card-actions class="justify-end">
          <q-btn label="Register" color="primary" type="submit"></q-btn>
        </q-card-actions>
      </q-form>
    </q-card>
  </div>
</template>

<script setup>
import { Loading, Notify, Screen } from "quasar";
import callApi from "src/assets/call-api";
import { useStore } from "src/stores/store";
import { ref } from "vue";

const store = useStore();

const form = ref({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
});

const errors = ref({
  name: {
    active: false,
    message: "",
  },
  email: {
    active: false,
    message: "",
  },
  password: {
    active: false,
    message: "",
  },
});

const showPass = ref(false);

const resetErrors = () => {
  errors.value = {
    name: {
      active: false,
      message: "",
    },
    email: {
      active: false,
      message: "",
    },
    password: {
      active: false,
      message: "",
    },
  };
};

const registerProvider = async () => {
  Loading.show({ delay: 300 });

  const response = await callApi({
    path: "/providers/register",
    method: "post",
    payload: { ...form.value, type: "provider" },
  });

  if (response.errors) {
    Loading.hide();

    errors.value = {
      name: {
        active: !!response.errors.name,
        message: response.errors.name?.[0],
      },

      email: {
        active: !!response.errors.email,
        message: response.errors.email?.[0],
      },
      password: {
        active: !!response.errors.password,
        message: response.errors.password?.[0],
      },
    };

    return;
  }

  store.partner = { ...store.partner, user: response };
  store.router.push("/partner-portal/registration-confirmation");

  Loading.hide();
};
</script>
