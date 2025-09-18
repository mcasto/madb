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
            v-model="confirmPassword"
            :error="errors.confirm.active"
            :error-message="errors.confirm.message"
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
import { Screen } from "quasar";
import { ref } from "vue";

const form = ref({
  email: null,
  password: null,
});

const errors = ref({
  email: {
    active: false,
    message: "",
  },
  password: {
    active: false,
    message: "",
  },
  confirm: {
    active: false,
    message: "",
  },
});

const showPass = ref(false);
const confirmPassword = ref(null);

const resetErrors = () => {
  errors.value = {
    email: {
      active: false,
      message: "",
    },
    password: {
      active: false,
      message: "",
    },
    confirm: {
      active: false,
      message: "",
    },
  };
};

const registerProvider = () => {
  console.log({
    register: {
      email: !!form.value.email,
      password: !!form.value.password,
      confirm: !!confirmPassword.value,
    },
  });

  errors.value.email.active = !!!form.value.email;
  if (!!!form.value.email) {
    errors.value.email.message = "Email Required";
    return;
  }

  errors.value.password.active = !!!form.value.password;
  if (!!!form.value.password) {
    errors.value.password.message = "Password Required";
    return;
  }

  errors.value.confirm.active = !!!confirmPassword.value;
  if (!!!confirmPassword.value) {
    errors.value.confirm.message = "Password Confirmation Required";
    return;
  }

  if (form.value.password != confirmPassword.value) {
    errors.value.password = {
      active: true,
      message: "Password and Confirmation must match",
    };

    errors.value.confirm = {
      active: true,
      message: "Password and Confirmation must match",
    };
    return;
  }
};
</script>
