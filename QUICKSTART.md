# Quick Start Guide

## 🚀 Getting Started in 5 Minutes

### Prerequisites
- PHP 8.0+
- MySQL 5.7+
- Composer
- Web browser

### Installation

1. **Extract/Clone the Project**
```bash
cd hospital-management-system
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database** (Edit `.env`)
```env
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=
```

5. **Create Database & Run Migrations**
```bash
mysql -u root -p -e "CREATE DATABASE hospital_db;"
php artisan migrate --seed
```

6. **Start Server**
```bash
php artisan serve
```

7. **Access Application**
```
http://localhost:8000
```

---

## 🔑 Login Credentials

### Admin Account (Full Access)
- **Email**: admin@ghospital.gov.gh
- **Password**: Admin@123456

### Other Test Accounts
```
Doctor          : doctor@ghospital.gov.gh  / Doctor@12345
Nurse           : nurse@ghospital.gov.gh   / Nurse@12345
NHIS Officer    : nhis@ghospital.gov.gh    / NHIS@12345
Finance Officer : finance@ghospital.gov.gh / Finance@12345
```

---

## 📋 Main Features

### Dashboard
- System statistics overview
- Recent appointments and claims
- Quick action buttons

### Patient Management
- Register new patients
- View patient details
- Update patient information
- Track patient NHIS membership
- View patient medical history

### Appointments
- Schedule appointments
- View appointment calendar
- Cancel appointments
- Track appointment status

### NHIS Members
- Register NHIS membership
- Manage member information
- Renew expired memberships
- Track membership expiry

### Insurance Claims
- Create insurance claims
- Submit claims for review
- Approve/reject claims
- Track claim status
- View claim history

### User Management
- Manage user profiles
- Change password
- View user roles and permissions

---

## 🎯 Common Tasks

### Register a New Patient

1. Go to **Patients** → **Register New Patient**
2. Fill in patient details:
   - First Name & Last Name
   - Date of Birth
   - Gender
   - Contact Information
   - Healthcare Facility
3. Click **Register Patient**

### Schedule an Appointment

1. Go to **Appointments** → **Schedule Appointment**
2. Select:
   - Patient
   - Healthcare Provider (Doctor)
   - Healthcare Facility
   - Department
   - Appointment Date & Time
   - Reason for visit
3. Click **Schedule Appointment**

### Register NHIS Member

1. Go to **NHIS Members** → **Register NHIS Member**
2. Select Patient
3. Enter:
   - Member Category
   - Registration Date
   - Expiry Date
   - Premium Amount
   - Payment Method
4. Click **Register NHIS Member**

### Create Insurance Claim

1. Go to **Insurance Claims** → **Create New Claim**
2. Select:
   - Patient
   - Healthcare Facility
   - Service Date
   - Claim Amount
   - Service Description
3. Click **Create Claim**
4. Submit claim for review

---

## 📊 Dashboard Overview

The dashboard displays:
- **Total Patients**: All registered patients
- **Pending Appointments**: Scheduled but not yet completed
- **Active NHIS Members**: Currently active insurance members
- **Pending Claims**: Claims awaiting review
- **Total Users**: System user count
- **Total Facilities**: Healthcare facilities in the system
- **Medical Records**: Total medical records on file
- **Completed Visits**: Finished appointments

---

## 🔐 Security Tips

1. **Change default passwords** immediately after first login
2. **Use strong passwords** (min 8 characters)
3. **Do not share login credentials**
4. **Logout when finished** using the system
5. **Enable HTTPS** in production

---

## ⚙️ Configuration

### Change App Name
Edit `.env`:
```env
APP_NAME="Your Hospital Name"
```

### Database Timezone
Edit `config/app.php`:
```php
'timezone' => 'Africa/Accra',
```

### NHIS Settings
See `config/hospital.php` for NHIS configuration

---

## 📱 System Requirements

| Component | Requirement |
|-----------|-------------|
| PHP | 8.0 or higher |
| Laravel | 9.0 or higher |
| MySQL | 5.7 or higher |
| RAM | 512 MB minimum |
| Disk Space | 1 GB minimum |

---

## 🐛 Troubleshooting

### "Database connection failed"
- Check MySQL is running
- Verify `.env` database credentials
- Ensure database exists

### "Port 8000 in use"
- Use different port: `php artisan serve --port=8001`

### "Class not found"
- Run: `composer dump-autoload`

### "Permission denied"
- Run: `chmod -R 755 storage bootstrap/cache`

### Still Having Issues?
See `INSTALLATION.md` for detailed troubleshooting

---

## 📚 Documentation

- **Full Documentation**: See `README.md`
- **Architecture**: See `ARCHITECTURE.md`
- **Installation Guide**: See `INSTALLATION.md`
- **Laravel Docs**: https://laravel.com/docs

---

## 🆘 Support

- Email: support@ghospital.gov.gh
- Phone: +233 300 000 000
- Documentation: Check `/docs` directory

---

## ✨ Next Steps

After installation, consider:

1. **Change admin password** for security
2. **Add your facility information**
3. **Create additional user accounts** for your staff
4. **Configure email settings** for notifications
5. **Setup regular database backups**
6. **Customize system settings**

---

## 📝 Default Healthcare Facilities

The system comes with 5 pre-configured healthcare facilities:
1. **Kumasi Teaching Hospital** - Ashanti Region
2. **Korle Bu Teaching Hospital** - Greater Accra
3. **City Clinic Accra** - Greater Accra
4. **Tamale Regional Hospital** - Northern Region
5. **Cape Coast Regional Hospital** - Central Region

---

**Happy using Ghana Hospital Management System! 🏥**
