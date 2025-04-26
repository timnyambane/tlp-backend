<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerService
{

    public function registerCustomer($validatedData)
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser($validatedData);
            $this->createCustomer($user, $validatedData);

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
            'role' => config('constants.roles.customer'),
        ]);
    }
    private function createCustomer($user, $data)
    {
        return $user->customer()->create([
            'phone' => $data['phone'],
        ]);
    }
}
