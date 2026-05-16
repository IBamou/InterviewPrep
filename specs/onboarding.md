# User Onboarding

## 🎯 Feature Goal
Collect user background information during first login to personalize AI-generated interview questions.

---

## ✅ What I want

### US1 - Progressive 5-step onboarding flow
1. **Status**: Student or Professional
2. **Specialization**: Backend, Frontend, Full Stack, DevOps, Data, or General
3. **Experience**: No experience, Less than 1 year, 1-3 years, 3-5 years, +5 years, 10+ years
4. **Tech Stack**: Select from predefined list (PHP, Laravel, JavaScript, React, etc.)
5. **Interview Goal**: Land first job, Career switch, Get promoted, Stay sharp, Job hunting

### US2 - Skip option
- Users can skip onboarding and fill it out later via profile settings
- Skipping sets `onboarding_completed = true`

### US3 - Onboarding enforcement
- New users (`onboarding_completed = false`) are redirected to `/onboarding`
- Middleware blocks access to all protected routes until onboarding is complete

### US4 - Profile data stored in users table
- All fields stored directly in `users` table (no separate profiles table)
- Fields: `status`, `specialization`, `experience_years`, `tech_stack` (JSON), `interview_goal`, `onboarding_completed` (boolean)

---

## ❌ What I DON'T want
- No separate profiles table
- No mandatory onboarding (skip always available)
- No auto-generation of study materials based on profile
- No color picker for tech stack (simple tag selection)

---

## 🧱 Technical Requirements

### Enums
- `UserStatus`: student, professional
- `Specialization`: backend, frontend, fullstack, devops, data, student
- `ExperienceLevel`: 0, 0-1, 1-3, 3-5, 5-10, 10+
- `InterviewGoal`: first_job, career_switch, promotion, stay_sharp, job_hunting

### Middleware
- `EnsureOnboardingCompleted` redirects to `/onboarding` if `onboarding_completed = false`
- Applied to dashboard and all protected routes
- Onboarding routes themselves are excluded from the redirect

### Frontend
- Alpine.js for step management and form state
- TailwindCSS for styling
- Progress bar showing step completion
- Keyboard navigation (arrow keys)

---

## 🗃️ Database Changes

### Migration: add_profile_fields_to_users_table
Adds to `users` table:
- `status` (string, default: 'student')
- `specialization` (string, nullable)
- `experience_years` (string, nullable)
- `tech_stack` (json, nullable)
- `interview_goal` (string, nullable)
- `onboarding_completed` (boolean, default: false)

---

## 🔄 Routes

- `GET /onboarding` → OnboardingController@index
- `POST /onboarding` → OnboardingController@store
- `GET /onboarding/skip` → OnboardingController@skip

---

## 🧠 Business Rules
- Profile data is used by `PromptBuilder` to inject user context into AI prompts
- Users can edit profile data later via `/profile` settings page
- Editing profile data sets `onboarding_completed = true` if not already set

---

## 🖥️ Views
- `onboarding/index.blade.php` → Full-page onboarding flow
- `components/onboarding/step-container.blade.php` → Wrapper with transitions
- `components/onboarding/step-status.blade.php` → Step 1
- `components/onboarding/step-specialization.blade.php` → Step 2
- `components/onboarding/step-experience.blade.php` → Step 3
- `components/onboarding/step-techstack.blade.php` → Step 4
- `components/onboarding/step-goal.blade.php` → Step 5
