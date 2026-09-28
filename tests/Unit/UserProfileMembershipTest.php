<?php

namespace Tests\Unit;

use App\Models\UserProfileModel;
use PHPUnit\Framework\TestCase;

class UserProfileMembershipTest extends TestCase
{
    public function test_membership_profile_is_complete_when_all_required_fields_exist(): void
    {
        $profile = new UserProfileModel([
            'name' => 'Budi',
            'phone' => '08123456789',
            'gender' => 1,
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Bankir No. 1',
            'provinsi_id' => 1,
            'kota_id' => 2,
            'kecamatan_id' => 3,
            'kelurahan_id' => 4,
        ]);

        $this->assertTrue($profile->hasCompleteMembershipProfile());
    }

    public function test_membership_profile_is_incomplete_when_a_required_field_is_missing(): void
    {
        $profile = new UserProfileModel([
            'name' => 'Budi',
            'phone' => '08123456789',
            'gender' => 1,
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Bankir No. 1',
            'provinsi_id' => 1,
            'kota_id' => 2,
            'kecamatan_id' => 3,
        ]);

        $this->assertFalse($profile->hasCompleteMembershipProfile());
    }

    public function test_country_code_without_subscriber_number_is_incomplete(): void
    {
        $profile = new UserProfileModel([
            'name' => 'Budi',
            'phone' => '62',
            'gender' => 1,
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Bankir No. 1',
            'provinsi_id' => 1,
            'kota_id' => 2,
            'kecamatan_id' => 3,
            'kelurahan_id' => 4,
        ]);

        $this->assertFalse($profile->hasCompleteMembershipProfile());
    }
}
