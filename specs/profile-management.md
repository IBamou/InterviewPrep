# Profile Management

## 🎯 Feature Goal
Allow users to edit their onboarding data and account settings after initial setup.

---

## ✅ What I want

### US1 - Edit interview profile
- Status (Student/Professional)
- Specialization (Backend, Frontend, Full Stack, DevOps, Data)
- Experience years
- Tech Stack (add/remove technologies)
- Interview Goal

### US2 - Edit account details
- Name
- Email
- Password

### US3 - Delete account
- Enter password to confirm
- Cascading delete of all user data

### US4 - Profile editing auto-completes onboarding
- If user skipped onboarding, editing profile sets `onboarding_completed = true`

---

## ❌ What I DON'T want
- No separate profile page for onboarding data (integrated into existing profile settings)
- No profile pictures or avatars
- No social links or bio

---

## 🧱 Technical Requirements

### Controller
- `ProfileController` extends Breeze's default controller
- `update()` method handles both account and profile data

### Validation
- `ProfileUpdateRequest` validates all profile fields using `Rule::enum()`
- Email uniqueness check ignores current user
- `tech_stack` validated as array of strings

### Frontend
- Alpine.js for tech stack tag management (add/remove)
- Hidden inputs for array data submission
- Consistent with existing design system

---

## 🔄 Routes

- `GET /profile` → ProfileController@edit
- `PATCH /profile` → ProfileController@update
- `DELETE /profile` → ProfileController@destroy

---

## 🧠 Business Rules
- Profile data is used by AI for personalized question generation
- All profile fields are optional (user can leave them blank)
- Setting any profile field marks onboarding as completed

---

## 🖥️ Views
- `profile/edit.blade.php` → Integrated form with account, interview profile, password, and delete sections
