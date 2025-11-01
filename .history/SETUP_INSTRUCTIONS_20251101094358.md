# My Quizzes Feature - Setup Instructions

## Overview
This feature allows students to create their own custom quizzes and take them for practice.

## Changes Made

### 1. Model Updates
- **MyQuizzes Model** (`app/Models/MyQuizzes.php`)
  - Fixed to use the correct `my_quizzes` table
  - Added support for storing questions as JSON
  - Added automatic UUID generation for quiz links

### 2. Pages Created/Updated

#### CreateMyQuiz Page (`app/Filament/Member/Pages/CreateMyQuiz.php`)
- **Features:**
  - Create custom quizzes with title and description
  - Add multiple questions with multiple-choice options
  - Mark correct answers for each question
  - Validation to ensure each question has at least one correct answer
  - Drag-and-drop reordering of questions and options
  - Success notifications and automatic redirect

#### MyCustomQuizzes Page (`app/Filament/Member/Pages/MyCustomQuizzes.php`) - **NEW**
- **Features:**
  - View all quizzes created by the student
  - Take quizzes with question-by-question navigation
  - Progress bar showing quiz completion
  - Submit quiz and see results
  - Review answers with correct/incorrect highlighting
  - Retake quizzes
  - Delete quizzes
  - Score calculation and display

### 3. Views

#### Create My Quiz View (`resources/views/filament/member/pages/create-my-quiz.blade.php`)
- Clean, user-friendly interface for quiz creation
- Tips section for creating better quizzes
- Cancel and Submit buttons

#### My Quizzes View (`resources/views/filament/member/pages/my-custom-quizzes.blade.php`) - **NEW**
- Three main sections:
  1. **Quiz List:** Shows all created quizzes with metadata
  2. **Quiz Taking:** Interactive quiz interface with navigation
  3. **Results:** Score display with detailed answer review

## Setup Instructions

### Step 1: Run Migrations
Make sure the database is up to date:

```bash
php artisan migrate
```

This will create the `my_quizzes` table if it doesn't exist.

### Step 2: Clear Cache (Optional)
If you encounter any issues, clear the application cache:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Step 3: Access the Features

1. **Create a Quiz:**
   - Navigate to "Create My Quiz" in the member panel
   - Fill in quiz title and description
   - Add questions and options
   - Mark correct answers
   - Click "Create Quiz"

2. **View and Take Quizzes:**
   - Navigate to "My Quizzes" in the member panel
   - See all your created quizzes
   - Click "Take Quiz" to start
   - Answer questions and navigate with Previous/Next
   - Submit to see results

3. **Review Results:**
   - See your score percentage
   - Review all questions with correct/incorrect indicators
   - See which answers were correct
   - Retake the quiz or go back to quiz list

## Features Summary

### Create My Quiz
- ✅ Add quiz title and description
- ✅ Create multiple questions
- ✅ Add 2-6 options per question
- ✅ Mark correct answers
- ✅ Reorder questions and options
- ✅ Validation for required fields
- ✅ Automatic save on submit

### My Quizzes
- ✅ View all created quizzes
- ✅ See quiz metadata (question count, creation date)
- ✅ Take quizzes with step-by-step navigation
- ✅ Progress tracking
- ✅ Answer validation before submit
- ✅ Score calculation
- ✅ Detailed results with answer review
- ✅ Retake functionality
- ✅ Delete quizzes

## Database Structure

The `my_quizzes` table stores:
- `id`: Primary key
- `user_id`: Foreign key to users table
- `title`: Quiz title
- `description`: Optional quiz description
- `questions`: JSON field storing all questions and options
- `public`: Boolean for future sharing functionality
- `link_token`: Unique UUID for quiz sharing
- `created_at` & `updated_at`: Timestamps

### Questions JSON Structure:
```json
[
  {
    "question_text": "What is the capital of France?",
    "options": [
      {"option_text": "Paris", "is_correct": true},
      {"option_text": "London", "is_correct": false},
      {"option_text": "Berlin", "is_correct": false},
      {"option_text": "Madrid", "is_correct": false}
    ]
  }
]
```

## Navigation

The feature adds two navigation items to the member panel:
1. **Create My Quiz** (with plus icon) - Navigation sort: 2
2. **My Quizzes** (with academic cap icon) - Navigation sort: 3

## Security

- Users can only view and manage their own quizzes
- Authentication required for all actions
- Quiz deletion requires confirmation
- User ownership validation on delete operations

## Future Enhancements (Optional)

Potential features that could be added:
- Share quizzes with other students via link_token
- Quiz categories/tags
- Time limits per quiz
- Quiz statistics and analytics
- Export quiz results
- Duplicate existing quizzes
- Public quiz library

## Troubleshooting

**Issue: "Quiz Not Found" error**
- Make sure migrations have been run
- Check that you're logged in as a member

**Issue: Form not submitting**
- Ensure all required fields are filled
- Check that each question has at least one correct answer
- Check browser console for JavaScript errors

**Issue: Page not showing in navigation**
- Clear cache: `php artisan cache:clear`
- Check that user has member guard authentication

**Issue: Database errors**
- Run migrations: `php artisan migrate`
- Check database connection in `.env` file
