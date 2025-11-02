# Quick Reference Guide - School Web Application

## Access the Application

### Teacher/Admin Access
- URL: `http://your-domain.com/admin`
- Default credentials: Check your database seeder
- Features:
  - Dashboard with analytics widgets
  - Homework management
  - Quiz creation and management
  - Student performance tracking
  - Study materials upload
  - User management

### Student Access
- URL: `http://your-domain.com/member`
- Students need to be registered by admin
- Features:
  - Personal dashboard with stats
  - Quiz taking interface
  - Homework submission
  - Study materials access
  - Progress tracking

## Key Features Overview

### 📊 Dashboards

#### Teacher Dashboard Widgets
1. **Homework Stats** - Total, Active, Overdue, Pending Grading, Submission Rate
2. **Quiz Stats** - Active Tests, Attempts, Average Score, Pass Rate
3. **Activity Chart** - 7-day trend of submissions and quiz attempts

#### Student Dashboard Sections
1. **Quick Stats** - Quizzes, Completed, Pending Homework, Average Score
2. **Recent Quiz Results** - Last 3 quizzes with color-coded scores
3. **Recent Graded Homework** - Last 3 grades with feedback
4. **Next Quiz** - Quick start button for next available quiz
5. **Recent Study Materials** - 5 newest materials from hub

### 📝 Homework Management

#### For Teachers
- **Create**: Navigate to Homework → Create New
  - Set title, description, instructions
  - Upload attachments (PDFs, images, documents)
  - Set due date and max points
  - Assign to specific classroom or section
  - Choose to allow late submissions
  
- **Grade Submissions**: Click on homework → Submissions tab
  - View student submission files
  - Enter score (out of max points)
  - Provide written feedback
  - Submissions automatically marked as graded

#### For Students
- **View Assignments**: Navigate to My Homework
- **Submit Work**: 
  - Click "Submit" on pending homework
  - Upload your files
  - Add optional notes
  - Late submissions flagged automatically
  
- **Check Grades**: View graded homework with scores and feedback

### 🎯 Quiz System

#### For Teachers
- **Create Quiz**: Quizzes → Create New
  - Add questions with multiple options
  - Set correct answers
  - Assign to sections/certifications
  
- **Track Performance**: View stats widget on dashboard

#### For Students
- **Take Quiz**: Click "Start Quiz" from dashboard or Tests page
- **Visual Feedback**: 
  - Selected answers turn blue
  - Correct answers show green checkmark
  - Wrong answers show red X
  - Submit when ready

### 📚 Study Materials (Learning Hub)

#### For Teachers
- **Upload Materials**: Hub → Create New
  - Support for PDFs, Word docs, PowerPoint, images
  - Categorize by subject
  - Set visibility (active/inactive)
  
#### For Students
- **Access Materials**: Navigate to Learning Hub
- **Download**: Click on any material to download

## Important File Locations

### Models
- `app/Models/Homework.php` - Homework assignments
- `app/Models/HomeworkSubmission.php` - Student submissions
- `app/Models/Quiz.php` - Quiz data
- `app/Models/Test.php` - Test instances
- `app/Models/Hub.php` - Study materials

### Resources (Admin)
- `app/Filament/Resources/HomeworkResource.php`
- `app/Filament/Resources/QuizResource.php`
- `app/Filament/Resources/HubResource.php`

### Pages (Student)
- `app/Filament/Member/Pages/MyHomework.php`
- `app/Filament/Member/Pages/TakeTest.blade.php`
- `app/Filament/Member/Pages/Dashboard.php`

### Widgets
- `app/Filament/Widgets/HomeworkStatsOverview.php`
- `app/Filament/Widgets/QuizStatsOverview.php`
- `app/Filament/Widgets/StudentActivityChart.php`

## Common Tasks

### Add a New Student
1. Login as admin
2. Navigate to Users
3. Click Create
4. Fill in details (name, email, password)
5. Assign to classrooms/sections

### Create and Assign Homework
1. Login as admin/teacher
2. Navigate to Homework → Create
3. Fill in assignment details
4. Upload any reference materials
5. Set due date
6. Select classroom (or leave blank for all)
7. Click Create

### Grade Homework
1. Navigate to Homework
2. Click on the assignment
3. Go to "Submissions" tab
4. For each submission:
   - Download student files if needed
   - Enter score
   - Write feedback
   - Save

### Upload Study Material
1. Navigate to Hub → Create
2. Set title and description
3. Choose category
4. Upload file(s)
5. Set as active
6. Save

## Database Migrations

If you need to reset or migrate the database:

```powershell
# Reset database and migrate
php artisan migrate:fresh

# Seed with sample data (if seeder exists)
php artisan db:seed

# Or do both at once
php artisan migrate:fresh --seed
```

## Clear Cache After Changes

```powershell
# Clear all caches
php artisan optimize:clear

# Or individually
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## File Storage

Uploaded files are stored in:
- `storage/app/public/homework_attachments/` - Teacher homework files
- `storage/app/public/homework_submissions/` - Student submission files
- `storage/app/public/study_materials/` - Learning hub materials

Make sure the storage is linked:
```powershell
php artisan storage:link
```

## Troubleshooting

### "Class not found" errors
```powershell
composer dump-autoload
php artisan optimize:clear
```

### Widgets not showing
1. Check `app/Providers/Filament/AdminPanelProvider.php`
2. Ensure widgets are registered in the `widgets()` array
3. Clear cache

### Permissions issues
```powershell
# Windows (in PowerShell as Administrator)
icacls "storage" /grant Users:F /T
icacls "bootstrap/cache" /grant Users:F /T
```

### File upload not working
1. Check `config/filesystems.php` has 'public' disk configured
2. Ensure `storage:link` has been run
3. Check folder permissions on `storage/app/public`

## Color Coding Reference

### Scores
- 🟢 **Green** (≥70%): Passing grade, good performance
- 🟡 **Yellow** (50-69%): Needs improvement
- 🔴 **Red** (<50%): Failing grade, needs attention

### Homework Status
- 🔵 **Blue** (Not Submitted): Pending student action
- 🟡 **Yellow** (Submitted/Late): Awaiting teacher grading
- 🟢 **Green** (Graded): Complete with feedback
- 🔴 **Red** (Overdue): Past due date

## Security Notes

1. **Passwords**: Always use strong passwords
2. **File Uploads**: System validates file types and sizes
3. **Authentication**: Separate guards for admin and students
4. **Authorization**: Teachers can only grade their own assignments

## Getting Help

- Check error logs: `storage/logs/laravel.log`
- View database structure: Use phpMyAdmin or database client
- Laravel docs: https://laravel.com/docs
- Filament docs: https://filamentphp.com/docs

---

**Last Updated**: January 2025
**Version**: 1.0
