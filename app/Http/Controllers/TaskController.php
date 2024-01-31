<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\ToDoDaily;
use App\Models\ToDoMonthly;
use App\Models\ToDoWeekly;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }


        $toDo = new ToDo();

        try {
            $toDo->user_id = Auth::user()->id;
            $toDo->description = $request->description;
            $toDo->type = $request->type;
            $toDo->save();


            if ($toDo->type == 'DAILY') {
                $daily = new ToDoDaily();
                $daily->to_do_id = $toDo->id;
                $daily->time = $request->daily_time;
                $daily->save();
            }

            if ($toDo->type == 'WEEKLY') {
                foreach ($request->weekly_array as $value) {
                    $weekly = new ToDoWeekly();
                    $weekly->to_do_id = $toDo->id;
                    $weekly->weekday = $value["weekday"];
                    $weekly->time = $value["time"];
                    $weekly->save();
                }
            }

            if ($toDo->type == 'MONTHLY') {
                $monthly = new ToDoMonthly();
                $monthly->to_do_id = $toDo->id;
                $monthly->day_of_month = $request->monthly_day;
                $monthly->time = $request->monthly_time;
                $monthly->save();
            }

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in recording']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in recording']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }

        $list = ToDo::show_task(Auth::user()->id);

        if (count($list) <= 0) {
            return response()->json(['status' => 'null', 'message' => 'No records found']);
        }


        foreach ($list as &$value) {
            $value["weekly_weekday"] = get_weekday($value["weekly_weekday"]);

            if ($value["monthly_day"] != null) {
                $value['task_id'] = $value["monthly_id"];
                $value["recurring_date"] = $value["monthly_day"] . "th";
                $value["time"] = substr($value["monthly_time"], 0, 5);
            } else if ($value["weekly_weekday"] != null) {
                $value['task_id'] = $value["weekly_id"];
                $value["recurring_date"] = $value["weekly_weekday"];
                $value["time"] = substr($value["weekly_time"], 0, 5);
            } else {
                $value['task_id'] = $value["daily_id"];
                $value["recurring_date"] = "-";
                $value["time"] = substr($value["daily_time"], 0, 5);
            }
        }


        return response()->json(['status' => 'ok', 'data' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }


        $toDo = ToDo::whereRaw("id = '$id'")->first();

        if ($toDo->type == 'DAILY') {
            $toDo->task = ToDoDaily::whereRaw("to_do_id = '$toDo->id'")->first();
        } else if ($toDo->type == 'WEEKLY') {
            $toDo->task = ToDoWeekly::whereRaw("to_do_id = '$toDo->id'")->get()->toArray();
        } else {
            $toDo->task = ToDoMonthly::whereRaw("to_do_id = '$toDo->id'")->first();
        }

        return response()->json(['status' => 'ok', 'data' => $toDo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }
        // return response()->json(['status' => 'error', 'request' => $request->all()]);

        $toDo = ToDo::whereRaw("id = '$request->to_do_id'")->first();

        try {
            $toDo->description = $request->description;
            $toDo->save();


            if ($toDo->type == 'DAILY') {
                $daily = ToDoDaily::whereRaw("to_do_id = '$request->to_do_id'")->first();
                $daily->time = $request->daily_time;
                $daily->save();
            }

            if ($toDo->type == 'WEEKLY') {
                foreach ($request->weekly_array as $value) {
                    $weekday = $value['weekday'];

                    if (isset($value['id']) && isset($value['time'])) {
                        $weekly = ToDoWeekly::whereRaw("to_do_id = '$request->to_do_id' AND weekday = '$weekday'")->first();
                        $weekly->weekday = $value["weekday"];
                        $weekly->time = $value["time"];
                        $weekly->save();
                    } else if (isset($value['time'])) {
                        $weekly = new ToDoWeekly();
                        $weekly->to_do_id = $request->to_do_id;
                        $weekly->weekday = $value["weekday"];
                        $weekly->time = $value["time"];
                        $weekly->save();
                    } else if (isset($value['id'])) {
                        $weekly = ToDoWeekly::whereRaw("to_do_id = '$request->to_do_id' AND weekday = '$weekday'")->first();
                        $weekly->delete();
                    }
                }
            }

            if ($toDo->type == 'MONTHLY') {
                $monthly = ToDoMonthly::whereRaw("to_do_id = '$request->to_do_id'")->first();
                $monthly->day_of_month = $request->monthly_day;
                $monthly->time = $request->monthly_time;
                $monthly->save();
            }

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in recording']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in recording']);
        }

        return response()->json(['status' => 'error', 'request' => $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
