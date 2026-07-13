<?php

namespace Database\Seeders;

use App\Models\HealthcareFacility;
use Illuminate\Database\Seeder;

class HealthcareFacilitySeeder extends Seeder
{
    public function run()
    {
        $facilities = [
            [
                'facility_code' => 'GHSP-KUM-001',
                'facility_name' => 'Kumasi Teaching Hospital',
                'facility_type' => 'Hospital',
                'region' => 'Ashanti',
                'district' => 'Kumasi',
                'town' => 'Kumasi',
                'address' => 'Hospital Road, Kumasi',
                'phone' => '+233261000001',
                'email' => 'kumasi@hospital.gov.gh',
                'nhis_accredited' => true,
                'accreditation_number' => 'NHIS-KUM-001',
                'license_number' => 'LIC-KUM-001',
                'director_name' => 'Prof. Samuel Yaw Ankomah',
                'status' => 'active',
            ],
            [
                'facility_code' => 'GHSP-ACC-001',
                'facility_name' => 'Korle Bu Teaching Hospital',
                'facility_type' => 'Hospital',
                'region' => 'Greater Accra',
                'district' => 'Accra Metropolitan',
                'town' => 'Accra',
                'address' => 'P.O. Box 77, Korle Bu, Accra',
                'phone' => '+233302000001',
                'email' => 'kolebu@hospital.gov.gh',
                'nhis_accredited' => true,
                'accreditation_number' => 'NHIS-ACC-001',
                'license_number' => 'LIC-ACC-001',
                'director_name' => 'Prof. Ama Amponsah',
                'status' => 'active',
            ],
            [
                'facility_code' => 'GHSC-ACC-001',
                'facility_name' => 'City Clinic Accra',
                'facility_type' => 'Clinic',
                'region' => 'Greater Accra',
                'district' => 'Accra Metropolitan',
                'town' => 'Accra',
                'address' => 'Osu, Accra',
                'phone' => '+233303000001',
                'email' => 'cityclinic@clinic.gov.gh',
                'nhis_accredited' => true,
                'accreditation_number' => 'NHIS-ACC-002',
                'license_number' => 'LIC-ACC-002',
                'director_name' => 'Dr. John Smith',
                'status' => 'active',
            ],
            [
                'facility_code' => 'GHSP-TML-001',
                'facility_name' => 'Tamale Regional Hospital',
                'facility_type' => 'Hospital',
                'region' => 'Northern',
                'district' => 'Tamale Metropolitan',
                'town' => 'Tamale',
                'address' => 'Hospital Road, Tamale',
                'phone' => '+233372000001',
                'email' => 'tamale@hospital.gov.gh',
                'nhis_accredited' => true,
                'accreditation_number' => 'NHIS-TML-001',
                'license_number' => 'LIC-TML-001',
                'director_name' => 'Dr. Alhassan Abdul',
                'status' => 'active',
            ],
            [
                'facility_code' => 'GHSP-CPN-001',
                'facility_name' => 'Cape Coast Regional Hospital',
                'facility_type' => 'Hospital',
                'region' => 'Central',
                'district' => 'Cape Coast Metropolitan',
                'town' => 'Cape Coast',
                'address' => 'Pedu Road, Cape Coast',
                'phone' => '+233334000001',
                'email' => 'capeco@hospital.gov.gh',
                'nhis_accredited' => true,
                'accreditation_number' => 'NHIS-CPN-001',
                'license_number' => 'LIC-CPN-001',
                'director_name' => 'Dr. Margaret Adu',
                'status' => 'active',
            ],
        ];

        foreach ($facilities as $facility) {
            HealthcareFacility::firstOrCreate(
                ['facility_code' => $facility['facility_code']],
                $facility
            );
        }
    }
}
