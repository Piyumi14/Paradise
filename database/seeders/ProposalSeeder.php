<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            for ($i = 1; $i <= 5; $i++) {
                // Insert user data
                $userId = DB::table('users')->insertGetId([
                    'user_uuid' => 'USER' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'first_name' => 'User' . $i,
                    'last_name' => 'LastName' . $i,
                    'email' => 'user' . $i . '@example.com',
                    'phone_number' => '71010101' . $i,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert user credential data
                DB::table('user_credentials')->insert([
                    'user_id' => $userId,
                    'username' => 'user' . $i,
                    'password' => 'mew_6UP1=eg0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert proposal data
                $proposalId = DB::table('proposals')->insertGetId([
                    'user_id' => $userId,
                    'reference_number' => 'PREF' . str_pad($i, 5, '0', STR_PAD_LEFT),
                    'first_name' => 'User' . $i,
                    'middle_name' => 'Middle' . $i,
                    'last_name' => 'LastName' . $i,
                    'preferred_name' => 'User Preferred' . $i,
                    'age' => 20 + $i,
                    'gender' => $i % 2 === 0 ? 'Female' : 'Male',
                    'phone_number' => '071010101' . $i,
                    'email' => 'user' . $i . '@example.com',
                    'height' => '5.' . $i,
                    'civil_status' => $i % 2 === 0 ? 'Single' : 'Separated',
                    'country_id' => "Sri Lanka",
                    'province_id' => "Southern Province",
                    'district_id' => "Matara",
                    'area' => 'Area' . $i,
                    'nationality' => 'Sri Lankan',
                    'religion' => $i % 2 === 0 ? 'Christianity' : 'Buddhism',
                    'cast' => $i % 2 === 0 ? 'Govigama' : 'Durawe',
                    'profile_description' => 'Description ' . $i,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert professional and educational data
                DB::table('qualifications')->insert([
                    'proposal_id' => $proposalId,
                    'occupation' => 'Occupation' . $i,
                    'industry' => 'Healthcare',
                    'company' => 'Company' . $i,
                    'salary_range' => '100000 - ' . (100000 + $i * 10000),
                    'highest_education' => 'Bachelor’s Degree',
                    'field_of_study' => 'Field' . $i,
                    'institution' => 'Institution' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert parents data
                DB::table('parents')->insert([
                    'proposal_id' => $proposalId,
                    'father_nationality' => 'Sri Lankan',
                    'father_religion' => $i % 2 === 0 ? 'Christianity' : 'Buddhism',
                    'father_cast' => $i % 2 === 0 ? 'Govigama' : 'Durawe',
                    'father_profession' => 'Profession Father' . $i,
                    'father_is_live' => true,
                    'mother_nationality' => 'Sri Lankan',
                    'mother_religion' => $i % 2 === 0 ? 'Christianity' : 'Buddhism',
                    'mother_cast' => $i % 2 === 0 ? 'Govigama' : 'Durawe',
                    'mother_profession' => 'Profession Mother' . $i,
                    'mother_is_live' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert siblings data
                $siblings = [
                    ['sibling_type' => 'Elder Brother', 'civil_status' => 'Married'],
                    ['sibling_type' => 'Younger Sister', 'civil_status' => 'Single'],
                ];
                foreach ($siblings as $sibling) {
                    DB::table('siblings')->insert([
                        'proposal_id' => $proposalId,
                        'sibling_type' => $sibling['sibling_type'],
                        'civil_status' => $sibling['civil_status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Insert horoscope data
                DB::table('horoscopes')->insert([
                    'proposal_id' => $proposalId,
                    'birth_date' => now()->subYears(30 + $i)->toDateString(),
                    'birth_time' => '0' . $i . ':30:15',
                    'birth_place' => 'Place' . $i,
                    'lagnaya' => $i % 2 === 0 ? 'Mesha' : 'Wrushamba',
                    'horoscope_details' => 'Details ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert gallery data
                $gallery = [
                    ['image_url' => 'images/user' . $i . '_1.jpg', 'is_main_photo' => true],
                    ['image_url' => 'images/user' . $i . '_2.jpg', 'is_main_photo' => false],
                ];
                foreach ($gallery as $image) {
                    DB::table('photos')->insert([
                        'proposal_id' => $proposalId,
                        'image_url' => $image['image_url'],
                        'is_main_photo' => $image['is_main_photo'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
