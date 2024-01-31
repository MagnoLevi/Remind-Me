<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;


    /**
     * Get user id by uuid_session
     * @param uuid $uuid_session
     * @return object
     */
    public static function get_user_id($uuid_session)
    {
        $query = self::selectRaw("users.id AS user_id")
            ->join("users", "users.id", "=", "user_sessions.user_id")
            ->whereRaw("uuid = '$uuid_session'");

        return $query->first()->user_id;
    }




    /**
     * Get user id by uuid_session
     * @param int $user_id
     * @return booolean
     */
    public static function check_session($user_id)
    {
        $login_date = date("Y-m-d H:i:s", strtotime("-3 hours"));

        $query = self::whereRaw("
            user_id = '$user_id'
            AND user_sessions.login_date > '$login_date'
        ");

        return $query->exists();
    }
}
