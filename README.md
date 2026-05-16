# InterviewPrep

A personal knowledge tracker for developers to structure their technical knowledge and generate mock interview questions using the Groq AI API.

## Features

- **Domain Management** — Organize topics (PHP, Laravel, MySQL, etc.) with custom colors and descriptions
- **Concept Tracking** — Create, edit, and track your understanding of technical concepts with difficulty levels and mastery status
- **AI Question Generation** — Generate 5 unique interview questions per set using Groq AI, with automatic deduplication
- **Practice Mode** — Answer questions and get AI-powered feedback with ratings and model answers
- **AI Description Improvement** — Get concise AI suggestions for domain descriptions and concept explanations with accept/reject flow
- **Global Search** — Search across domains, concepts, and questions with type filtering
- **Soft Deletes** — Archive and restore domains and concepts with full trash management
- **Multi-tenant Security** — Users can only access their own data

## Tech Stack

- **Backend:** Laravel 13, PHP 8.4+
- **Database:** MySQL
- **Frontend:** Blade Templates, TailwindCSS, Alpine.js
- **Auth:** Laravel Breeze
- **AI Integration:** Groq API (via Laravel HTTP client — no external packages)

## Installation

1. Clone the repository:
```bash
git clone <repo-url>
cd InterviewPrep
```

2. Install dependencies:
```bash
composer install
npm install && npm run build
```

3. Set up your environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_DATABASE=interviewprep
DB_USERNAME=root
DB_PASSWORD=
```

5. Add your Groq API key in `.env`:
```
GROQ_API_KEY=your_api_key_here
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

## Usage

1. **Register** a new account or log in
2. **Create a Domain** — e.g., "PHP", "Laravel", "JavaScript"
3. **Add Concepts** — Write your own explanations for each topic
4. **Generate Questions** — Click "Generate New Set" to create 5 AI-powered interview questions
5. **Practice** — Answer questions and submit for AI evaluation with ratings and feedback
6. **Track Progress** — Monitor your mastery status (To Review → In Progress → Mastered)

## AI Features

- **Question Generation:** Generates exactly 5 questions per set, automatically avoiding duplicates from previous sets
- **Answer Evaluation:** Rates your answers 1-5 with constructive feedback and model answers
- **Description Improvement:** Suggests concise, improved descriptions for domains and concepts (1-2 sentences)

## Project Structure

```
app/
├── Casts/          # Custom enum caster
├── Enums/          # Difficulty and Status enums
├── Http/
│   ├── Controllers/   # Thin controllers
│   └── Requests/      # Form request validation
├── Models/         # Eloquent models with relationships
├── Policies/       # Authorization policies
└── Services/
    ├── GroqService     # API communication layer
    └── PromptBuilder   # Prompt construction with dedup logic
```

## License

MIT
