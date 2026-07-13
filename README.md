# Ghana Hospital Management System (GHMS)

A comprehensive Laravel-based hospital management system designed for Ghana Health Service with integrated National Health Insurance Scheme (NHIS) functionality, role-based access control, and comprehensive healthcare management features.

## Features

### 1. **User Management & Authentication**
- Role-based access control (RBAC) with 7 predefined roles
- Secure authentication system
- User profile management
- Password management and change functionality
- Session management

### 2. **Roles & Permissions**
- **Administrator**: Full system access
- **Doctor**: Patient management, medical records, appointments
- **Nurse**: Patient records, appointments, medical records
- **Pharmacist**: Medication management
- **Patient**: Personal health records and appointments
- **NHIS Officer**: Insurance member management and claims review
- **Finance Officer**: Financial operations and claim approvals

### 3. **Patient Management**
- Patient registration with comprehensive details
- Patient ID generation
- Blood type and allergy information
- Emergency contact information
- Geographic location tracking (Region, District, Town)
- Patient status tracking (active, inactive, transferred, deceased)

### 4. **Healthcare Facilities**
- Multi-facility support
- Facility categorization (Hospital, Clinic, Pharmacy, Laboratory, Diagnostic Center)
- NHIS accreditation tracking
- License and accreditation number management
- Geographic facility tracking

### 5. **Appointments Management**
- Schedule appointments with date/time
- Multiple status tracking (scheduled, completed, cancelled, no-show, rescheduled)
- Provider assignment (Doctors)
- Department allocation
- Appointment reminders

### 6. **National Health Insurance Scheme (NHIS)**
- NHIS membership registration
- Member categories (Vulnerable, Indigent, SSNIT, Private, Informal)
- Premium payment tracking
- Subscription status management
- Exemption status and reasons
- Renewal management
- Unique NHIS number generation

### 7. **Insurance Claims Management**
- Claim submission and tracking
- Claim status workflow (draft, submitted, under_review, approved, rejected, paid)
- Claim amount tracking (claim amount vs. approved amount)
- Rejection reason documentation
- Medical record linking
- Multiple payment methods support

### 8. **Medical Records**
- Digital medical record management
- Visit type tracking
- Diagnosis and treatment plans
- Medication tracking (JSON format)
- Vital signs monitoring (JSON format)
- Record status management (draft, completed, signed, archived)

### 9. **Dashboard**
- System statistics overview
- Recent appointments display
- Insurance claims summary
- Patient distribution by facility
- Quick action buttons
- Real-time data updates

## Default User Credentials

The system comes with pre-configured user accounts for testing:

### Administrator Account
- **Email**: admin@ghospital.gov.gh
- **Password**: Admin@123456
- **Role**: Administrator (Full Access)

### Test Accounts
| Role | Email | Password |
|------|-------|----------|
| Doctor | doctor@ghospital.gov.gh | Doctor@12345 |
| Nurse | nurse@ghospital.gov.gh | Nurse@12345 |
| NHIS Officer | nhis@ghospital.gov.gh | NHIS@12345 |
| Finance Officer | finance@ghospital.gov.gh | Finance@12345 |

## Database Structure

### Important: Database Not Included

⚠️ **The database file is NOT included in the repository for security reasons.** 

Database files (*.sqlite, *.sqlite3, database.sqlite) are excluded via `.gitignore`. 

**To setup the database:**
```bash
php artisan migrate --seed
```

This command will:
1. Create all database tables from migrations
2. Seed roles, permissions, and test users
3. Create 5 healthcare facilities
4. Setup the complete system

See **DATABASE_SETUP.md** for detailed database setup instructions.

### Core Tables
- **users**: System users with role assignments
- **healthcare_facilities**: Hospital, clinics, and healthcare centers
- **patients**: Patient information and demographics
- **nhis_memberships**: NHIS coverage information
- **appointments**: Appointment scheduling
- **medical_records**: Digital medical records
- **insurance_claims**: Insurance claim tracking
- **roles & permissions**: RBAC configuration

### Relationships
- Users → Facilities (Many-to-One)
- Patients → Facilities (Many-to-One)
- Patients → NHIS Membership (One-to-One)
- Appointments → Patient, User (Doctor), Facility (Many-to-One)
- Medical Records → Patient, Doctor, Facility (Many-to-One)
- Insurance Claims → Patient, Facility, Medical Record (Many-to-One)

## Installation & Setup

### Requirements
- PHP 8.0 or higher
- Laravel 9.0 or higher
- MySQL 5.7 or higher
- Composer

### Steps

1. **Clone Repository**
```bash
git clone <repository-url>
cd hospital-management-system
```

2. **Install Dependencies**
```bash
composer install
```

3. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE hospital_db;"

# Run migrations
php artisan migrate

# Seed default data (admin account, roles, permissions, facilities)
php artisan db:seed
```

5. **Start Development Server**
```bash
php artisan serve
```

Visit `http://localhost:8000` and login with admin credentials

## File Structure

```
hospital-management-system/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Patient.php
│   │   ├── HealthcareFacility.php
│   │   ├── Appointment.php
│   │   ├── NHISMembership.php
│   │   ├── MedicalRecord.php
│   │   └── InsuranceClaim.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   └── Admin/
│   │   └── Middleware/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── admin/
│   │   └── settings/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
└── config/
```

## User Interface

### Main Dashboard
- Statistics cards showing system overview
- Recent appointments and claims lists
- Quick action buttons
- Patient distribution chart

### Navigation Menu
- Dashboard
- Patient Management
  - View/Register/Edit Patients
- Appointments
  - Schedule/View/Cancel Appointments
- NHIS Members
  - Register/Manage NHIS Memberships
- Insurance Claims
  - Create/Review/Approve Claims
- Settings
  - Profile Management
  - Change Password

### Responsive Design
- Bootstrap 5 framework
- Mobile-friendly layout
- Fixed sidebar navigation
- Professional color scheme

## Security Features

1. **Authentication**
   - Secure password hashing (bcrypt)
   - Session management
   - CSRF protection

2. **Authorization**
   - Role-based access control (Spatie Permission)
   - Permission verification on routes
   - Model authorization

3. **Data Protection**
   - Input validation
   - SQL injection prevention (Eloquent ORM)
   - XSS protection

## Key Routes

### Authentication
- `GET  /login` - Login form
- `POST /login` - Process login
- `POST /logout` - Logout user

### Dashboard
- `GET /dashboard` - Main dashboard

### Patients
- `GET  /patients` - List all patients
- `GET  /patients/create` - Patient registration form
- `POST /patients` - Store new patient
- `GET  /patients/{patient}` - View patient details
- `GET  /patients/{patient}/edit` - Edit patient form
- `PUT  /patients/{patient}` - Update patient

### Appointments
- `GET  /appointments` - List appointments
- `GET  /appointments/create` - Create appointment
- `POST /appointments` - Store appointment
- `GET  /appointments/{appointment}` - View appointment
- `PATCH /appointments/{appointment}/cancel` - Cancel appointment

### NHIS
- `GET  /nhis` - List NHIS members
- `GET  /nhis/create` - Register NHIS member
- `POST /nhis` - Store NHIS membership
- `GET  /nhis/{membership}` - View membership
- `PATCH /nhis/{membership}/renew` - Renew membership

### Insurance Claims
- `GET  /claims` - List claims
- `GET  /claims/create` - Create claim
- `POST /claims` - Store claim
- `GET  /claims/{claim}` - View claim
- `PATCH /claims/{claim}/submit` - Submit claim
- `PATCH /claims/{claim}/approve` - Approve claim
- `PATCH /claims/{claim}/reject` - Reject claim

## Ghana Health Service Compliance

This system is designed to comply with Ghana Health Service standards:
- NHIS integration and member tracking
- Healthcare facility standards
- Medical record documentation
- Insurance claim processing
- Regional health system hierarchy

## Support & Documentation

For detailed API documentation, implementation guides, and troubleshooting, refer to the `/docs` directory.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributors

- Ghana Health Service Development Team
- Healthcare IT Solutions

## Contact

For support and inquiries:
- Email: support@ghospital.gov.gh
- Phone: +233 300 000 000
