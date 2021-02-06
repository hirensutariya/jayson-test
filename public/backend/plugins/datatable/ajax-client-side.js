"use strict";
var AjaxDatatablesClient = {

    init: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#kt_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/countries/getCountries",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "code"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/countries/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="country" data-url="' + APP_URL + "/countries/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';

                    }
                }
            ],
            'columnDefs': [ {
                'targets': [4],
                'orderable': false,
            }]


        });
        $('#state_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/states/getStates",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "country"},
                {"data": "name"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/states/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="state" data-url="' + APP_URL + "/states/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';
                    }
                }
            ],
            'columnDefs': [ {
                'targets': [4],
                'orderable': false,
            }]
        });
        $('#city_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/cities/getCities",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "state"},
                {"data": "name"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/cities/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="city" data-url="' + APP_URL + "/cities/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';
                    }
                }
            ],
            'columnDefs': [ {
                'targets': [4],
                'orderable': false,
            }]
        });
        $('#department_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/departments/getDepartments",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/departments/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="department" data-url="' + APP_URL + "/departments/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';

                    }
                }
            ],
            'columnDefs': [ {
                'targets': [3],
                'orderable': false,
            }]


        });

        $('#user_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/user/getUsers",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "firstname"},
                {"data": "lastname"},
                {"data": "email"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/user/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="user" data-url="' + APP_URL + "/user/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';

                    }
                }
            ],
            'columnDefs': [ {
                'targets': [5],
                'orderable': false,
            }]
        });

        $('#permission_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/permission/getPermissions",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/permission/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="permission" data-url="' + APP_URL + "/permission/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';

                    }
                }
            ],
            'columnDefs': [ {
                'targets': [2],
                'orderable': false,
            }]
        });

        $('#role_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": APP_URL + "/role/getRoles",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "date"},
                {
                    "data": null,
                    "render": function (data, type, row, meta) {

                        return '<a href="' + APP_URL + "/role/" + row.id + '/edit/' + '" class="editor_edit btn mr-2 btn-primary btn-sm">Edit</a>  <a href="javascript:;" data-text="role" data-url="' + APP_URL + "/role/" + '" data-id="' + row.id + '"   class="editor_remove btn mr-2 btn-danger btn-sm">Delete</a>';

                    }
                }
            ],
            'columnDefs': [ {
                'targets': [2],
                'orderable': false,
            }]
        });

        $('body').on('click', '.editor_remove ', function () {
            var text = $(this).data('text');
            Swal.fire({
                title: 'Are you sure delete this '+text+' ?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var getID = $(this).data('id'),
                        getURL = $(this).data('url'),
                        token = $("meta[name='csrf-token']").attr("content"),
                        tableID = $(this).parents('table').attr('id');

                    $.ajax({
                        url: getURL + getID,
                        type: 'DELETE',
                        data: {
                            "id": getID,
                            "_token": token,
                        },
                        success: function () {
                            Swal.fire(
                                'Deleted!',
                                'Your '+text+' has been deleted.',
                                'success'
                            );
                            var dt = $('#' + tableID).dataTable();
                            dt.fnDraw();
                        },error:function (){
                            Swal.fire(
                                'Error!',
                                'Your '+text+' has been not deleted.Please try again',
                                'error'
                            )
                        }
                    });

                }
            })


        });
    }
};
jQuery(document).ready((function () {
    AjaxDatatablesClient.init()
}));
