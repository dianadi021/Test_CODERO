<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <fieldset>
                        <legend class="text-xl font-semibold text-gray-800">
                            {{ __('Parameter Pencarian') }}
                        </legend>
                        <div class="w-full flex mb-4">
                            <div class="w-full sm:w-1/2 flex flex-wrap">
                                <form id="searchForm" onsubmit="search('submit')">
                                    <table class="w-full table-no-border">
                                        <tr class="align-baseline">
                                            <td>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Cari Berdasarkan
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <select name="params_type" class="w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200">
                                                    <option value="" selected disabled>Pilih Opsi...</option>
                                                    <option value="nama_project">Project</option>
                                                    <option value="nama_karyawan">Karyawan</option>
                                                    <option value="tanggal_project">Tanggal</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                                    <x-btn-customize-layout type="button" id="btnSearch" section="success" class="ms-4" onclick="search('submit')">
                                        {{ __('Cari') }}
                                    </x-btn-customize-layout>

                                    <x-btn-customize-layout type="reset" section="danger" class="ms-4" onclick="search('reset')">
                                        {{ __('Reset') }}
                                    </x-btn-customize-layout>
                                </form>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <button type="button" class="cursor-pointer inline-flex items-center px-4 py-2 bg-info border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-info focus:bg-info active:bg-info focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="popUpModalExecAction('add')">Tambah Data</button>

                <div class="mt-6 overflow-x-auto">
                    <div class="tabs">
                        <div class="flex border-b">
                            <button id="header-project" class="tab-header px-4 py-2 text-lg font-medium focus:outline-none bg-gray-100" data-tab-target="project">
                                Project
                            </button>
                        </div>

                        <!-- Tab Contents -->
                        <div id="tab_project" class="tab-content px-4 py-2 text-gray-700">
                            <table id="projectTable" class="cek_datatables_content min-w-full table-auto table-text-center-number">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">{{ __('No') }}</th>
                                        <th class="px-4 py-2">{{ __('Project Name') }}</th>
                                        <th class="px-4 py-2">{{ __('Client') }}</th>
                                        <th class="px-4 py-2">{{ __('Project Leader') }}</th>
                                        <th class="px-4 py-2">{{ __('Start') }}</th>
                                        <th class="px-4 py-2">{{ __('End') }}</th>
                                        <th class="px-4 py-2">{{ __('Progress') }}</th>
                                        <th class="px-4 py-2">{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Background -->
    <div id="projectPopUp" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-lg font-semibold mb-4">Project Details</h2>
            <div id="popUpContent">
                <div class="mt-4">
                    <input type="hidden" id="project_id" name="id" />
                    <form id="ProjectFormPupUpModal" onsubmit="simpanProject('ProjectFormPupUpModal')" enctype="multipart/form-data">
                        <table class="table-no-border">
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Project
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="project_name" name="project_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="leader_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                        Leader Photo
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="file" id="leader_photo" name="leader_photo" class="w-full p-2 border rounded-md" accept="image/*" />
                                    <input type="hidden" id="old_leader_photo" name="old_leader_photo" />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_lead" class="block text-sm font-medium text-gray-700 mb-2">
                                        Project Leader
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="project_lead" name="project_lead" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-capitalize-input" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Client
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="client_name" name="client_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_progress" class="block text-sm font-medium text-gray-700 mb-2">
                                        Project Progress
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <div class="flex items-baseline" x-data="{ value_project_progress: 50 }">
                                        <input id="project_progress" name="project_progress" type="range" id="slider" x-model="value_project_progress" min="0" max="100" class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-blue-600" required />
                                        <div class="text-center font-semibold text-blue-600"><span x-text="value_project_progress" id="value_project_progress"></span>%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Start
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="start_date" name="start_date" class="datepicker border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm cursor-pointer" required readonly />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        End
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="end_date" name="end_date" class="datepicker border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm cursor-pointer" required readonly />
                                </td>
                            </tr>
                        </table>
                        <div class="flex items-center justify-end mt-4 gap-10">
                            <button type="submit" class="hideBtnProcess inline-flex items-center px-4 py-2 bg-success border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-success focus:bg-success active:bg-success focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Simpan</button>
                            <button type="reset" class="hideBtnProcess inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer ms-3">Reset</button>
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer" onclick="popUpModalExecAction('close')">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(async function() {
            (async function() {
                const $modalSlotContent = `
                <div class="mt-4">
                    <form id="ProjectForm" onsubmit="simpanProject('ProjectForm')" enctype="multipart/form-data">
                        <table class="table-no-border">
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Project
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="project_name" name="project_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_lead" class="block text-sm font-medium text-gray-700 mb-2">
                                        Leader Photo
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="file" id="leader_photo" name="leader_photo" class="w-full p-2 border rounded-md" accept="image/*">
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_lead" class="block text-sm font-medium text-gray-700 mb-2">
                                        Project Leader
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="project_lead" name="project_lead" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-capitalize-input" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Client
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="client_name" name="client_name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="project_progress" class="block text-sm font-medium text-gray-700 mb-2">
                                        Project Progress
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <div class="flex items-baseline" x-data="{ val_project_progress: 50 }">
                                        <input id="project_progress" name="project_progress" type="range" id="slider" x-model="val_project_progress" min="0" max="100" class="w-full h-2 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-blue-600" required />
                                        <div class="text-center font-semibold text-blue-600"><span x-text="val_project_progress"></span>%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Start
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="start_date" name="start_date" class="datepicker border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm cursor-pointer" required readonly />
                                </td>
                            </tr>
                            <tr class="align-baseline">
                                <td>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        End
                                    </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="end_date" name="end_date" class="datepicker border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm cursor-pointer" required readonly />
                                </td>
                            </tr>
                        </table>
                        <button id="btnReset" type="reset" class="hidden"></button>
                        <button id="btnSubmit" type="submit" class="hidden"></button>
                    </form>
                </div>
                `;
                await CreatePopUpModal("#Project_container", "ProjectModal", "ProjectForm", ["execFormProject('submit')", "execFormProject('reset')"], $modalSlotContent, ["Tambah Data", "Simpan", "Reset", "Tutup"], ["Form Tambah Data"], null, { btn: true });
            })();

            // Functions event onclick start
            $('.tab-header').on('click', async function() {
                const $target = $(this).data('tab-target');
                $('.tab-content').addClass('hidden');
                $(`#tab_${$target}`).removeClass('hidden');

                $('.tab-header').removeClass('bg-gray-100');
                $(this).addClass('bg-gray-100');

                $(`#${$target}Table`).show();
                const $coloumnsArray = tableFormat($target);

                await ContentLoaderDataTable(`/api/search?get_data=${$target}`, `#${$target}Table`, $coloumnsArray);
            });

            $(".datepicker").datetimepicker({
                timepicker: false,
                format: 'd-m-Y',
                scrollMonth: false,
                scrollInput: false
            });

            $(".datepicker").on("change", function () {
                let startDate = moment($("#start_date").val(), "DD-MM-YYYY", true);
                let endDate = moment($("#end_date").val(), "DD-MM-YYYY", true);

                if (!startDate.isValid() || !endDate.isValid()) {
                    return;
                }

                if (endDate.isBefore(startDate)) {
                    AllNotify("Tanggal akhir harus lebih besar dari tanggal awal!", "error");
                    $("#end_date").val("");
                }
            });
            // Functions event onclick end
        });

        function tableFormat($target) {
            const $coloumnsArray = [{ data: null, render: (data, type, row, meta) => meta.row + 1 }];

            if ($target == 'project') {
                $coloumnsArray.push({ data: 'project_name' }, { data: 'client_name' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <div class="flex items-center space-x-3">
                                <img src="${$base_url}/${row.leader_photo}" class="w-10 h-10 rounded-full border border-gray-300">
                                <span>${row.project_lead}</span>
                            </div>
                        `;
                    }
                }, { data: 'start_date' }, { data: 'end_date' },
                {
                    data: 'project_progress',
                    render: function(data, type, row) {
                        return `
                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="bg-blue-500 h-4 rounded-full transition-all" style="width: ${data}%;"></div>
                            </div>
                            <span class="text-sm font-semibold">${data}%</span>
                        `;
                    }
                });
            }

            $coloumnsArray.push({
                data: null,
                orderable: false,
                searchable: false,
                render: (data) =>
                    `<div class='flex gap-1 justify-center'>
                        <button class='inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning focus:bg-warning active:bg-warning focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' onclick="popUpModalExecAction('edit', '${data.id}')">Edit</button>
                        <button class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' onclick="popUpModalExecAction('delete', '${data.id}')">Hapus</button>
                    </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            });

            return $coloumnsArray;
        }

        // Functions event onclick start
        async function search($method) {
            if ($method == 'reset') {
                localStorage.removeItem("search_params");

                $(".check_form_search").each(function() {
                    $(this).val("");
                })

                $(".cek_datatables_content").each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().destroy();
                        $(this).hide();
                    }
                })
            }

            if ($method == 'submit') {
                const $formArray = $("#searchForm").serializeArray();

                let $getData = '';
                const $listID = [];
                Object.values($formArray).forEach(function ($list) {
                    const { name, value } = $list;
                    if (name.includes("id_") && !name.includes("params_type") && IsValidVal(value)) {
                        $listID.push(`${name}=${value}`);
                    }
                    if (name.includes("params_type") && IsValidVal(value)) {
                        $getData = `${value}`;
                    }
                });

                const $target = IsValidVal($listID) ? $listID[$listID.length - 1].replace("id_", "").split("=")[0] : null;
                const $params = IsValidVal($listID) && $listID.length > 1 ? $listID.join("&") : $listID;
                const $coloumnsArray = tableFormat($getData);

                $('.tab-header').each(function() {
                    $('.tab-content').addClass('hidden');
                    $(`#tab_${$getData}`).removeClass('hidden');

                    $('.tab-header').removeClass('bg-gray-100');
                    $(`#header-${$getData}`).addClass('bg-gray-100');
                });

                if ($.fn.DataTable.isDataTable(`#${$getData}Table`)) {
                    $(`#${$getData}Table`).DataTable().destroy();
                }

                $(`#${$getData}Table`).show();
                await ContentLoaderDataTable(`/api/search?get_data=${$getData}&${$params}`, `#${$getData}Table`, $coloumnsArray);
            }
        }

        async function simpanProject($formID) {
            event.preventDefault();

            Swal.fire({
                title: "Apakah yakin ingin melanjutkan?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Lanjutkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                    $("#loadingAjax").show();
                    $(".hideBtnProcess").hide();
                    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                    let formData = document.getElementById($formID);
                    formData = new FormData(formData);

                    const $id_data = $("#project_id").val();
                    console.log($("#project_id").length);
                    console.log($("#project_id"));
                    console.log($id_data);
                    const $url = $id_data ? `${$base_url}/api/projects/${$id_data}` : `${$base_url}/api/projects`;

                    if ($id_data) {
                        formData.append('_method', 'PUT');
                    }

                    $.ajax({
                        url: `${$url}`,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhrFields: {
                            withCredentials: true
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(callback) {
                            const { message } = callback;
                            console.dir('success', callback);
                            toastr.success(message, "Success!");

                            $("#loadingAjax").hide();
                            $(".hideBtnProcess").show();

                            if ($.fn.DataTable.isDataTable(`#projectTable`)) {
                                $('#projectTable').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(callback) {
                            const { responseJSON } = callback;
                            const { errors, message, messages, datas } = responseJSON;
                            let errorInfo, validator;
                            if (datas) {
                                const { errorInfo: errInfo, validator: validCallback } = datas
                                errorInfo = errInfo;
                                validator = validCallback;
                            }
                            console.dir('error', callback);

                            const $tmpErrLoop = datas || errors;
                            if ($tmpErrLoop) {
                                for (let key in $tmpErrLoop) {
                                    AllNotify($tmpErrLoop[key][0], "error");
                                    $(`#err_${key}`).show();
                                }
                            } else if (message || messages || errorInfo || validator) {
                                const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                AllNotify($txtMsgAlert, "error");
                            }

                            $("#loadingAjax").hide();
                            $(".hideBtnProcess").show();
                        },
                    });
                }
            });
        }

        function execFormProject($exec) {
            if ($exec == "submit") {
                $("#btnSubmit").click();
            }
            if ($exec == "reset") {
                $("#btnReset").click();
            }
        }

        function fillFormData(data) {
            $("#ProjectFormPupUpModal input, #ProjectFormPupUpModal select, #ProjectFormPupUpModal textarea").each(function () {
                let name = $(this).attr("name");
                if (name === "leader_photo") {
                    if (data[name]) {
                        $("#old_leader_photo").val(data[name]);
                    }
                } else {
                    if (data[name] !== undefined) {
                        $(this).val(data[name]);

                        if ($(this).attr("name") == "project_progress") {
                            $("#value_project_progress").html(data[name]);
                        }
                    }
                }
            });

            $("#project_id").val(data.id);
        }

        async function popUpModalExecAction($action, $id = null) {
            if ($action == "close") {
                if ($.fn.DataTable.isDataTable(`#projectTable`)) {
                    $('#projectTable').DataTable().ajax.reload(null, false);
                }

                $("#projectPopUp").hide();
            }
            if ($action == "add") {
                $("#project_id").val("");

                $("#projectPopUp").show();
            }
            if ($action == "edit") {
                $.ajax({
                    url: `${$base_url}/api/projects/${$id}`,
                    type: "GET",
                    processData: false,
                    contentType: false,
                    xhrFields: {
                        withCredentials: true
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(callback) {
                        const { message, datas } = callback;
                        console.dir('success', callback);
                        toastr.success(message, "Success!");

                        fillFormData(datas);

                        $("#loadingAjax").hide();
                        $(".hideBtnProcess").show();

                        $("#projectPopUp").show();
                    },
                    error: function(callback) {
                        const { responseJSON } = callback;
                        const { errors, message, messages, datas } = responseJSON;
                        let errorInfo, validator;
                        if (datas) {
                            const { errorInfo: errInfo, validator: validCallback } = datas
                            errorInfo = errInfo;
                            validator = validCallback;
                        }
                        console.dir('error', callback);

                        const $tmpErrLoop = datas || errors;
                        if ($tmpErrLoop) {
                            for (let key in $tmpErrLoop) {
                                AllNotify($tmpErrLoop[key][0], "error");
                                $(`#err_${key}`).show();
                            }
                        } else if (message || messages || errorInfo || validator) {
                            const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                            AllNotify($txtMsgAlert, "error");
                        }

                        $("#loadingAjax").hide();
                        $(".hideBtnProcess").show();
                    },
                });
            }
            if ($action == "delete") {
                Swal.fire({
                    title: "Apakah yakin ingin menghapus data?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Batal",
                    confirmButtonText: "Lanjutkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                        $("#loadingAjax").show();
                        $(".hideBtnProcess").hide();
                        toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                        $.ajax({
                            url: `${$base_url}/api/projects/${$id}`,
                            type: "DELETE",
                            processData: false,
                            contentType: false,
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const { message } = callback;
                                console.dir('success', callback);
                                toastr.success(message, "Success!");

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();

                                if ($.fn.DataTable.isDataTable(`#projectTable`)) {
                                    $('#projectTable').DataTable().ajax.reload(null, false);
                                }
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, datas } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const { errorInfo: errInfo, validator: validCallback } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                const $tmpErrLoop = datas || errors;
                                if ($tmpErrLoop) {
                                    for (let key in $tmpErrLoop) {
                                        AllNotify($tmpErrLoop[key][0], "error");
                                        $(`#err_${key}`).show();
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                    AllNotify($txtMsgAlert, "error");
                                }

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();
                            },
                        });
                    }
                });
            }
        }
        // Functions event onclick end
    </script>
</x-dynamic-layout>
