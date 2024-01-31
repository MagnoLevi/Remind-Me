<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;


    /**
     * Get to do of the user
     * @return array
     */
    public static function show($user_id)
    {
        $query = self::selectRaw("
            id AS to_do_id,
            user_id,
            description,
            due_date,
            DATE_FORMAT(due_date, '%d/%m/%y') AS due_date_format
        ")
            ->whereRaw("type IS NULL")
            ->whereRaw("user_id = '$user_id'")
            ->orderByRaw("due_date");

        return $query->get()->toArray();
    }


    /**
     * Get user id by uuid_session
     * @return array
     */
    public static function show_task($user_id)
    {
        $query = self::selectRaw("
            to_dos.id AS to_do_id,
            to_dos.user_id,
            to_dos.description,
            to_dos.type,

            to_do_dailies.id AS daily_id,
            to_do_dailies.time AS daily_time,

            to_do_weeklies.id AS weekly_id,
            to_do_weeklies.weekday AS weekly_weekday,
            to_do_weeklies.time AS weekly_time,

            to_do_monthlies.id AS monthly_id,
            to_do_monthlies.day_of_month AS monthly_day,
            to_do_monthlies.time AS monthly_time
        ")
            ->leftJoin("to_do_dailies", "to_do_dailies.to_do_id", "=", "to_dos.id")
            ->leftJoin("to_do_weeklies", "to_do_weeklies.to_do_id", "=", "to_dos.id")
            ->leftJoin("to_do_monthlies", "to_do_monthlies.to_do_id", "=", "to_dos.id")
            ->whereRaw("type IS NOT NULL")
            ->whereRaw("user_id = '$user_id'")
            ->orderByRaw("to_dos.type, to_dos.description, to_do_weeklies.weekday");

        return $query->get()->toArray();
    }
}
