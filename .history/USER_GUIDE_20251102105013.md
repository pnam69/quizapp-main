# 🎓 School Web Application - User Guide

## 📖 Complete Documentation Index

This school management system includes comprehensive documentation:

1. **README.md** (original) - Project overview and installation
2. **USER_GUIDE.md** (this file) - How to use the application
3. **DEPLOYMENT_CHECKLIST.md** - Production deployment guide
4. **PROGRESS_UPDATE.md** - Recent enhancements
5. **PROJECT_COMPLETE.md** - Project summary
6. **QUICK_REFERENCE.md** - Quick reference guide

## 🚀 Getting Started

### First Time Login

**Admin/Teacher Access:**
- URL: `http://your-domain.com/admin`
- Default credentials: Contact your system administrator

**Student Access:**
- URL: `http://your-domain.com/member`
- Students must be created by admin

## 👨‍🏫 Teacher Guide

### Creating Homework

1. Navigate to **Homework** → **Create**
2. Fill in the assignment details:
   - **Title**: Assignment name
   - **Description**: Detailed instructions
   - **Instructions**: Additional guidance for students
   - **Due Date**: Deadline (date and time)
   - **Max Points**: Maximum score
   - **Certification/Section**: Target student group
   - **Classroom**: Specific class (optional)
3. **Settings**:
   - ✅ **Published**: Make visible to students
   - ✅ **Allow Late Submission**: Accept submissions after deadline
4. **Upload Files** (optional):
   - PDFs, Word documents, PowerPoint, Excel, Images
   - Max 50MB per file
5. Click **Create**

### Grading Homework

1. Go to **Homework** → Select assignment
2. Click **Submissions** tab
3. For each submission:
   - Download student files (if any)
   - Read submission text
   - Enter **Score** (out of max points)
   - Write **Feedback** (optional but recommended)
   - Save

Students will see their grades immediately!

### Creating Quizzes

1. Navigate to **Quizzes** → **Create**
2. Add questions with multiple-choice options
3. Mark correct answers
4. Assign to sections/certifications
5. Publish when ready

### Viewing Analytics

Your dashboard shows:
- **Homework Stats**: Total, Active, Overdue, Pending Grading
- **Quiz Stats**: Active Tests, Attempts, Average Score, Pass Rate
- **Activity Chart**: 7-day trend of student engagement

### Uploading Study Materials

1. Go to **Hub** → **Create**
2. Set title and description
3. Choose category (subject)
4. Upload files (PDFs, videos, documents)
5. Mark as **Active**
6. Save

## 👨‍🎓 Student Guide

### Your Dashboard

When you log in, you'll see:
- **Quick Stats**: Quizzes, Completed, Pending Homework, Average Score
- **Pending Homework**: Next 2 assignments with due dates
- **Next Quiz**: One-click start button
- **Overdue Alerts**: Late assignments you can still submit
- **Recent Results**: Your last 3 quiz scores
- **Recent Grades**: Your last 3 graded homework

### Submitting Homework

1. Click **My Homework** from sidebar
2. Find the assignment
3. Click **Submit**
4. Enter your answer in the text box
5. Upload files (optional):
   - Max 5 files
   - 10MB per file
   - PDFs, Word, Excel, Images, Text only
6. Click **Submit Homework**

**⚠️ Important:**
- You can resubmit before grading
- Late submissions are marked automatically
- Once graded, you cannot resubmit

### Taking Quizzes

1. Dashboard → Click **Start Quiz** button
   OR Navigate to **Tests** → Select quiz
2. Read each question carefully
3. Click on your answer choice
   - Selected answers turn **blue**
   - After submission, correct answers show **green ✓**
   - Wrong answers show **red ✗**
4. Click **Submit** when done

### Viewing Grades

**Homework Grades:**
- Go to **My Homework** → **Submitted** tab
- Green badge = Good score (≥70%)
- Yellow badge = Needs improvement (50-69%)
- Red badge = Needs work (<50%)

**Quiz Results:**
- Navigate to **My Results**
- View all your quiz attempts
- See scores and completion dates

### Accessing Study Materials

1. Navigate to **Learning Hub**
2. Browse materials by category
3. Click to download

## 🔐 Security Features

### For Students
- ✅ Can only see your own work
- ✅ Cannot view other students' submissions
- ✅ Cannot modify graded homework
- ✅ Rate limited (10 submissions per hour)

### For Teachers
- ✅ Can only manage your own homework
- ✅ Can only grade your assignments
- ✅ Cannot modify other teachers' work
- ✅ Secure file uploads

### File Upload Safety
- ❌ No executable files (.exe, .bat, .sh)
- ✅ Only safe document types allowed
- ✅ Files scanned for size limits
- ✅ Filenames automatically sanitized

## 📱 Mobile Usage

The app works great on phones and tablets!

**Tips for Mobile:**
- All features work on mobile browsers
- Buttons are touch-friendly (44px minimum)
- Forms adapt to screen size
- File uploads work from camera/gallery
- Works in portrait and landscape

**Recommended Browsers:**
- Chrome (Android)
- Safari (iOS)
- Firefox
- Edge

## 🎯 Best Practices

### For Teachers

**Homework:**
- ✅ Set clear instructions
- ✅ Upload reference materials
- ✅ Set reasonable due dates
- ✅ Provide detailed feedback when grading
- ✅ Grade submissions promptly

**Quizzes:**
- ✅ Test questions before publishing
- ✅ Provide adequate time limits
- ✅ Review results for difficult questions

**Communication:**
- ✅ Check dashboard daily
- ✅ Monitor submission rates
- ✅ Address overdue assignments

### For Students

**Homework:**
- ✅ Start early (don't wait until last minute)
- ✅ Read instructions carefully
- ✅ Upload required files
- ✅ Proofread before submitting
- ✅ Ask teachers if unclear

**Quizzes:**
- ✅ Study using materials in Learning Hub
- ✅ Read each question carefully
- ✅ Don't rush
- ✅ Review your results

**Organization:**
- ✅ Check dashboard daily
- ✅ Note upcoming due dates
- ✅ Keep track of your average score
- ✅ Review feedback from teachers

## ❓ Frequently Asked Questions

### General

**Q: I forgot my password. What do I do?**
A: Click "Forgot Password" on the login page. You'll receive an email with reset instructions.

**Q: Can I use my phone to submit homework?**
A: Yes! The app is fully mobile-responsive. You can submit homework and take quizzes on any device.

**Q: What file types can I upload?**
A: Students: PDF, Word, Excel, Images, Text (10MB max, 5 files)
   Teachers: PDFs, Word, Excel, PowerPoint, Images (50MB max)

### For Students

**Q: Can I resubmit homework after submitting?**
A: Yes, but only before it's graded. Once graded, submissions are locked.

**Q: What happens if I submit late?**
A: If the teacher allows late submissions, you can still submit. It will be marked as "late" but can still be graded.

**Q: How do I know if my homework was graded?**
A: Check your dashboard's "Recent Graded Homework" section or go to My Homework → Submitted tab.

**Q: Can I see other students' answers?**
A: No. You can only see your own work for security and privacy.

**Q: Why can't I submit homework?**
A: Possible reasons:
- Already graded (cannot resubmit)
- Rate limit reached (10 submissions/hour)
- Assignment not published yet
- You're not in the assigned classroom

### For Teachers

**Q: Can I modify homework after students submit?**
A: Yes, but changes won't affect existing submissions. Be careful with due dates.

**Q: How do I know if students submitted?**
A: Check the Submissions tab on the homework. Dashboard also shows pending grading count.

**Q: Can I see other teachers' homework?**
A: No (unless you're an admin). Teachers can only manage their own homework.

**Q: What if I accidentally deleted homework?**
A: Contact your administrator. They may be able to restore it.

## 🛠️ Troubleshooting

### Can't Log In
1. Check your username/email is correct
2. Try password reset
3. Clear browser cache
4. Contact administrator

### File Upload Fails
1. Check file size (within limits?)
2. Check file type (allowed format?)
3. Try a different browser
4. Check internet connection

### Page Not Loading
1. Refresh the page (F5)
2. Clear browser cache
3. Try a different browser
4. Check internet connection

### Quiz Not Showing
1. Check if it's published
2. Verify you're in the right section/certification
3. Ask your teacher

### Can't Submit Homework
1. Check if it's published
2. Check if you're in the assigned classroom
3. Verify you haven't hit rate limit
4. Check if already graded

## 📞 Getting Help

### For Students
1. Check this guide first
2. Ask your teacher
3. Contact school IT support

### For Teachers
1. Check DEPLOYMENT_CHECKLIST.md
2. Check QUICK_REFERENCE.md
3. Contact system administrator
4. Check Laravel logs (`storage/logs`)

## 🎓 Tips for Success

### Students
- 📅 Check dashboard daily
- ⏰ Set reminders for due dates
- 📚 Use study materials in Learning Hub
- ✍️ Read teacher feedback carefully
- 🎯 Aim for consistent improvement

### Teachers
- 📊 Monitor dashboard analytics
- 💬 Provide constructive feedback
- 📝 Keep instructions clear
- ⏱️ Grade promptly
- 📈 Track class performance trends

---

**Need more help?** Check the other documentation files or contact your system administrator.

**Version**: 1.0  
**Last Updated**: November 2, 2025
