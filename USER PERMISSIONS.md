### The Four Tiers of MADB User Permissions

#### Tier 1: Unregistered Users (Guests)
*   **Permissions:** 
    *   Search for providers.
    *   View public provider profiles (subject to the provider's visibility settings).
    *   View reviews.
*   **Technical Implementation:** 
    *   These actions correspond to your **public API routes** (e.g., `GET /api/providers`, `GET /api/providers/{id}`).
    *   These routes have no authentication middleware attached to them.

#### Tier 2: Registered Users (Seekers)
*   **Permissions:** 
    *   All permissions of an Unregistered User.
    *   Create, edit, and delete their own reviews.
    *   Possibly update their own user profile (name, email).
*   **Technical Implementation:** 
    *   Their `users.type` field is set to `'seek'`.
    *   They authenticate via Laravel Sanctum, receiving an API token.
    *   **Authorization Checks:** 
        *   A general `auth:sanctum` middleware on API routes for reviews.
        *   Within review controllers, a check to ensure the authenticated user's ID matches the `user_id` of the review they are trying to modify (or that they are the author of a new review). This is often done with Laravel Policies.

#### Tier 3: Registered Providers
*   **Permissions:** 
    *   All permissions of a Registered User (they can leave reviews on *other* schools).
    *   Claim and manage their provider profile (`provider_profiles`).
    *   Manage their business locations (`locations`).
    *   Manage their subscription and billing.
    *   Respond to reviews (via a future feature like a public comment).
    *   Receive messages via the proxy contact form.
*   **Technical Implementation:** 
    *   Their `users.type` field is set to `'provider'`.
    *   They have an associated `provider_profiles` record.
    *   **Authorization Checks:** 
        *   Uses the `auth:sanctum` middleware.
        *   Critical to use **Laravel Policies** for provider-specific routes. For example, a `ProviderProfilePolicy` would ensure that a user can only update the `provider_profiles` record where `provider_profiles.user_id` matches their own `id`. This prevents one provider from editing another's profile.

#### Tier 4: Administrators
*   **Permissions:** 
    *   **All permissions** across the platform.
    *   Access the admin panel.
    *   Manually verify providers or reviews.
    *   Edit or delete any content (e.g., remove inappropriate reviews, fix incorrect profiles).
    *   View basic system metrics.
    *   Manage user accounts.
*   **Technical Implementation:** 
    *   The simplest way is to add an `is_admin` (BOOLEAN) flag to the `users` table. This is more flexible than using the `type` field.
    *   **Authorization Checks:** 
        *   You would create a middleware like `is_admin` that checks `if (Auth::user()->is_admin) { ... }`.
        *   This middleware would be applied to all your admin-specific API routes (e.g., `GET /api/admin/users`).
        *   In Policies, you can add a clause to automatically grant all access if `$user->is_admin` is true.

```php
// Example ProviderProfilePolicy.php
public function update(User $user, ProviderProfile $providerProfile)
{
    // Admins can do anything
    if ($user->is_admin) {
        return true;
    }
    // A provider can only update their own profile
    return $user->id === $providerProfile->user_id;
}
```

---

### How to Implement This in Your Code

1.  **Database:** Add the `is_admin` column to your `users` table.
2.  **Seeders:** Make sure your seeder sets your user account to `is_admin = true`.
3.  **Middleware:** Create an `IsAdmin` middleware and register it in your `Kernel.php`.
4.  **Policies:** Generate Policies for your models (e.g., `ReviewPolicy`, `ProviderProfilePolicy`) and implement the logic as shown above, always checking for admin status first.
5.  **Routes:** Apply the correct middleware to your route groups:
    *   `->middleware('auth:sanctum')` for all logged-in actions.
    *   `->middleware('is_admin')` for admin-only routes.
