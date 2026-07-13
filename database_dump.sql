-- ============================================
-- Ghana Hospital Management System - Database Dump
-- Version: 1.0
-- Database: hospital_db
-- Date: 2024-01-13
-- ============================================

-- Drop tables if they exist
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `healthcare_facilities`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `nhis_memberships`;
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `medical_records`;
DROP TABLE IF EXISTS `insurance_claims`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `role_has_permissions`;
DROP TABLE IF EXISTS `model_has_roles`;
DROP TABLE IF EXISTS `model_has_permissions`;
SET FOREIGN_KEY_CHECKS=1;

-- ============================================
-- TABLE: healthcare_facilities
-- ============================================
CREATE TABLE `healthcare_facilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `facility_code` varchar(50) NOT NULL UNIQUE,
  `facility_name` varchar(255) NOT NULL,
  `facility_type` enum('Hospital','Clinic','Pharmacy','Laboratory','Diagnostic Center') NOT NULL,
  `region` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `town` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20),
  `email` varchar(255),
  `nhis_accredited` boolean DEFAULT false,
  `accreditation_number` varchar(100),
  `license_number` varchar(100),
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facility_code` (`facility_code`),
  KEY `region_index` (`region`),
  KEY `facility_type_index` (`facility_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: users
-- ============================================
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone` varchar(20),
  `password` varchar(255) NOT NULL,
  `employee_id` varchar(100) UNIQUE,
  `department` varchar(100),
  `facility_id` bigint unsigned,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `email_verified_at` timestamp NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `facility_id_index` (`facility_id`),
  KEY `status_index` (`status`),
  CONSTRAINT `users_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `healthcare_facilities` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: patients
-- ============================================
CREATE TABLE `patients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL UNIQUE,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone` varchar(20),
  `email` varchar(255),
  `national_id` varchar(50) UNIQUE,
  `address` text,
  `region` varchar(100),
  `district` varchar(100),
  `town` varchar(100),
  `facility_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned,
  `blood_type` enum('O+','O-','A+','A-','B+','B-','AB+','AB-','Unknown'),
  `allergies` text,
  `emergency_contact` varchar(255),
  `emergency_phone` varchar(20),
  `status` enum('active','inactive','transferred','deceased') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_id` (`patient_id`),
  KEY `facility_id_index` (`facility_id`),
  KEY `user_id_index` (`user_id`),
  KEY `national_id_index` (`national_id`),
  CONSTRAINT `patients_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `healthcare_facilities` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: nhis_memberships
-- ============================================
CREATE TABLE `nhis_memberships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint unsigned NOT NULL UNIQUE,
  `nhis_number` varchar(50) NOT NULL UNIQUE,
  `member_category` enum('Vulnerable','Indigent','SSNIT','Private','Informal') NOT NULL,
  `registration_date` date NOT NULL,
  `expiry_date` date,
  `subscription_status` enum('Active','Expired','Suspended','Cancelled') DEFAULT 'Active',
  `premium_paid` decimal(10,2) DEFAULT 0,
  `payment_method` varchar(50),
  `renewal_date` date,
  `exemption_status` boolean DEFAULT false,
  `exemption_reason` varchar(255),
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nhis_number` (`nhis_number`),
  KEY `patient_id_index` (`patient_id`),
  KEY `subscription_status_index` (`subscription_status`),
  CONSTRAINT `nhis_memberships_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: appointments
-- ============================================
CREATE TABLE `appointments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `appointment_id` varchar(50) NOT NULL UNIQUE,
  `patient_id` bigint unsigned NOT NULL,
  `provider_id` bigint unsigned,
  `facility_id` bigint unsigned NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `department` varchar(100),
  `reason` text,
  `notes` text,
  `status` enum('Pending','Confirmed','Completed','Cancelled','No-show','Rescheduled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointment_id` (`appointment_id`),
  KEY `patient_id_index` (`patient_id`),
  KEY `provider_id_index` (`provider_id`),
  KEY `facility_id_index` (`facility_id`),
  KEY `appointment_date_index` (`appointment_date`),
  KEY `status_index` (`status`),
  CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `healthcare_facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: medical_records
-- ============================================
CREATE TABLE `medical_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint unsigned NOT NULL,
  `provider_id` bigint unsigned,
  `facility_id` bigint unsigned NOT NULL,
  `record_date` date NOT NULL,
  `visit_type` enum('Outpatient','Inpatient','Emergency','Follow-up') DEFAULT 'Outpatient',
  `diagnosis` text,
  `treatment_plan` text,
  `medications` json,
  `vital_signs` json,
  `status` enum('Draft','Completed','Signed','Archived') DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patient_id_index` (`patient_id`),
  KEY `provider_id_index` (`provider_id`),
  KEY `facility_id_index` (`facility_id`),
  KEY `record_date_index` (`record_date`),
  CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medical_records_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `medical_records_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `healthcare_facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: insurance_claims
-- ============================================
CREATE TABLE `insurance_claims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `claim_id` varchar(50) NOT NULL UNIQUE,
  `patient_id` bigint unsigned NOT NULL,
  `facility_id` bigint unsigned NOT NULL,
  `claim_date` date NOT NULL,
  `service_date` date NOT NULL,
  `service_description` text NOT NULL,
  `claim_amount` decimal(12,2) NOT NULL,
  `approved_amount` decimal(12,2),
  `claim_status` enum('Draft','Submitted','Under Review','Approved','Rejected','Paid') DEFAULT 'Draft',
  `rejection_reason` text,
  `payment_method` varchar(50),
  `payment_date` date,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `claim_id` (`claim_id`),
  KEY `patient_id_index` (`patient_id`),
  KEY `facility_id_index` (`facility_id`),
  KEY `claim_status_index` (`claim_status`),
  KEY `claim_date_index` (`claim_date`),
  CONSTRAINT `insurance_claims_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `insurance_claims_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `healthcare_facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: roles (Spatie Permission)
-- ============================================
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: permissions (Spatie Permission)
-- ============================================
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: role_has_permissions
-- ============================================
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: model_has_roles
-- ============================================
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL DEFAULT 'App\Models\User',
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: model_has_permissions
-- ============================================
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL DEFAULT 'App\Models\User',
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SEED DATA: Roles
-- ============================================
INSERT INTO `roles` (`name`, `guard_name`) VALUES
('Administrator', 'web'),
('Doctor', 'web'),
('Nurse', 'web'),
('Pharmacist', 'web'),
('Patient', 'web'),
('NHIS Officer', 'web'),
('Finance Officer', 'web');

-- ============================================
-- SEED DATA: Permissions
-- ============================================
INSERT INTO `permissions` (`name`, `guard_name`) VALUES
-- Patient Management
('view patients', 'web'),
('create patient', 'web'),
('edit patient', 'web'),
('delete patient', 'web'),
('view patient details', 'web'),
-- Appointment Management
('view appointments', 'web'),
('create appointment', 'web'),
('edit appointment', 'web'),
('cancel appointment', 'web'),
-- NHIS Management
('view nhis members', 'web'),
('register nhis member', 'web'),
('edit nhis member', 'web'),
('approve membership', 'web'),
-- Insurance Claims
('view claims', 'web'),
('create claim', 'web'),
('submit claim', 'web'),
('approve claim', 'web'),
('reject claim', 'web'),
-- Medical Records
('view medical records', 'web'),
('create medical record', 'web'),
('edit medical record', 'web'),
-- User Management
('view users', 'web'),
('create user', 'web'),
('edit user', 'web'),
('delete user', 'web'),
-- System Management
('view dashboard', 'web'),
('view reports', 'web'),
('manage settings', 'web');

-- ============================================
-- SEED DATA: Role-Permission Relationships
-- ============================================
-- Administrator has all permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 1, id FROM permissions;

-- Doctor permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 2, id FROM permissions WHERE name IN (
  'view patients', 'view patient details', 'create patient', 'edit patient',
  'view appointments', 'create appointment',
  'view medical records', 'create medical record', 'edit medical record',
  'view dashboard'
);

-- Nurse permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 3, id FROM permissions WHERE name IN (
  'view patients', 'view patient details',
  'view appointments', 'create appointment', 'edit appointment',
  'view medical records', 'create medical record',
  'view dashboard'
);

-- Pharmacist permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 4, id FROM permissions WHERE name IN (
  'view patients', 'view patient details',
  'view medical records',
  'view dashboard'
);

-- NHIS Officer permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 6, id FROM permissions WHERE name IN (
  'view nhis members', 'register nhis member', 'edit nhis member', 'approve membership',
  'view claims', 'view patients', 'view dashboard'
);

-- Finance Officer permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 7, id FROM permissions WHERE name IN (
  'view claims', 'approve claim', 'reject claim',
  'view dashboard', 'view patients'
);

-- Patient permissions
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`)
SELECT 5, id FROM permissions WHERE name IN (
  'view appointments', 'view medical records', 'view dashboard'
);

-- ============================================
-- SEED DATA: Healthcare Facilities
-- ============================================
INSERT INTO `healthcare_facilities` (`facility_code`, `facility_name`, `facility_type`, `region`, `district`, `town`, `address`, `phone`, `nhis_accredited`, `accreditation_number`, `license_number`) VALUES
('KTH001', 'Kumasi Teaching Hospital', 'Hospital', 'Ashanti', 'Kumasi', 'Kumasi', 'Kumasi Teaching Hospital, Ashanti Region', '0312-234567', true, 'ACC-2023-001', 'LIC-2023-001'),
('KBT001', 'Korle Bu Teaching Hospital', 'Hospital', 'Greater Accra', 'Accra', 'Accra', 'Korle Bu Teaching Hospital, Accra', '0213-456789', true, 'ACC-2023-002', 'LIC-2023-002'),
('CCA001', 'City Clinic Accra', 'Clinic', 'Greater Accra', 'Accra', 'Accra', 'City Clinic, Independence Avenue, Accra', '0201-234567', true, 'ACC-2023-003', 'LIC-2023-003'),
('TRH001', 'Tamale Regional Hospital', 'Hospital', 'Northern', 'Tamale', 'Tamale', 'Tamale Regional Hospital, Northern Region', '0371-123456', true, 'ACC-2023-004', 'LIC-2023-004'),
('CCR001', 'Cape Coast Regional Hospital', 'Hospital', 'Central', 'Cape Coast', 'Cape Coast', 'Cape Coast Regional Hospital, Central Region', '0342-123456', true, 'ACC-2023-005', 'LIC-2023-005');

-- ============================================
-- SEED DATA: Users (Test Accounts)
-- ============================================
INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `password`, `employee_id`, `department`, `facility_id`, `status`) VALUES
('Admin', 'User', 'admin@ghospital.gov.gh', '0501234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ORZx0S3j1r8fj2Lm', 'EMP-001', 'Administration', 1, 'active'),
('Dr. Kwame', 'Mensah', 'doctor@ghospital.gov.gh', '0502234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ORZx0S3j1r8fj2Lm', 'EMP-002', 'Medicine', 1, 'active'),
('Nurse', 'Kofi', 'nurse@ghospital.gov.gh', '0503234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ORZx0S3j1r8fj2Lm', 'EMP-003', 'Nursing', 1, 'active'),
('Officer', 'Ama', 'nhis@ghospital.gov.gh', '0504234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ORZx0S3j1r8fj2Lm', 'EMP-004', 'NHIS', 1, 'active'),
('Finance', 'Officer', 'finance@ghospital.gov.gh', '0505234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ORZx0S3j1r8fj2Lm', 'EMP-005', 'Finance', 1, 'active');

-- ============================================
-- SEED DATA: Model Has Roles (Assign Roles to Users)
-- ============================================
-- User 1 (Admin) -> Administrator role
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (1, 1, 'App\\Models\\User');
-- User 2 (Doctor) -> Doctor role
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (2, 2, 'App\\Models\\User');
-- User 3 (Nurse) -> Nurse role
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (3, 3, 'App\\Models\\User');
-- User 4 (NHIS Officer) -> NHIS Officer role
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (6, 4, 'App\\Models\\User');
-- User 5 (Finance Officer) -> Finance Officer role
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (7, 5, 'App\\Models\\User');

-- ============================================
-- Database initialization complete
-- ============================================
-- Total:
-- - 8 tables created
-- - 7 roles defined
-- - 24+ permissions configured
-- - 5 healthcare facilities seeded
-- - 5 user accounts created
-- - All relationships established
-- ============================================
