@extends('layout.main')

@section('css')
    {{-- @vite('/resources/css/login.css') --}}
@endsection

@section('body_content')

    <body>
        @include('layout.top_menu')

        <main>
            <div class="row justify-content-between">
                {{-- TO DO DIV --}}
                <div class="col-6 border-end pe-4">
                    <div class="d-flex align-items-end">
                        <h4>To Dos</h4>

                        <button id="btn_open_modal_add_to_do" class="btn btn-main ms-3">
                            <i class="fa-solid fa-plus"></i> New
                        </button>
                    </div>

                    <div class="mt-2" style="overflow-y: auto; max-height: 60vh;">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="shadow-sm text-nowrap" style="position: sticky; top: 0px;">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Due date</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody id="tbody_to_do" style="cursor: pointer"></tbody>
                        </table>
                    </div>
                </div>

                {{-- RECURRING TASKS DIV --}}
                <div class="col-6 ps-4">
                    <div class="d-flex align-items-end">
                        <h4>Recurring Tasks</h4>

                        <button id="btn_open_modal_add_task" class="btn btn-main ms-3">
                            <i class="fa-solid fa-plus"></i> New
                        </button>
                    </div>

                    <div class="mt-2" style="overflow-y: auto; max-height: 60vh;">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="shadow-sm text-nowrap" style="position: sticky; top: 0px;">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Time</th>
                                    <th class="text-center">Recurring Date</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_recurring_task" style="cursor: pointer"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>


        {{-- MODAL ADD TO DO --}}
        <div id="modal_add_to_do" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add a to do</h4>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="d-flex">
                            <div class="col-9 pe-4">
                                <label for="">Description</label>
                                <input id="description_modal_add_to_do" class="form-control mt-1 input-modal-add-to-do"
                                    placeholder="Insert to do description">
                            </div>

                            <div class="col-3">
                                <label for="">Due Date</label>
                                <input id="date_modal_add_to_do" class="form-control mt-1 input-modal-add-to-do"
                                    type="date">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span id="msg_error_modal_add_to" class="text-danger"></span>

                        <button id="save_modal_add_to_do" class="btn btn-main">Save changes</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- MODAL ADD TASK --}}
        <div id="modal_add_task" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add a Recurring Task</h4>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="d-flex">
                            <div class="col-9 pe-4">
                                <label for="description_modal_add_task">Description</label>
                                <input id="description_modal_add_task" class="form-control mt-1 input-modal-add-task"
                                    placeholder="Insert to do description">
                            </div>

                            <div class="col-3">
                                <label for="type_modal_add_task">Type of task</label>
                                <select id="type_modal_add_task" class="form-control mt-1">
                                    <option value="DAILY">Daily</option>
                                    <option value="WEEKLY">Weekly</option>
                                    <option value="MONTHLY">Monthly</option>
                                </select>
                            </div>
                        </div>

                        <div id="div_daily_add_task" style="display: none;">
                            <div class="d-flex mt-3">
                                <div class="col-3">
                                    <label for="daily_time_modal_add_task">Time</label>
                                    <input id="daily_time_modal_add_task" class="form-control mt-1 input-modal-add-task"
                                        type="time">
                                </div>
                            </div>
                        </div>

                        <div id="div_weekly_add_task" class="mt-3" style="display: none;">
                            @php $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; @endphp
                            @for ($weekday = 1; $weekday <= 7; $weekday++)
                                <div class="col-5 mt-1">
                                    <div class="input-group">
                                        <span class="col-4 input-group-text">{{ $weekdays[$weekday - 1] }}</span>
                                        <input class="form-control input-modal-add-task input-weekly-modal-add-task"
                                            type="time" data-weekday="{{ $weekday }}" disabled>

                                        <button class="btn btn-main btn-weekly-add-task">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div id="div_monthly_add_task" style="display: none;">
                            <div class="d-flex mt-3">
                                <div class="col-3 pe-4">
                                    <label for="monthly_day_modal_add_task">Recurring Day</label>
                                    <select id="monthly_day_modal_add_task"
                                        class="form-control mt-1 input-modal-add-task">
                                        @for ($dia = 1; $dia <= 31; $dia++)
                                            <option value="{{ $dia }}">{{ $dia }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label for="monthly_time_modal_add_task">Time</label>
                                    <input id="monthly_time_modal_add_task" class="form-control mt-1 input-modal-add-task"
                                        type="time">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span id="msg_error_modal_add_task" class="text-danger"></span>

                        <button id="save_modal_add_task" class="btn btn-main">Save changes</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- MODAL EDIT TO DO --}}
        <div id="modal_edit_to_do" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit to do: <small id="title_modal_edit_to_do">asdasd</small></h4>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input id="id_modal_edit_to_do" type="hidden">

                        <div class="d-flex">
                            <div class="col-9 pe-4">
                                <label for="">Description</label>
                                <input id="description_modal_edit_to_do" class="form-control mt-1 input-modal-edit-to-do"
                                    placeholder="Insert to do description">
                            </div>

                            <div class="col-3">
                                <label for="">Due Date</label>
                                <input id="date_modal_edit_to_do" class="form-control mt-1 input-modal-edit-to-do"
                                    type="date">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span id="msg_error_modal_edit_to" class="text-danger" style="display: none;"></span>

                        <button id="save_modal_edit_to_do" class="btn btn-main">Save changes</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- MODAL EDIT TASK --}}
        <div id="modal_edit_task" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Recurring Task: <small id="title_modal_edit_task"></small></h4>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input id="id_modal_edit_task" type="hidden">

                        <div class="d-flex">
                            <div class="col-9 pe-4">
                                <label for="description_modal_edit_task">Description</label>
                                <input id="description_modal_edit_task" class="form-control mt-1 input-modal-edit-task"
                                    placeholder="Insert to do description">
                            </div>

                            <div class="col-3">
                                <label for="type_modal_edit_task">Type of task</label>
                                <select id="type_modal_edit_task" class="form-control mt-1" disabled>
                                    <option value="DAILY">Daily</option>
                                    <option value="WEEKLY">Weekly</option>
                                    <option value="MONTHLY">Monthly</option>
                                </select>
                            </div>
                        </div>

                        <div id="div_daily_edit_task" style="display: none;">
                            <div class="d-flex mt-3">
                                <div class="col-3">
                                    <label for="daily_time_modal_edit_task">Time</label>
                                    <input id="daily_time_modal_edit_task" class="form-control mt-1 input-modal-edit-task"
                                        type="time">
                                </div>
                            </div>
                        </div>

                        <div id="div_weekly_edit_task" class="mt-3" style="display: none;">
                            @php $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; @endphp
                            @for ($weekday = 1; $weekday <= 7; $weekday++)
                                <div class="col-5 mt-1">
                                    <div class="input-group">
                                        <span class="col-4 input-group-text">{{ $weekdays[$weekday - 1] }}</span>
                                        <input class="form-control input-modal-edit-task input-weekly-modal-edit-task"
                                            type="time" data-weekday="{{ $weekday }}" disabled>

                                        <button class="btn btn-main btn-weekly-edit-task">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div id="div_monthly_edit_task" style="display: none;">
                            <div class="d-flex mt-3">
                                <div class="col-3 pe-4">
                                    <label for="monthly_day_modal_edit_task">Recurring Day</label>
                                    <select id="monthly_day_modal_edit_task"
                                        class="form-control mt-1 input-modal-edit-task">
                                        @for ($dia = 1; $dia <= 31; $dia++)
                                            <option value="{{ $dia }}">{{ $dia }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label for="monthly_time_modal_edit_task">Time</label>
                                    <input id="monthly_time_modal_edit_task" class="form-control mt-1 input-modal-edit-task"
                                        type="time">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span id="msg_error_modal_edit_task" class="text-danger"></span>

                        <button id="save_modal_edit_task" class="btn btn-main">Save changes</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('js')
    @vite('resources/js/remind_me/to_do.js')
@endsection
