@extends('layouts.dashboard')
@section('title')
    Contacts List
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
                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black"/>
												</svg>
											</span>
                        <!--end::Svg Icon-->Filter
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-4 text-dark fw-bolder">Filter Options</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-bold mb-3">Month:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="month" data-dropdown-parent="#kt-toolbar-filter">
                                    <option></option>
                                    <option value="aug">August</option>
                                    <option value="sep">September</option>
                                    <option value="oct">October</option>
                                    <option value="nov">November</option>
                                    <option value="dec">December</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-bold mb-3">Payment Type:</label>
                                <!--end::Label-->
                                <!--begin::Options-->
                                <div class="d-flex flex-column flex-wrap fw-bold" data-kt-customer-table-filter="payment_type">
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked"/>
                                        <span class="form-check-label text-gray-600">All</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="visa"/>
                                        <span class="form-check-label text-gray-600">Visa</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="radio" name="payment_type" value="mastercard"/>
                                        <span class="form-check-label text-gray-600">Mastercard</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="payment_type" value="american_express"/>
                                        <span class="form-check-label text-gray-600">American Express</span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Options-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">
                                    Apply
                                </button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                    <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_contacts_export_modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black"/>
                                <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black"/>
                                <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Export
                    </button>
                    <!--end::Export-->
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
                    <th class="min-w-125px">First name</th>
                    <th class="min-w-125px">Last name</th>
                    <th class="min-w-125px">Email</th>
                    <th class="min-w-125px">Birthday</th>
                    <th class="min-w-125px">Country</th>
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
<div class="modal fade" id="contact" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact details</h5>
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
                <div class="card mb-6 mb-xl-9">
                    <!--begin::Header-->
                    <div class="card-header border-0 justify-content-center">
                        <div class="card-title">
                            <h2 class="fullname">ahmed ben rhouma</h2>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-0">
                        <div class="fs-5 fw-bold text-gray-500 mb-4 messageNbr text-center">Total messages : 150 message</div>
                        <!--begin::Left Section-->
                        <div class="d-flex flex-wrap flex-stack mb-5 profiles">
                            <!--begin::Row-->
                            <div class="text-center" style="">
                                <img src="../../assets/media/svg/brand-logos/google-icon.svg" class="w-30px" alt="" style=""><a href="#" class="d-block fs-5 text-dark text-hover-primary fw-bolder">Google</a>
                                <div class="fs-6 fw-bold text-muted">Facebook</div>
                            </div><div class="text-center" style="">
                                <img src="../../assets/media/svg/brand-logos/google-icon.svg" class="w-30px" alt="" style=""><a href="#" class="d-block fs-5 text-dark text-hover-primary fw-bolder">Google</a>
                                <div class="fs-6 fw-bold text-muted">Facebook</div>
                            </div><div class="text-center" style="">
                                <img src="../../assets/media/svg/brand-logos/google-icon.svg" class="w-30px" alt="" style=""><a href="#" class="d-block fs-5 text-dark text-hover-primary fw-bolder">Google</a>
                                <div class="fs-6 fw-bold text-muted">Facebook</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">First name</div>
                                <div class="text-gray-600 firstname">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Last name</div>
                                <div class="text-gray-600 lastname">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Birthday</div>
                                <div class="text-gray-600 birthday">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Gender</div>
                                <div class="text-gray-600 gender">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">City</div>
                                <div class="text-gray-600 city">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Country</div>
                                <div class="text-gray-600 country">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Ip address</div>
                                <div class="text-gray-600 ipaddress">ID-45453423</div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <div class="fw-bolder mt-5">Browser data</div>
                                <div class="text-gray-600 browser">ID-45453423</div>
                            </div>
                        </div>
                        <!--end::Left Section-->
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="kt_contacts_export_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Export Customers</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
														<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
													</svg>
												</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_customers_export_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                                <option value="excell">Excel</option>
                                <option value="pdf">PDF</option>
                                <option value="cvs">CVS</option>
                                <option value="zip">ZIP</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">Select Date Range:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Pick a date" name="date" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Row-->
                        <div class="row fv-row mb-15">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">Payment Type:</label>
                            <!--end::Label-->
                            <!--begin::Radio group-->
                            <div class="d-flex flex-column">
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked" name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-bold">All</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked" name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-bold">Visa</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="3" name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-bold">Mastercard</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="4" name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-bold">American Express</span>
                                </label>
                                <!--end::Radio button-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_customers_export_cancel" class="btn btn-light me-3">Discard</button>
                            <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@section('javascript')
    <script src={{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}></script>
    <script>
    $('[name="date"]').flatpickr({altInput:!0,altFormat:"F j, Y",dateFormat:"Y-m-d",mode:"range"});
        var table = $('#kt_contacts_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('contacts.paginate') }}",
            },
            columns: [
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'gender', name: 'gender'},
                {data: 'birthday', name: 'birthday'},
                {data: 'country', name: 'country'},
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false
                },
            ],
            columnDefs: [{
                "targets": -1,
                "render": function (id, type, row, meta) {
                    return '<a href="javascript:void(0)" class="show btn btn-outline-info btn-sm">Show</a>' +
                        '<a href="javascript:void(0)" class="edit btn btn-outline-info btn-sm">Edit</a>' +
                        '<a href="javascript:void(0)" class="delete btn btn-outline-danger btn-sm">Delete</a>';
                }
            }]
        });
        $('table tbody').on('click', '.show', function () {
            let data = table.row($(this).parents('tr')).data();
            $('.fullname').text(data.first_name+' '+data.last_name);
            $('.messagesNbr').text(data.messages);
            $('.firstname').text(data.first_name!== null?data.first_name:'Empty');
            $('.lastname').text(data.last_name!== null?data.last_name:'Empty');
            $('.birthday').text(data.birthday!== null?data.birthday:'Empty');
            $('.gender').text(data.gender!== null?data.gender:'Empty');
            $('.city').text(data.city!== null?data.city:'Empty');
            $('.country').text(data.country!== null?data.country:'Empty');
            $('.profiles').empty();
            if(data.profiles.length == 0){
                $('.profiles').append('<div class="text-center mx-auto" style="">No profile for this contact</div>');
            }
            $.each(data.profiles,function (index,item) {
                $('.profiles').append('<div class="text-center" style="">\n' +
                    '                                    <img src="../../assets/media/svg/brand-logos/google-icon.svg" class="w-30px" alt="" style=""><a href="#" class="d-block fs-5 text-dark text-hover-primary fw-bolder">'+item.name+'</a>\n' +
                    '                                    <div class="fs-6 fw-bold text-muted">'+item.media+'</div>')
            });
            $('.ipaddress').text(data.ip_address !== null?data.ip_address:'Empty');
            $('.browser').text(data.browser_data!== null?data.browser_data:'Empty');
            $('#contact').modal('show');
        });
        $('[data-kt-customer-table-filter="search"]').on('keyup', function () {
            table.search($(this).val()).draw();
        })
    </script>
@endsection
