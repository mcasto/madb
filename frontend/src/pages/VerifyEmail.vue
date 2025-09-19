<template>
  <div class="flex flex-center" style="height: 100vh;">
    <div class="text-center">
      <template v-if="status === 'verifying'">
        <q-spinner-gears size="50vh" color="primary" />
        <div class="q-mt-md text-h6">Verifying your email...</div>
      </template>

      <template v-else-if="status === 'success'">
        <q-icon name="check_circle" color="positive" size="50px" />
        <div class="q-mt-md text-h6">Email verified successfully!</div>
        <q-btn
          to="/login"
          color="primary"
          label="Go to Login"
          class="q-mt-md"
        />
      </template>

      <template v-else-if="status === 'error'">
        <q-icon name="error" color="negative" size="50px" />
        <div class="q-mt-md text-h6">{{ errorMessage }}</div>
        <q-btn to="/" color="primary" label="Go Home" class="q-mt-md" />
      </template>
    </div>
  </div>
</template>

<script setup>
import { Notify } from "quasar";
import callApi from "src/assets/call-api";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();
const status = ref("verifying");
const errorMessage = ref("");

onMounted(async () => {
  const { id, hash } = route.query;

  if (!id || !hash) {
    status.value = "error";
    errorMessage.value = "Invalid verification link";
    return;
  }

  const response = await callApi({
    path: `/email/verify/${id}/${hash}`,
    method: "get",
  });

  const type = response.error ? "negative" : "positive";
  Notify.create({
    type,
    message: response.message,
  });

  if (!response.error) {
    router.push("/partner-portal/login");
  }
});
</script>
