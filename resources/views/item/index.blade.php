<title>Item/index</title>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!-- This script got from frontendfreecode.com -->

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.css'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.13/css/all.css'>
    <script src='https://code.jquery.com/jquery-3.3.1.js'></script>
    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.js'></script>
    <script src='https://rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/extensions/export/bootstrap-table-export.js'>
    </script>

    <style>
        * {
            font-size: 0.93rem;
        }

        .fa-refresh::before {
            content: "\f2f1";
        }

        .fa-toggle-up:before,
        .fa-caret-square-o-up:before {
            content: "\f151";
        }

        .fa-toggle-down:before,
        .fa-caret-square-o-down:before {
            content: "\f150";
        }

        .fa-toggle-on:before {
            content: "\f205";
        }

        .fa-toggle-off:before {
            content: "\f204";
        }

        .dropdown-menu>li>a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: 400;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }

        .dropdown-menu>li>a:hover,
        .dropdown-menu>li>a:focus {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .pagination>li>a,
        .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination>.active>a,
        .pagination>.active>span,
        .pagination>.active>a:hover,
        .pagination>.active>span:hover,
        .pagination>.active>a:focus,
        .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca !important;
            border-color: #428bca !important;
        }

        .pagination>li:first-child>a,
        .pagination>li:first-child>span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination>li:last-child>a,
        .pagination>li:last-child>span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle i,
        .nav-link i {
            font-size: 12px;
            margin-left: 5px;
            font-weight: bold;
        }

        .dropdown-header {
            display: block;
            padding: 0rem 1.5rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            color: #868e96;
            white-space: nowrap;
        }

        .dropdown-toggle::after {
            border-top: none;
            border-right: none;
            border-left: none;
        }

        .dropdown-menu {
            border: 0px;
            border-radius: 0.25rem;
            box-shadow: 0px 3px 6px #999;
            z-index: 9999;
        }

        .dropdown-menu>.active>a,
        .dropdown-menu>.active>a:hover,
        .dropdown-menu>.active>a:focus {
            color: #fff !important;
            text-decoration: none;
            background-color: #428bca !important;
            outline: 0;
        }

        .dropdown-menu>li>a {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: 400;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }

        .dropdown-menu>li>a:hover,
        .dropdown-menu>li>a:focus {
            color: #262626;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: normal;
            /*color: #212529;*/
            color: #555 !important;
            /*cosine-edit*/
            text-align: inherit;
            white-space: nowrap;
            background: none;
            border: 0;
            font-size: 12px;
            /*cosine-edit*/
        }

        .dropdown-item:focus,
        .dropdown-item:hover {
            /*color: #16181b;*/
            color: #ffffff !important;
            /*cosine-edit*/
            text-decoration: none;
            /*background-color: #f8f9fa;*/
            background-color: #999 !important;
            /*cosine-edit*/
            transition: background-color 0.3s, color 0.2s;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div id="toolbar">
            <button id="remove" class="btn btn-danger" disabled>Delete <i class="fas fa-trash-alt"></i></button>
        </div>

        <div class="container-fluid d-flex justify-content-center align-items-center mt-1">
            <div class="container">
                <h1 class="text-center mb-3" style="color: black">Items List</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="table table-bordered table-striped" id="table">
                    {{-- <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product_Name</th>
                            <th>Product_Quantity</th>
                            <th>Product_Price</th>
                            <th>Action</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="#" onclick="confirmDelete('{{ route('item.destroy', $item->id) }}')"
                                        class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="{{ route('item.edit', $item->id) }}" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="bcl"><a style="font-size:8pt;text-decoration:none;" href="http://www.devanswer.com"></a>
    </div>
    <script>
        var $table = $("#table"),
            $remove = $("#remove"),
            selections = [];
        $(function() {
            $table.bootstrapTable("destroy");
            $table.bootstrapTable({
                columns: [
                    [{
                            field: "state",
                            checkbox: true,
                            align: "center",
                            valign: "middle"
                        },

                        {
                            title: "ID",
                            field: "id",
                            sortable: true,
                            valign: "middle"
                        },

                        {
                            title: "Product_Name",
                            field: "date",
                            sortable: true,
                            valign: "middle",
                            id: "dob",
                            editable: {
                                type: "combodate",
                                format: "YYYY/MM/DD",
                                template: "YYYY / MM / DD",
                                combodate: {
                                    maxYear: 2030,
                                    minYear: 2018,
                                    firstItem: "none" //'name', 'empty', 'none'
                                },
                                emptytext: "-"
                            }
                        },


                        {
                            title: "Quantity",
                            field: "supplier",
                            sortable: true,
                            valign: "middle",
                            editable: {
                                type: "text"
                            }
                        },


                        {
                            title: "Price",
                            field: "items",
                            sortable: true,
                            valign: "middle",
                            editable: {
                                type: "text"
                            }
                        },


                        {
                            title: "created_at",
                            field: "deadline",
                            sortable: true,
                            valign: "middle",
                            editable: {
                                type: "text"
                            }
                        },


                        {
                            title: "Action",
                            field: "quantity",
                            sortable: true,
                            valign: "middle",
                            editable: {
                                type: "text"
                            }
                        },
                    ]
                ],



                classes: "table table-hover table-no-bordered",
                toolbar: "#toolbar",
                buttonsClass: "outline-secondary",
                sortClass: undefined,
                undefinedText: "-",
                striped: true,
                sortName: "number",
                sortOrder: "desc",
                sortStable: false,
                sortable: true,
                pagination: true,
                paginationLoop: false,
                onlyInfoPagination: false,
                pageNumber: 1,
                pageSize: 5,
                pageList: [1, 3, 5, 10, "ALL"],
                paginationPreText: "Previous",
                paginationNextText: "Next",
                selectItemName: "btSelectItem",
                smartDisplay: true,
                search: true,
                searchOnEnterKey: false,
                strictSearch: false,
                searchText: "",
                searchTimeOut: "500",
                trimOnSearch: true,
                searchalign: "right",
                buttonsAlign: "right",
                toolbarAlign: "left",
                paginationVAlign: "bottom",
                paginationHAlign: "right",
                paginationDetailHAlign: "left",
                showHeader: true,
                showFooter: false,
                showColumns: true,
                showRefresh: true,
                showToggle: false,
                showExport: true,
                showPaginationSwitch: true,
                showFullscreen: false,
                minimumCountColumns: 5,
                idField: undefined,
                clickToSelect: false,
                uniqueId: "id",
                singleSelect: false,
                checkboxHeader: true,
                maintainSelected: true
                // reorderableColumns: true,
                // iconsPrefix: "material-icons", // material-icons of fa (font awesome)
                // icons: {
                //   paginationSwitchDown: "material-icons-collapse-down icon-chevron-down",
                //   paginationSwitchUp: "material-icons-collapse-up icon-chevron-up",
                //   refresh: "material-icons-refresh icon-refresh",
                //   toggle: "material-icons-list-alt icon-list-alt",
                //   columns: "material-icons-th icon-th",
                //   detailOpen: "glyphicon-plus icon-plus",
                //   detailClose: "glyphicon-minus icon-minus"
                // }
            });
            $table.on(
                "check.bs.table uncheck.bs.table " +
                "check-all.bs.table uncheck-all.bs.table",
                function() {
                    $remove.prop("disabled", !$table.bootstrapTable("getSelections").length);
                    selections = getIdSelections();
                });

            $remove.click(function() {
                var ids = getIdSelections();
                $table.bootstrapTable("remove", {
                    field: "id",
                    values: ids
                });

                $remove.prop("disabled", true);
            });
            $('[data-toggle="dropdown"] >i').
            removeClass("glyphicon-export").
            addClass("fa-download");
        });

        function getIdSelections() {
            return $.map($table.bootstrapTable("getSelections"), function(row) {
                return row.id;
            });
        }

        function actionFormatter(value, row, index) {
            return ['<button class="remove btn btn-danger btn-sm">Delete</button>'].join(
                "");

        }
        window.actionEvents = {
            "click .remove": function(e, value, row, index) {
                $table.bootstrapTable("remove", {
                    field: "id",
                    values: [row.id]
                });

            }
        };
    </script>

</body>

</html>
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Bootstrap JS (optional, if you need it for other features) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDelete(url) {
        if (confirm('Are you sure you want to delete this item?')) {
            window.location.href = url;
        }
    }
</script>
