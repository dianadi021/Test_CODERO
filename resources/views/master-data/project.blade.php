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
                                        <tr>
                                            <td>
                                                <label for="id_provinsi" class="block text-sm font-medium text-gray-700 mb-2"></label>
                                                    Kata Kunci
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <div></div>
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

                <div id="Project_container" x-cloak x-data="{ ProjectModal: false }" @click.outside="ProjectModal = false" @close.stop="ProjectModal = false"></div>

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

    <script>
        $(document).ready(async function() {
            (async function() {
                const $modalSlotContent = `
                <div class="mt-4">
                    <form id="ProjectForm" onsubmit="simpanProject()">
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
                    </form>
                </div>
                `;
                await CreatePopUpModal("#Project_container", "ProjectModal", "ProjectForm", "simpanProject()", $modalSlotContent, ["Tambah Data", "Simpan", "Reset", "Tutup"], ["Form Tambah Data"], null, { btn: true });
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
                $coloumnsArray.push({ data: 'project_name' }, { data: 'client_name' }, { data: 'project_lead' }, { data: 'project_progress' }, { data: 'start_date' }, { data: 'end_date' });
            }

            $coloumnsArray.push({
                data: null,
                orderable: false,
                searchable: false,
                render: (data) =>
                    `<div class='flex gap-1 justify-center'>
                        <button class='inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning focus:bg-warning active:bg-warning focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data-id='${data.id}'>Edit</button>
                        <button class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data-id='${data.id}'>Hapus</button>
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
        // Functions event onclick end
    </script>
</x-dynamic-layout>
