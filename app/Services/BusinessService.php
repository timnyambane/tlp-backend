<?php
namespace App\Services;

use App\Models\Service;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;

class BusinessService
{

    public function registerBusiness($validatedData)
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser($validatedData);
            $business = $this->createBusiness($user, $validatedData);
            $this->validateAndSyncServices($validatedData['services'], $validatedData['work_category_id'], $business);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createUser($data)
    {
        $fullName = explode(' ', $data['full_name']);
        $firstName = $fullName[0];
        $lastName = $fullName[1] ?? '';

        return User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => config('constants.roles.business'),
        ]);
    }

    private function createBusiness($user, $data): Business
    {
        return $user->business()->create([
            'location_id' => $data['location_id'],
            'work_category_id' => $data['work_category_id'],
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
    }

    private function validateAndSyncServices($serviceIds, $workCategoryId, $business)
    {
        $this->validateServices($serviceIds, $workCategoryId);

        $business->services()->sync($serviceIds);
    }

    private function validateServices($serviceIds, $workCategoryId)
    {
        $services = Service::whereIn('id', $serviceIds)
            ->where('work_category_id', $workCategoryId)
            ->get();

        if ($services->count() !== count($serviceIds)) {
            throw new \Exception('Some selected services do not belong to the same work category.');
        }
    }
}
