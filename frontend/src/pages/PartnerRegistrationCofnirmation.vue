<template>
  <div class="q-pa-md">
    <div class="row justify-center">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Header section -->
        <div class="row items-center q-mb-lg q-gutter-x-sm">
          <div class="col-auto">
            <q-icon name="fa-solid fa-handshake" size="sm" color="primary" />
          </div>
          <div class="col">
            <div class="text-h4 text-weight-bold text-primary">
              MADB: The Martial Arts Database
            </div>
          </div>
        </div>

        <!-- Main content card -->
        <q-card class="q-pa-lg q-mb-md" dark>
          <div class="row justify-center q-mb-md">
            <q-icon
              name="fa-solid fa-envelope-circle-check"
              size="xl"
              color="positive"
            />
          </div>

          <div class="text-h4 text-weight-bold text-center q-mb-sm">
            Thank You for Registering!
          </div>
          <div
            class="text-h6 text-weight-medium text-center text-blue-3 q-mb-lg"
          >
            Welcome to our Partner Program
          </div>

          <q-separator class="q-my-lg" />

          <div class="text-body1 q-mb-md">
            We look forward to helping prospective students find you for
            training.
          </div>

          <div class="text-body1 q-mb-md">
            We've sent a verification email to your inbox. Please check your
            email and click the verification link to activate your partner
            account.
          </div>

          <div class="text-body1 q-mb-lg">
            This verification helps us ensure the security of your account and
            access to your profile.
          </div>

          <q-banner rounded class="bg-blue-9 text-white q-mb-lg">
            <template v-slot:avatar>
              <q-icon name="info" color="white" />
            </template>
            Can't find the email? Check your spam folder or click below to
            resend the verification email.
          </q-banner>

          <div class="row justify-between items-center">
            <q-btn
              color="primary"
              icon="fa-solid fa-paper-plane"
              label="Resend Verification Email"
              unelevated
              @click="resend"
            />
            <q-btn
              color="blue-3"
              icon="mail"
              label="Sign In"
              outline
              to="/partner-portal"
            />
          </div>
        </q-card>

        <!-- Support section -->
        <q-card class="q-pa-md" dark>
          <div class="text-h6 text-weight-medium q-mb-md">Need Assistance?</div>
          <div class="row items-center q-gutter-md">
            <q-icon name="support_agent" color="blue-3" size="md" />
            <div class="col">
              <div class="text-body2">
                Our support team is here to help you with the verification
                process.
              </div>
              <div class="text-caption text-blue-3">
                madb-support@castoware.com
              </div>
            </div>
          </div>
        </q-card>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Loading, Notify } from "quasar";
import callApi from "src/assets/call-api";
import { useStore } from "src/stores/store";

const store = useStore();

const resend = async () => {
  Loading.show({ delay: 300 });
  const response = await callApi({
    path: "/providers/resend-verification-email",
    method: "post",
    payload: { email: store.partner.user.email },
  });

  Notify.create({
    type: "positive",
    message: response.message,
  });
  Loading.hide();
};
</script>
