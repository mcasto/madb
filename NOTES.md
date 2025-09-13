### Refined Logical Task List & Technical Summary

**Phase 0: Project & Legal Foundation**
1.  **Draft Privacy Policy & Terms of Service:** This is now a **blocking requirement**. Your policy must clearly state:
    *   What data you collect (especially business vs. personal addresses).
    *   How it's used (e.g., geocoding, public display).
    *   The provider's control over their visibility settings (address, phone, email).
    *   Your use of cookies and third-party services (Google, PayPal).
    *   The process for data deletion requests.
2.  **Setup Laravel with Sanctum** for the Quasar/Vue3 frontend.

**Phase 1: Core Application & Data Foundation**
3.  **Implement Enhanced Database Schema:** Build the migrations and models, adding new critical fields:
    *   `locations` table: Add `is_public` (BOOLEAN) flags for `address`, `phone`, and `email`.
    *   `locations` table: Add a `contact_form_email` (VARCHAR) field to hold an alias for the form.
    *   `provider_profiles` table: Ensure `subscription_status` has an `'incomplete'` state for users mid-registration.
4.  **Create Seeders** with the new visibility fields.

**Phase 2: Geolocation & Search Foundation**
5.  **Integrate Geocoding:** Install [`geocoder-php/GeocoderLaravel`](https://github.com/geocoder-php/GeocoderLaravel).
    *   **Your caching point is correct:** The package's caching is irrelevant for your primary use case. You will only call the Google API **once** on registration/address update and then **store the result permanently in your `locations` table.** The package's cache would only prevent duplicate API calls *within the same request lifecycle*, which isn't your concern.
6.  **Implement Address Standardization:** Integrate [`convissor/address_standardization_solution_php`](https://github.com/convissor/address_standardization_solution_php). The registration flow becomes:
    *   Provider enters address -> Your backend standardizes it -> Geocodes the standardized string -> Saves `standardized_address`, `lat`, `lng`.
7.  **Build Haversine Search:** Install [`salman1802/laravel-haversine`](https://github.com/salman1802/laravel-haversine). The search API endpoint must now also respect the `is_public` flags:
    *   If `address_is_public` is `false`, the returned JSON should obscure or omit the exact address (e.g., only show city/state).
    *   It should still use the precise `lat`/`lng` for distance calculation.

**Phase 3: User Authentication & Onboarding**
8.  **Build Public-Facing Pages (Quasar/Vue3):**
    *   Homepage with search.
    *   Search results page.
    *   Provider profile page that **conditionally displays contact info** based on the `is_public` flags from the API.
9.  **Build Auth Pages (Quasar/Vue3):** Login & Registration.
10. **Implement Provider Registration Flow (Laravel API):** The endpoint must now:
    *   Create the `user` and `provider_profile`.
    *   Create the `location` with the provided address and the user's chosen `is_public` flags.
    *   Trigger the **Standardization -> Geocoding -> Save** process.
    *   **Trigger the Billing Flow.**

**Phase 4: Monetization, Privacy, & Billing (PayPal)**
11. **Build Contact Form System:**
    *   Create a `messages` table (`from_user_id`, `to_provider_profile_id`, `subject`, `body`).
    *   Create an API endpoint `POST /api/contact-provider/{id}` that:
        *   Uses ReCAPTCHA v3.
        *   Stores the message.
        *   Emails it to the provider's `contact_form_email` (which could be their real email or a proxy alias you generate).
12. **Integrate PayPal:** Use the **PayPal Subscriptions API** for recurring payments.
    *   Create a service class for PayPal API calls.
13. **Implement Billing Endpoints:**
    *   `POST /api/provider/create-subscription`: Creates a PayPal subscription and returns the approval link.
    *   `POST /api/paypal/webhook`: **The most important endpoint.** Securely processes events like `BILLING.SUBSCRIPTION.ACTIVATED` and updates the provider's `subscription_status` to `'active'`. This is what grants them premium features.
    *   `GET /api/provider/subscription`: Checks status.

**Phase 5: Admin & Moderation**
14. **Build Basic Admin Panel:** A simple Laravel Nova/Filament installation or a set of protected API routes and a Quasar page. Must include:
    *   **Moderation:** Lists of providers and reviews with actions to `Edit`, `Delete`, or `Toggle Verification`.
    *   **User Management:** Ability to view users and delete accounts (complying with privacy policy).
    *   **Financial Overview:** See active subscriptions and revenue.
15. **Email Notifications:** Set up transactional emails for new contact form messages, new reviews, etc.
16. **Deployment:** Configure environment variables (Google API, PayPal, ReCAPTCHA, DB).

