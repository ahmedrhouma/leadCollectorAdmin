@extends('layouts.dashboard')
@section('title')
    Responders
@endsection
@section('content')
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"/>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Responder"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_responder_add_modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black"/>
                                <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black"/>
                                <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Add responder
                    </button>
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete
                        Selected
                    </button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">Responder name</th>
                    <th class="min-w-125px">Type</th>
                    <th class="min-w-125px">Status</th>
                    <th class="min-w-125px">Attached Channels</th>
                    <th class="min-w-125px">Created at</th>
                    <th class="min-w-70px">Actions</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody></tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <div class="modal fade" id="kt_responder_add_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add responder</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg>
                            </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="add_responder_form">
                        <div class="w-100">
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-bold mb-2">
                                    <span class="required">Responder Name</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify your unique responder name" aria-label="Specify your unique responder name"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-lg form-control-solid" name="name" placeholder="" value="">
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <div class="fv-row">
                                <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                    <span class="required">Responder Type</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Select your Responder Type" aria-label="Select your Responder Type"></i>
                                </label>
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="d-flex flex-stack mb-5 cursor-pointer">
                                        <!--begin:Label-->
                                        <span class="d-flex align-items-center me-2">
                                        <!--begin:Icon-->
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
                                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black"></path>
                                                        <path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bolder fs-6">Questions</span>
                                            <span class="fs-7 text-muted">Reply to received messages with questions</span>
                                        </span>
                                    </span>
                                        <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="type" value="1" checked>
                                    </span>
                                    </label>
                                    <label class="d-flex flex-stack mb-5 cursor-pointer">
                                    <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-danger">
                                                <span class="svg-icon svg-icon-1 svg-icon-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect x="2" y="2" width="9" height="9" rx="2" fill="black"></rect>
                                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black"></rect>
                                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black"></rect>
                                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black"></rect>
                                                    </svg>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bolder fs-6">Forms</span>
                                            <span class="fs-7 text-muted">Reply to received messages with form</span>
                                        </span>
                                    </span>
                                        <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="type" value="2">
                                    </span>
                                    </label>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="questions">
                                    <table id="kt_datatable_questions" class="table table-row-bordered table-row-dashed gy-5">
                                        <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
                                            <th>Message</th>
                                            <th>Wait response</th>
                                            <th>Field</th>
                                            <th>Order</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-primary addQuestion">Add Question
                                        </button>
                                    </div>
                                </div>
                                <div class="forms" style="display: none">
                                    <div class="fv-row mb-10 fv-plugins-icon-container">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2">
                                            <span class="required">Select Form</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Select form of responder" aria-label="Select form of responder"></i>
                                        </label>
                                        <select class="form-select form-select-solid" name="forms">
                                            <option value="1" selected="selected">form 1</option>
                                            <option value="2">form 2</option>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <span class="indicator-label">Submit
                                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black"></rect>
                                            <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src={{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}></script>

    <script>
        var statusList = {
            1: {"title": "Active", "state": "success"},
            0: {"title": "Disabled", "state": "info"},
        };
        var typeList = {
            1: {"title": "Questions", "state": "info"},
            2: {"title": "Forms", "state": "primary"},
        };
        var table = $('#kt_contacts_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('responders.paginate') }}",
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'status', name: 'status'},
                {data: 'channels_count', name: 'channels_count'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    sortable: false
                },
            ],
            columnDefs: [{
                "targets": -1,
                "render": function (id, type, row, meta) {
                    return '<a href="javascript:void(0)" class="show btn btn-outline-info btn-sm">Show</a>' +
                        '<a href="javascript:void(0)" class="edit btn btn-outline-info btn-sm">Edit</a>' +
                        '<a href="javascript:void(0)" class="delete btn btn-outline-danger btn-sm">Delete</a>';
                }
            }, {
                "targets": 1,
                "render": function (data, type, row, meta) {
                    return '<span class="ms-2 badge badge-light-' + typeList[data]['state'] + ' fw-bold">' + typeList[data]['title'] + '</span>';
                }
            }, {
                "targets": 2,
                "render": function (data, type, row, meta) {
                    return '<span class="ms-2 badge badge-light-' + statusList[data]['state'] + ' fw-bold">' + statusList[data]['title'] + '</span>';
                }
            }]
        });

        var questionsTable = $('#kt_datatable_questions').DataTable({
            ordering: false,
            paging: false,
            columnDefs: [
                {
                    "targets": [1, 3],
                    "className": "mw-20px"
                }, {
                    "targets": [2],
                    "className": "mw-30px"
                }, {
                    "targets": [0],
                    "className": "mw-150px"
                }, {
                    "targets": 0,
                    "render": function (id, type, row, meta) {
                        return '<textarea type="text" class="form-control  form-control-solid" name="message"/></textarea>';
                    }
                }, {
                    "targets": 1,
                    "render": function (data, type, row, meta) {
                        return "<div class=\"pt-3 form-check form-check-custom form-check-solid justify-content-center\">\n" +
                            "<input class=\"form-check-input\" type=\"checkbox\" name='response' checked=\"checked\">\n" +
                            "<label class=\"form-check-label\" for=\"flexCheckChecked\"></label>\n" +
                            "</div>";
                    }
                }, {
                    "targets": 2,
                    "render": function (data, type, row, meta) {
                        return "<select class=\"form-select  form-select-solid\" size=\"1\" name=\"field\">" +
                            "<option value=\"1\" selected=\"selected\">first name</option>" +
                            "<option value=\"2\">last name</option>" +
                            "<option value=\"3\">email</option>" +
                            "<option value=\"4\">phone number</option>" +
                            "<option value=\"5\">birthday</option>" +
                            "</select>";
                    }
                }, {
                    "targets": 3,
                    "render": function (data, type, row, meta) {
                        return '<input type="number" class="form-control  form-control-solid" name="order"/>';
                    }
                }]
        });
        $(document).on("click", ".addQuestion", function () {
            questionsTable.row.add([0, 0, 0, 0]).draw();
        });
        $('#add_responder_form').on('submit', function (e) {
            e.preventDefault();
            //if($('#add_responder_form').validate()){
            $.ajax({
                url: '{{ route('responders.add') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('[name="name"]').val(),
                    type: $('[name="type"]:checked').val(),
                    questions: questionsTable.$("input, select, textarea").serializeArray()
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Responder successfully added'
                        });
                        table.row.add(data.data).draw();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add Responder'
                        });
                    }
                }
            })
            //}
        });
        $(document).on('click', '.delete', function () {
            let row = table.row($(this).parents('tr'));
            let data = row.data();
            $.ajax({
                url: data.destoryUrl,
                method: 'delete',
                dataType: 'JSON',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Responder successfully deleted'
                        });
                        table.row(row).remove().draw();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete Responder'
                        });
                    }
                }
            })
        });
        $(document).on('change', 'input[name="type"]', function () {
            if ($('[name="type"]:checked').val() == 1) {
                $('.questions').show();
                $('.forms').hide();
            } else {
                $('.questions').hide();
                $('.forms').show();
            }
        });

    </script>
@endsection
