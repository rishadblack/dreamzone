<?php

namespace App\Traits;

use App\Models\User;

trait UserTrait
{
    public function getIdByUsername($username)
    {
        $User = User::whereUsername($username)->first('id');

        return $User ? $User['id'] : false;
    }

    public function getUsernameById($id)
    {
        $User = User::select('username')->find($id);

        return $User ? $User['username'] : false;
    }

    public function getUserByUsername($username)
    {
        $User = User::whereUsername($username)->first();

        return $User ? $User : false;
    }
}
