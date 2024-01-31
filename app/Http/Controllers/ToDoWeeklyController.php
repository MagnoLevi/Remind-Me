<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\ToDoWeekly;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToDoWeeklyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }


        try {
            $weekly = ToDoWeekly::whereRaw("id = '$request->task_id'")->first();
            $weekly->delete();

            $weeklies = ToDoWeekly::whereRaw("to_do_id = '$weekly->to_do_id'")->get();

            if (count($weeklies) <= 0) {
                $toDo = ToDo::whereRaw("id = '$weekly->to_do_id'")->first();
                $toDo->delete();
            }

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in deleting record']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in deleting record']);
        }
    }
}
