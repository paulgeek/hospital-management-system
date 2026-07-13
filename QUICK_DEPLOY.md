# 🚀 ONE-CLICK DEPLOYMENT GUIDE

## Complete Ready-To-Deploy Package

Your Ghana Hospital Management System is now ready for **instant deployment** with the database already prepared!

---

## ✅ What's Included

✅ Complete Laravel application (51 files)
✅ Database schema with all tables
✅ Pre-configured roles (7 roles)
✅ Pre-configured permissions (24+ permissions)
✅ Pre-seeded healthcare facilities (5 facilities)
✅ Pre-created user accounts (5 test users)
✅ Complete database dump file (database_dump.sql)
✅ Deployment instructions for all platforms

---

## 🎯 Fastest Deployment (5-10 minutes)

### Option 1: Shared Hosting (cPanel)

**Step 1: Upload Files**
```
1. Download: hospital-management-system.zip
2. Unzip locally
3. Connect via FTP
4. Upload all files to public_html/
5. Ensure .htaccess is uploaded (hidden file)
```

**Step 2: Create Database**
```
Via cPanel:
1. Go to "MySQL Databases"
2. Create: hospital_db
3. Create user: hospital_user (password: Generate strong)
4. Assign ALL privileges
5. Note credentials
```

**Step 3: Import Database Dump**
```
Via cPanel > phpMyAdmin:
1. Go to hospital_db
2. Click "Import"
3. Select database_dump.sql (from zip)
4. Click "Go"
5. Wait for completion ✓

OR via SSH:
mysql -u hospital_user -p hospital_db < database_dump.sql
```

**Step 4: Configure Application**
```
Via SSH or File Manager:
1. Open .env file
2. Update these lines:
   APP_DEBUG=false
   DB_HOST=localhost
   DB_DATABASE=hospital_db
   DB_USERNAME=hospital_user
   DB_PASSWORD=your_password
   APP_URL=https://yourdomain.com

3. Save file
```

**Step 5: Set Permissions**
```
Via SSH:
chmod -R 755 storage bootstrap/cache
chmod 644 .env
```

**Step 6: Access Application**
```
Visit: https://yourdomain.com
Login: admin@ghospital.gov.gh
Password: Admin@123456
✓ Done!
```

---

### Option 2: Heroku (Easiest)

**Step 1: Create Heroku App**
```bash
heroku create hospital-app
```

**Step 2: Add Database**
```bash
heroku addons:create cleardb:ignite -a hospital-app
```

**Step 3: Deploy Code**
```bash
git push heroku main
```

**Step 4: Import Database Dump**
```bash
# Get Heroku database URL
heroku config:get CLEARDB_DATABASE_URL -a hospital-app

# Connect and import
mysql -h db-host -u db-user -p database < database_dump.sql
```

**Step 5: Access**
```
heroku open -a hospital-app
```

---

### Option 3: DigitalOcean (Best Balance)

**Step 1: Create App on DigitalOcean**
```
1. Go to DigitalOcean.com
2. Apps > Create App
3. Select GitHub repository
4. Add MySQL database
5. Set environment variables:
   DB_HOST=mysql-host
   DB_DATABASE=hospital_db
   DB_USERNAME=hospital_user
   DB_PASSWORD=strong_password
6. Deploy
```

**Step 2: Import Database**
```bash
# SSH into your droplet
ssh root@your-server-ip

# Import database dump
mysql -u hospital_user -p hospital_db < database_dump.sql
```

**Step 3: Access**
```
Visit your deployed application URL
```

---

## 🔐 Default Test Accounts (CHANGE IMMEDIATELY)

After deployment, login with:

```
Email: admin@ghospital.gov.gh
Password: Admin@123456
```

**Then immediately:**
1. Go to Settings > Change Password
2. Create strong new password
3. Create additional admin users
4. Delete test accounts or change their passwords
```

**Other test accounts available:**
- doctor@ghospital.gov.gh / Doctor@12345
- nurse@ghospital.gov.gh / Nurse@12345
- nhis@ghospital.gov.gh / NHIS@12345
- finance@ghospital.gov.gh / Finance@12345
```

---

## 📋 Pre-Deployment Checklist

Before uploading, prepare:

- [ ] Domain name registered
- [ ] Hosting account created
- [ ] FTP credentials ready (Shared Hosting) OR
- [ ] SSH access setup (VPS)
- [ ] MySQL access confirmed
- [ ] .env.example renamed to .env
- [ ] All files ready in hospital-management-system/ directory

---

## 🔧 File Structure to Upload

```
hospital-management-system/
├── app/                    (Laravel application code)
├── bootstrap/
├── config/                 (hospital.php with settings)
├── database/
│   ├── migrations/        (Database schema files)
│   └── seeders/           (Pre-configured data)
├── public/                (Web root - static files)
├── resources/
│   ├── views/            (18 Blade templates)
│   └── css/
├── routes/               (Application routes)
├── storage/              (Logs, cache, sessions)
├── .env                  (Environment - EDIT THIS!)
├── .env.example          (Template)
├── .gitignore
├── composer.json
├── artisan               (CLI tool)
├── database_dump.sql     (Pre-migrated database)
└── ...other files...
```

**Most Important File to Edit:** `.env`

---

## 💾 What the Database Dump Includes

The `database_dump.sql` file contains:

✅ **8 Database Tables:**
- healthcare_facilities (5 pre-configured)
- users (5 test accounts)
- patients
- appointments
- nhis_memberships
- medical_records
- insurance_claims
- roles, permissions, role_has_permissions, model_has_roles

✅ **7 Roles:**
- Administrator (all permissions)
- Doctor
- Nurse
- Pharmacist
- Patient
- NHIS Officer
- Finance Officer

✅ **24+ Permissions** automatically assigned

✅ **5 Healthcare Facilities:**
- Kumasi Teaching Hospital
- Korle Bu Teaching Hospital
- City Clinic Accra
- Tamale Regional Hospital
- Cape Coast Regional Hospital

✅ **5 User Accounts with roles assigned:**
- admin@ghospital.gov.gh (Administrator)
- doctor@ghospital.gov.gh (Doctor)
- nurse@ghospital.gov.gh (Nurse)
- nhis@ghospital.gov.gh (NHIS Officer)
- finance@ghospital.gov.gh (Finance Officer)

---

## 🚨 Critical .env Settings

Edit `.env` file with your hosting details:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=hospital_db
DB_USERNAME=hospital_user
DB_PASSWORD=your_strong_password

MAIL_MAILER=log
MAIL_FROM_ADDRESS=support@ghospital.gov.gh
```

**Never:**
- Commit .env to Git
- Share .env publicly
- Use weak database passwords
- Leave APP_DEBUG=true in production

---

## ✨ After Deployment Verification

After uploading and accessing your domain, verify:

```
✅ Application loads (no 500 error)
✅ Login page displays
✅ Can login with admin credentials
✅ Dashboard shows statistics
✅ Click on menu items:
   - Patients (should show empty list)
   - Appointments (should show empty list)
   - NHIS Members (should show empty list)
   - Insurance Claims (should show empty list)
✅ Settings page loads
✅ SSL certificate active (HTTPS working)
✅ No console errors (F12 Dev Tools)
```

---

## 🆘 Troubleshooting

### "Database Connection Error"
```
❌ Problem: Wrong DB credentials in .env
✅ Fix:
   1. Verify DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env
   2. Test MySQL connection via cPanel > phpMyAdmin
   3. Ensure user has all privileges
```

### "500 Server Error"
```
❌ Problem: PHP error or misconfiguration
✅ Fix:
   1. Check error logs: storage/logs/laravel.log
   2. Verify PHP version 8.0+
   3. Ensure storage/ and bootstrap/cache/ are writable
   4. Clear cache: php artisan cache:clear
```

### "Permission Denied"
```
❌ Problem: File permissions not set correctly
✅ Fix:
   chmod -R 755 storage bootstrap/cache
   chmod 644 .env
```

### "404 Not Found on routes"
```
❌ Problem: .htaccess not uploaded or mod_rewrite disabled
✅ Fix:
   1. Verify .htaccess is uploaded (it's a hidden file)
   2. Check public_html/.htaccess contains Laravel rules
   3. Contact hosting: enable mod_rewrite
```

---

## 📊 Deployment Comparison

| Method | Time | Difficulty | Cost | Best For |
|--------|------|------------|------|----------|
| **Shared Hosting** | 30min | ⭐ Easy | $5-15/mo | Budget hospitals |
| **Heroku** | 10min | ⭐ Easy | $7-50/mo | Quick deployments |
| **DigitalOcean** | 15min | ⭐⭐ Easy | $12-24/mo | ✅ **RECOMMENDED** |
| **AWS** | 2hrs | ⭐⭐⭐ Hard | $100+/mo | Enterprise |
| **VPS** | 1-2hrs | ⭐⭐ Moderate | $5-30/mo | Full control |

---

## 🔒 Security After Deployment

**Day 1 - CRITICAL:**
```bash
1. ✅ Change admin password
   - Login with admin@ghospital.gov.gh / Admin@123456
   - Go to Settings > Change Password
   - Set strong password (16+ characters)

2. ✅ Enable HTTPS/SSL
   - cPanel: AutoSSL (automatic)
   - Or use Let's Encrypt

3. ✅ Setup automated backups
   - Daily MySQL backups
   - Keep 30 days of backups

4. ✅ Create additional admin users
   - Don't share credentials
   - One account per admin

5. ✅ Update APP_DEBUG to false
   - .env: APP_DEBUG=false
```

---

## 📚 Documentation Files in Package

| File | Purpose | Read Time |
|------|---------|-----------|
| **README.md** | System overview | 5 min |
| **INSTALLATION.md** | Setup guide | 10 min |
| **DEPLOYMENT.md** | Platform-specific guides | 20 min |
| **DATABASE_SETUP.md** | Database configuration | 15 min |
| **DEPLOYMENT_CHECKLIST.md** | Pre/post verification | 5 min |
| **FILE_INDEX.md** | Complete file reference | 10 min |
| **database_dump.sql** | Pre-migrated database | N/A |
| **.env.example** | Configuration template | 2 min |

---

## 🎯 Step-by-Step Quick Start

### For Shared Hosting Users

```
1. Upload files via FTP
   Total size: ~5MB

2. Create database in cPanel
   Name: hospital_db
   User: hospital_user

3. Import SQL dump via phpMyAdmin
   File: database_dump.sql

4. Edit .env file
   Update 6 lines with your credentials

5. Set folder permissions
   chmod -R 755 storage bootstrap/cache

6. Visit yourdomain.com
   ✓ Deployed!
```

### For DigitalOcean Users

```
1. Connect GitHub account
2. Create App Platform project
3. Set environment variables (6 values)
4. Click Deploy
5. Import database dump
6. ✓ Done!
```

### For VPS Users

```
1. SSH into server
2. git clone repository
3. Install dependencies: composer install
4. Create database
5. Import SQL dump
6. Set .env configuration
7. Set permissions and ownership
8. ✓ Done!
```

---

## 💡 Pro Tips

1. **Test locally first** - Run `php artisan serve` locally before deployment
2. **Use HTTPS** - Always use HTTPS in production
3. **Backup regularly** - Daily backups are essential
4. **Monitor uptime** - Setup uptime monitoring from day 1
5. **Keep updated** - Run `composer update` monthly
6. **Document changes** - Track any customizations
7. **Train staff** - Conduct staff training before launch
8. **Plan scaling** - Think ahead for growth

---

## ✅ Success Indicators

Your deployment is successful when:

```
✅ Application loads without errors
✅ Login page displays properly
✅ Can login with admin credentials
✅ Dashboard shows 8 stat cards
✅ All menu items visible
✅ Database queries working
✅ Patient list loads
✅ Appointment list loads
✅ NHIS member list loads
✅ Insurance claims list loads
✅ SSL certificate active (green padlock)
✅ No errors in browser console
✅ Admin password changed
```

---

## 🎉 DEPLOYMENT COMPLETE!

Your Ghana Hospital Management System is now live!

**Next Steps:**
1. Train your staff
2. Create facility admin accounts
3. Begin data entry
4. Monitor system performance
5. Plan for additional features

---

## 📞 Support

- **GitHub:** https://github.com/paulgeek/hospital-management-system
- **Laravel Docs:** https://laravel.com/docs
- **Your Hosting Provider:** Contact support for platform-specific help

---

**Congratulations! Your hospital management system is deployed and ready to serve patients! 🏥**
