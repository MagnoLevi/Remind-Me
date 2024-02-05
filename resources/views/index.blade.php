@extends('layout.main')

@section('css')
    {{-- @vite('/resources/css/login.css') --}}
@endsection

@section('body_content')

    <body>
        @include('layout.top_menu')

        <main>
            <div class="d-flex justify-content-end">
                <button id="btn_add_schedule" class="btn btn-lg btn-outline-main">
                    <i class="fa-solid fa-plus"></i>
                    <span>Schedule</span>
                </button>
            </div>


            {{-- DIV ADD SCHEDULE --}}
            <div id="div_add_schedule" class="mt-3" style="display: none">
                <div class="d-flex">
                    {{-- LEFT DIV --}}
                    <div class="col-6 pe-4 border-end">
                        <div class="col-3 d-flex align-items-center ms-auto">
                            <label for="">Date:</label>
                            <input id="date_add_schedule" class="form-control input-add-schedule ms-1" type="date"
                                max="{{ date('Y-m-d') }}">
                        </div>

                        <textarea id="notes_add_schedule" class="form-control input-add-schedule mt-1" rows="5" placeholder="Notes"></textarea>
                    </div>


                    {{-- RIGHT DIV --}}
                    <div class="col-6 ps-4">
                        <div class="d-flex align-items-center">
                            <h4>To Dos</h4>
                            <button id="" class="btn btn-main ms-2 mb-1">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> New
                            </button>
                        </div>

                        <div class="border border rounded-1 px-1 mt-1" style="max-height: 30vh; overflow-y: auto;">
                            <table class="table">
                                <thead class="sticky-top">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center">Due Date</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody_to_do_add_schedule"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end">
                    <button id="open_modal_confirm_add_schedule" class="btn btn-main mt-2">Save Changes</button>
                </div>

                <hr class="mt-5">
            </div>


            {{-- DIV SHOWING UR SCHEDULES --}}
            <div>
                <h3>Schedules</h3>
                <div style="max-height: 60vh; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Notes</th>
                                <th class="text-center">Date</th>
                                <th>To Dos</th>
                            </tr>
                        </thead>

                        <tbody id="tbody_schedule"></tbody>
                    </table>
                </div>
            </div>
        </main>


        {{-- MODAL CONFIRM ADD SCHEDULE --}}
        <div id="modal_confirm_add_schedule" class="modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Schedule</h4>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div id="msg_modal_confirm_add_schedule">
                            I dont know what to write here fuc
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span id="msg_error_modal_confirm_add_schedule" class="text-danger" style="display: none;"></span>
                        <button id="save_modal_confirm_add_schedule" class="btn btn-main">Confirm</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('js')
    @vite('resources/js/remind_me/index.js')
@endsection
