<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\ToDoDaily;
use App\Models\ToDoMonthly;
use App\Models\ToDoWeekly;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return redirect()->intended("");
        }

        return view('to_do')->with('nav', 'to_do');
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
            $toDo->due_date = $request->due_date;
            $toDo->save();

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

        $list = ToDo::show(Auth::user()->id);

        if (count($list) <= 0) {
            return response()->json(['status' => 'null', 'message' => 'No records found']);
        }

        return response()->json(['status' => 'ok', 'data' => $list]);
    }

    /**
     * Display the specified resource.
     */
    public function show_available(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }

        $list = ToDo::show_available(Auth::user()->id);

        if (count($list) <= 0) {
            return response()->json(['status' => 'null', 'message' => 'No records found']);
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


        try {
            $toDo = ToDo::whereRaw("id = '$request->to_do_id'")->first();
            $toDo->description = $request->description;
            $toDo->due_date = $request->due_date;
            $toDo->save();

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in the update']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in the update']);
        }
    }

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
            $toDo = ToDo::whereRaw("id = '$request->to_do_id'")->first();
            $toDo->delete();

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in deleting record']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in deleting record']);
        }
    }
}
