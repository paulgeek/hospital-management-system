<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@ghospital.gov.gh'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Account',
                'phone' => '+233244000000',
                'employee_id' => 'ADM001',
                'department' => 'Administration',
                'password' => Hash::make('Admin@123456'),
                'status' => 'active',
            ]
        );
        $admin->assignRole('Administrator');

        // Create test doctor
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@ghospital.gov.gh'],
            [
                'first_name' => 'Dr.',
                'last_name' => 'Mensah',
                'phone' => '+233244000001',
                'employee_id' => 'DOC001',
                'department' => 'Medical',
                'password' => Hash::make('Doctor@12345'),
                'status' => 'active',
            ]
        );
        $doctor->assignRole('Doctor');

        // Create test nurse
        $nurse = User::firstOrCreate(
            ['email' => 'nurse@ghospital.gov.gh'],
            [
                'first_name' => 'Nurse',
                'last_name' => 'Agyeman',
                'phone' => '+233244000002',
                'employee_id' => 'NUR001',
                'department' => 'Nursing',
                'password' => Hash::make('Nurse@12345'),
                'status' => 'active',
            ]
        );
        $nurse->assignRole('Nurse');

        // Create NHIS Officer
        $nhis = User::firstOrCreate(
            ['email' => 'nhis@ghospital.gov.gh'],
            [
                'first_name' => 'NHIS',
                'last_name' => 'Officer',
                'phone' => '+233244000003',
                'employee_id' => 'NHIS001',
                'department' => 'Insurance',
                'password' => Hash::make('NHIS@12345'),
                'status' => 'active',
            ]
        );
        $nhis->assignRole('NHIS Officer');

        // Create Finance Officer
        $finance = User::firstOrCreate(
            ['email' => 'finance@ghospital.gov.gh'],
            [
                'first_name' => 'Finance',
                'last_name' => 'Manager',
                'phone' => '+233244000004',
                'employee_id' => 'FIN001',
                'department' => 'Finance',
                'password' => Hash::make('Finance@12345'),
                'status' => 'active',
            ]
        );
        $finance->assignRole('Finance Officer');
    }
}
