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

            {{-- DIV ADD --}}
            <div id="div_add_schedule" class="mt-3" style="display: none">
                <div class="d-flex">
                    {{-- LEFT DIV --}}
                    <div class="col-6 pe-4 border-end">
                        <div class="col-3 d-flex align-items-center ms-auto">
                            <label for="">Date:</label>
                            <input class="form-control ms-1" type="date" max="{{ date('Y-m-d') }}">
                        </div>

                        <textarea class="form-control mt-1" placeholder="Notes"></textarea>
                    </div>

                    {{-- RIGHT DIV --}}
                    <div class="col-6 ps-4">
                        <div class="d-flex align-items-center">
                            <h4>To Dos</h4>
                            <button id="" class="btn btn-main ms-2">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i> New
                            </button>
                        </div>

                        <div class="border border rounded-1 px-1 mt-1" style="max-height: 30vh; overflow-y: auto;">
                            <table class="table">
                                <thead class="sticky-top">
                                    <tr>
                                        <th>Description</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>

                                <tbody id="">
                                    <tr>
                                        <td>Desc</td>
                                        <td>2023/01/01</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-main mt-2">Save Changes</button>
                </div>
            </div>

        </main>

    </body>
@endsection

@section('js')
    @vite('resources/js/remind_me/index.js')
@endsection
