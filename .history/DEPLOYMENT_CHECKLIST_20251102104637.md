# Deployment Checklist - School Web Application

## 🔐 Security Checklist

### Authentication & Authorization
- [x] Admin/Teacher/Student role separation implemented
- [x] Separate authentication guards (admin/member)
- [x] Password hashing with bcrypt
- [x] CSRF protection enabled
- [x] XSS protection via Blade templating
- [x] SQL injection prevention (Eloquent ORM)
- [x] Authorization policies for Homework & HomeworkSubmission
- [ ] Review all user permissions and roles
- [ ] Test role-based access control thoroughly
- [ ] Verify email verification is working
- [ ] Enable 2FA for admin accounts (optional but recommended)

### File Uploads
- [x] File type validation (MIME types)
- [x] File size limits (10MB students, 50MB teachers)
- [x] Maximum file count limits (5 files for students)
- [x] Filename sanitization (preserveFilenames = false)
- [x] Separate storage directories (homework_attachments, homework_submissions)
- [ ] Verify storage directory permissions (755 recommended)
- [ ] Test virus scanning integration (optional but recommended)
- [ ] Ensure storage is properly linked (`php artisan storage:link`)
- [ ] Configure backup for uploaded files

### Input Validation & Sanitization
- [x] HTML sanitization on text submissions (strip_tags)
- [x] Max length limits on text inputs (5000 chars)
- [x] Rate limiting on submissions (10 per hour)
- [x] File upload validation
- [ ] Review all form inputs for SQL injection
- [ ] Test XSS prevention on all text fields
- [ ] Verify CSRF tokens on all forms

### Rate Limiting
- [x] Homework submission rate limiting (10/hour)
- [ ] Add rate limiting to login attempts
- [ ] Add rate limiting to registration
- [ ] Add rate limiting to password reset
- [ ] Configure API rate limits (if applicable)

## 🗄️ Database Checklist

### Migrations
- [ ] Run all migrations: `php artisan migrate --force`
- [ ] Verify all tables created successfully
- [ ] Check foreign key constraints
- [ ] Verify indexes are in place
- [ ] Run database backup before deployment

### Seeding
- [ ] Seed initial admin user
- [ ] Create default roles (if using Spatie Permission)
- [ ] Seed sample data (optional, for demo)
- [ ] Verify seeders work: `php artisan db:seed`

### Database Security
- [ ] Use strong database password
- [ ] Limit database user permissions
- [ ] Enable database SSL connection (if available)
- [ ] Regular database backups configured
- [ ] Keep database credentials secure (not in version control)

## ⚙️ Configuration Checklist

### Environment Variables (.env)
```bash
# REQUIRED: Update these values
APP_NAME="School Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-school-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=strong_password_here

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-school-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# File Storage
FILESYSTEM_DISK=public

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Queue (recommended for production)
QUEUE_CONNECTION=database
```

- [ ] Copy `.env.example` to `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY`: `php artisan key:generate`
- [ ] Configure mail settings for notifications
- [ ] Set correct `APP_URL`
- [ ] Configure database credentials
- [ ] Set strong database password
- [ ] Review all environment variables

### Laravel Configuration
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan optimize`
- [ ] Verify all caches are working

### File Permissions
```bash
# Set proper permissions (Linux/Unix)
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows: Ensure IIS/Apache user has write access
# Right-click folders → Properties → Security → Edit
```
- [ ] Storage directory writable (755)
- [ ] Bootstrap/cache writable (755)
- [ ] Public directory readable (755)
- [ ] Uploaded files directory writable

## 🚀 Performance Optimization

### Caching
- [ ] Enable OpCache (PHP)
- [ ] Configure Redis/Memcached (optional but recommended)
- [ ] Enable Laravel caching: `php artisan optimize`
- [ ] Test cache clearing: `php artisan optimize:clear`

### Database Optimization
- [ ] Add indexes to frequently queried columns
- [ ] Enable query caching (MySQL)
- [ ] Monitor slow queries
- [ ] Configure connection pooling

### Assets
- [ ] Build production assets: `npm run build`
- [ ] Minify CSS/JS files
- [ ] Enable Gzip compression (server-level)
- [ ] Configure CDN for static assets (optional)
- [ ] Optimize images (compress, webp format)

## 🌐 Server Configuration

### Web Server (Apache/Nginx)
- [ ] Configure virtual host/server block
- [ ] Point document root to `public/` directory
- [ ] Enable HTTPS/SSL certificate
- [ ] Configure proper redirects (www, https)
- [ ] Set up security headers
- [ ] Configure CORS if needed

### PHP Configuration
```ini
; Recommended php.ini settings
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
memory_limit = 256M
opcache.enable = 1
opcache.memory_consumption = 128
```
- [ ] PHP version 8.2+ installed
- [ ] Required extensions enabled (see below)
- [ ] Increase upload limits for file handling
- [ ] Enable OpCache
- [ ] Disable dangerous functions

### Required PHP Extensions
- [ ] BCMath
- [ ] Ctype
- [ ] Fileinfo
- [ ] JSON
- [ ] Mbstring
- [ ] OpenSSL
- [ ] PDO
- [ ] Tokenizer
- [ ] XML
- [ ] GD or Imagick (for image processing)
- [ ] Zip

### SSL/HTTPS
- [ ] Install SSL certificate (Let's Encrypt recommended)
- [ ] Force HTTPS in `.env`: `APP_URL=https://...`
- [ ] Update `TrustProxies` middleware if behind proxy
- [ ] Test SSL configuration (SSL Labs)

## 🧪 Testing Checklist

### Functional Testing
- [ ] Test admin login
- [ ] Test student login
- [ ] Test teacher login (if separate)
- [ ] Create homework assignment (teacher)
- [ ] Submit homework (student)
- [ ] Grade homework (teacher)
- [ ] Create quiz/test
- [ ] Take quiz (student)
- [ ] Upload study materials
- [ ] Download study materials
- [ ] View dashboard widgets
- [ ] Test notifications
- [ ] Test file uploads (all file types)
- [ ] Test file download

### Security Testing
- [ ] Try SQL injection on forms
- [ ] Try XSS attacks on text inputs
- [ ] Test CSRF protection
- [ ] Try uploading malicious files (.exe, .php)
- [ ] Test rate limiting (submit homework 11 times)
- [ ] Verify students can't access teacher features
- [ ] Verify teachers can only see their homework
- [ ] Test file size limit enforcement
- [ ] Test file type restriction

### Mobile Testing
- [ ] Test on iPhone (Safari)
- [ ] Test on Android phone (Chrome)
- [ ] Test on iPad/tablet
- [ ] Test portrait and landscape modes
- [ ] Verify touch targets are large enough (44px)
- [ ] Test form inputs on mobile keyboards
- [ ] Test file upload on mobile devices

### Browser Compatibility
- [ ] Google Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Microsoft Edge (latest)
- [ ] Mobile browsers

### Performance Testing
- [ ] Test page load times (< 3 seconds target)
- [ ] Test with 50+ concurrent users
- [ ] Monitor server resources (CPU, RAM)
- [ ] Test file upload with large files
- [ ] Check database query performance

## 📧 Email & Notifications

### Email Configuration
- [ ] Configure mail driver (SMTP recommended)
- [ ] Test email sending: `php artisan tinker` → `Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); })`
- [ ] Verify sender email/name
- [ ] Configure email templates
- [ ] Test password reset emails
- [ ] Test email verification
- [ ] Configure notification emails (homework graded, new assignments)

### Notification Types
- [ ] Password reset notifications
- [ ] Email verification
- [ ] Homework graded (to students)
- [ ] New homework assigned (to students)
- [ ] Homework submitted (to teachers)
- [ ] System notifications

## 🔄 Backup & Recovery

### Backup Strategy
- [ ] Set up automated database backups (daily)
- [ ] Set up automated file backups (daily)
- [ ] Store backups off-site (S3, Google Drive, etc.)
- [ ] Test backup restoration process
- [ ] Document backup locations and procedures
- [ ] Configure backup retention policy (30 days recommended)

### Backup Commands
```bash
# Database backup
php artisan backup:run --only-db

# Full backup (database + files)
php artisan backup:run

# Or use mysqldump
mysqldump -u username -p database_name > backup.sql
```

## 📊 Monitoring & Logging

### Error Logging
- [ ] Configure error logging (storage/logs)
- [ ] Set up log rotation
- [ ] Configure error notification (email/Slack)
- [ ] Test error logging
- [ ] Monitor log files regularly

### Application Monitoring
- [ ] Set up uptime monitoring (UptimeRobot, Pingdom)
- [ ] Configure performance monitoring (New Relic, optional)
- [ ] Set up error tracking (Sentry, Bugsnag, optional)
- [ ] Monitor disk space
- [ ] Monitor database size

## 🛡️ Additional Security

### Server Hardening
- [ ] Disable directory listing
- [ ] Hide server version
- [ ] Configure firewall rules
- [ ] Install fail2ban (brute force protection)
- [ ] Regular security updates
- [ ] Remove unused services

### Application Security
- [ ] Review all routes for authentication
- [ ] Implement CORS policy
- [ ] Add security headers (CSP, X-Frame-Options, etc.)
- [ ] Regular dependency updates: `composer update`
- [ ] Security audit: `composer audit`
- [ ] Remove debug tools from production

## 📚 Documentation

### User Documentation
- [ ] Create admin user guide
- [ ] Create teacher user guide
- [ ] Create student user guide
- [ ] Document common workflows
- [ ] Create FAQ section
- [ ] Record video tutorials (optional)

### Technical Documentation
- [ ] Document deployment process
- [ ] Document backup/restore procedures
- [ ] Document troubleshooting steps
- [ ] Create runbook for common issues
- [ ] Document server configuration
- [ ] Update README.md

## 🎯 Pre-Launch

### Final Checks
- [ ] All tests passing
- [ ] No console errors in browser
- [ ] All features working on production environment
- [ ] All stakeholders trained
- [ ] Support plan in place
- [ ] Rollback plan documented
- [ ] Launch announcement prepared

### Post-Launch Monitoring
- [ ] Monitor error logs (first 24-48 hours)
- [ ] Monitor server performance
- [ ] Monitor user feedback
- [ ] Be ready for quick fixes
- [ ] Monitor database growth
- [ ] Check backup success

## 📋 Post-Deployment

### Immediate (First Week)
- [ ] Monitor application logs daily
- [ ] Check for any errors or issues
- [ ] Gather user feedback
- [ ] Address any critical bugs
- [ ] Monitor server performance

### Ongoing Maintenance
- [ ] Weekly security updates
- [ ] Monthly dependency updates
- [ ] Regular database optimization
- [ ] Review and rotate logs
- [ ] Monitor disk space
- [ ] Review backup integrity

## 🚨 Emergency Procedures

### Rollback Plan
1. Keep previous version accessible
2. Document rollback steps
3. Test rollback procedure
4. Have database backup before deployment

### Emergency Contacts
- [ ] Document technical support contacts
- [ ] Document hosting provider support
- [ ] Document database administrator contact
- [ ] Create incident response plan

---

## Quick Deployment Commands

```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 3. Run migrations
php artisan migrate --force

# 4. Clear and cache
php artisan optimize:clear
php artisan optimize

# 5. Link storage
php artisan storage:link

# 6. Set permissions
chmod -R 755 storage bootstrap/cache

# 7. Restart services
php artisan queue:restart
sudo systemctl restart php8.2-fpm  # Adjust version
sudo systemctl restart nginx  # or apache2
```

---

**Deployment Checklist Version:** 1.0  
**Last Updated:** November 2, 2025  
**Status:** Ready for Production Deployment ✅
