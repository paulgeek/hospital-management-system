# Database Setup Guide

## Database Architecture

The Ghana Hospital Management System uses a **MySQL relational database** with the following structure:

### Tables Created by Migrations

#### 1. **users** - User Accounts
- Stores all user accounts (administrators, doctors, nurses, etc.)
- Includes authentication credentials (email, password)
- Links to healthcare facilities

#### 2. **healthcare_facilities** - Hospital/Clinic Data
- Stores information about healthcare facilities
- Includes NHIS accreditation tracking
- Regional and district information

#### 3. **patients** - Patient Records
- Comprehensive patient demographics
- Blood type and allergy tracking
- Emergency contact information
- Links to healthcare facilities

#### 4. **nhis_memberships** - NHIS Insurance
- Tracks National Health Insurance Scheme memberships
- Premium payment status
- Membership renewal dates
- Exemption information

#### 5. **appointments** - Appointment Scheduling
- Appointment bookings with date/time
- Provider and patient links
- Department assignment
- Status tracking

#### 6. **medical_records** - Digital Health Records
- Patient visit documentation
- Medication records (JSON format)
- Vital signs (JSON format)
- Provider notes

#### 7. **insurance_claims** - Claims Processing
- Insurance claim submissions
- 6-stage workflow tracking
- Claim amounts and approvals
- Service descriptions

#### 8. **Permission Tables** (Spatie Laravel Permission)
- `roles` - Role definitions (7 roles)
- `permissions` - Permission definitions (24+ permissions)
- `role_has_permissions` - Role-permission relationships
- `model_has_roles` - User-role assignments
- `model_has_permissions` - Direct user permissions

## Database Setup Instructions

### Option 1: Setup with MySQL (Recommended)

#### Prerequisites
- PHP 8.0+
- MySQL 5.7+ or MySQL 8.0+
- Composer

#### Steps

1. **Create Database**
```bash
mysql -u root -p
CREATE DATABASE hospital_db;
EXIT;
```

2. **Configure Environment**
```bash
cd hospital-management-system
cp .env.example .env
```

3. **Edit .env file** with your MySQL credentials:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Generate App Key**
```bash
php artisan key:generate
```

5. **Run Migrations**
```bash
php artisan migrate
```

6. **Seed Database** (creates roles, permissions, and test users)
```bash
php artisan db:seed
```

**Complete command:**
```bash
php artisan migrate --seed
```

### Option 2: Setup with SQLite (Development)

1. **Configure .env**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

2. **Create SQLite file**
```bash
touch database/database.sqlite
```

3. **Run migrations**
```bash
php artisan migrate --seed
```

### Option 3: Docker Setup

1. **Start MySQL container**
```bash
docker run --name hospital-mysql \
  -e MYSQL_ROOT_PASSWORD=password \
  -e MYSQL_DATABASE=hospital_db \
  -p 3306:3306 \
  -d mysql:8.0
```

2. **Update .env**
```env
DB_HOST=localhost
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=password
```

3. **Run migrations**
```bash
php artisan migrate --seed
```

## Database Seeders

### What Gets Seeded

#### 1. **RolePermissionSeeder** 
Creates 7 roles with 24+ permissions:
- Administrator (all permissions)
- Doctor (patient, appointment, medical record access)
- Nurse (patient, appointment, medical record access)
- Pharmacist (patient, medical record access)
- NHIS Officer (NHIS, insurance access)
- Finance Officer (insurance, payment access)
- Patient (own appointment, medical record view)

#### 2. **HealthcareFacilitySeeder**
Pre-seeds 5 healthcare facilities:
- Kumasi Teaching Hospital
- Korle Bu Teaching Hospital
- City Clinic Accra
- Tamale Regional Hospital
- Cape Coast Regional Hospital

#### 3. **UserSeeder**
Creates 5 test user accounts:
- **Administrator:** admin@ghospital.gov.gh / Admin@123456
- **Doctor:** doctor@ghospital.gov.gh / Doctor@12345
- **Nurse:** nurse@ghospital.gov.gh / Nurse@12345
- **NHIS Officer:** nhis@ghospital.gov.gh / NHIS@12345
- **Finance Officer:** finance@ghospital.gov.gh / Finance@12345

## Database Backup

### Manual Backup
```bash
# MySQL Backup
mysqldump -u root -p hospital_db > backup_hospital_$(date +%Y%m%d_%H%M%S).sql

# Restore
mysql -u root -p hospital_db < backup_hospital_20240101_120000.sql
```

### Laravel Backup Command (if backup package installed)
```bash
php artisan backup:run
```

## Database Maintenance

### Reset Database (Development Only)
```bash
# Delete all tables and reseed
php artisan migrate:refresh --seed
```

### Fresh Start (Caution - Deletes All Data)
```bash
php artisan migrate:fresh --seed
```

### View Database Migrations
```bash
php artisan migrate:status
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

## Performance Optimization

### Database Indexes
- User emails (unique)
- Patient IDs (unique)
- NHIS numbers (unique)
- Appointment dates
- Claim status
- Foreign key columns

### Query Optimization
- Eager loading with `with()` method
- Pagination (15 items per page default)
- Database connection pooling
- Query caching for reports

## Ghana-Specific Data

### Regions (16 Ghana Regions)
- Ashanti
- Ahafo
- Bono
- Bono East
- Central
- Eastern
- Greater Accra
- North East
- Northern
- Oti
- Savanna
- Upper East
- Upper West
- Volta
- Western
- Western North

### Healthcare Facility Types
- Hospital
- Clinic
- Pharmacy
- Laboratory
- Diagnostic Center

### NHIS Member Categories
- Vulnerable persons
- Indigent persons
- SSNIT members
- Private subscribers
- Informal sector workers

### Appointment Status
- Pending
- Confirmed
- Completed
- Cancelled

### Insurance Claim Status (6 Stages)
1. Draft
2. Submitted
3. Under Review
4. Approved
5. Rejected
6. Paid

## Troubleshooting

### "SQLSTATE[HY000]: General error: 1030 Got error..."
- Check MySQL is running
- Verify database credentials in .env
- Ensure database exists

### "The migration [...] has not been run yet"
- Run `php artisan migrate`

### "Class does not exist" error
- Run `composer install`
- Run `composer dump-autoload`

### Permission denied on database files
- Check file permissions: `chmod 755 storage database`
- Ensure web server user can write to these directories

### Cannot seed database
- Ensure migrations have run first: `php artisan migrate`
- Check seeders for errors: `php artisan seed --class=RolePermissionSeeder`

## Database Schema Export

To view the complete database schema:
```bash
php artisan schema:dump
```

## Additional Resources

- [Laravel Database Documentation](https://laravel.com/docs/9.x/database)
- [Laravel Migrations](https://laravel.com/docs/9.x/migrations)
- [Spatie Laravel Permissions](https://spatie.be/docs/laravel-permission/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

**Note:** Database files (*.sqlite, database.sqlite3) are **NOT** committed to the repository. Follow these setup steps to create your database. The `.gitignore` file ensures database files are never accidentally committed.
