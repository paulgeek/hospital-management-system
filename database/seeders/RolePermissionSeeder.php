<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => 'web']);
        $doctor = Role::firstOrCreate(['name' => 'Doctor', 'guard_name' => 'web']);
        $nurse = Role::firstOrCreate(['name' => 'Nurse', 'guard_name' => 'web']);
        $pharmacist = Role::firstOrCreate(['name' => 'Pharmacist', 'guard_name' => 'web']);
        $patient = Role::firstOrCreate(['name' => 'Patient', 'guard_name' => 'web']);
        $nhis_officer = Role::firstOrCreate(['name' => 'NHIS Officer', 'guard_name' => 'web']);
        $finance = Role::firstOrCreate(['name' => 'Finance Officer', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            // Dashboard
            'view-dashboard',
            
            // User Management
            'create-users',
            'view-users',
            'edit-users',
            'delete-users',
            
            // Patient Management
            'create-patients',
            'view-patients',
            'edit-patients',
            'delete-patients',
            'view-patient-records',
            
            // Healthcare Facilities
            'manage-facilities',
            'view-facilities',
            
            // Appointments
            'create-appointments',
            'view-appointments',
            'edit-appointments',
            'cancel-appointments',
            
            // Medical Records
            'create-medical-records',
            'view-medical-records',
            'edit-medical-records',
            
            // NHIS
            'manage-nhis',
            'create-nhis-members',
            'view-nhis-members',
            'edit-nhis-members',
            
            // Insurance Claims
            'create-claims',
            'view-claims',
            'approve-claims',
            'reject-claims',
            
            // Reports
            'view-reports',
            'export-reports',
            
            // Settings
            'manage-settings',
            'view-audit-log',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $admin->syncPermissions(Permission::all());
        
        $doctor->syncPermissions([
            'view-dashboard',
            'view-patients',
            'view-patient-records',
            'create-appointments',
            'view-appointments',
            'create-medical-records',
            'view-medical-records',
            'edit-medical-records',
            'view-reports',
        ]);

        $nurse->syncPermissions([
            'view-dashboard',
            'view-patients',
            'view-appointments',
            'create-medical-records',
            'view-medical-records',
        ]);

        $patient->syncPermissions([
            'view-dashboard',
            'view-patient-records',
            'view-appointments',
        ]);

        $nhis_officer->syncPermissions([
            'view-dashboard',
            'view-patients',
            'manage-nhis',
            'view-nhis-members',
            'edit-nhis-members',
            'view-claims',
            'view-reports',
        ]);

        $finance->syncPermissions([
            'view-dashboard',
            'view-claims',
            'approve-claims',
            'reject-claims',
            'view-reports',
            'export-reports',
        ]);
    }
}
