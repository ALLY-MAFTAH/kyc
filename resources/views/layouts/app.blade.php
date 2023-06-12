<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8">

    <title>
        {{ config('app.name', 'KYC') }} | @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- DATA TABLE --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.bootstrap5.min.css">

    {{-- GENERAL --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

    @yield('styles')

</head>

<body>
    <div class="container-scroller">
        @include('partials.sidebar')

        <div class="container-fluid page-body-wrapper">
            @include('partials.settings-panel')
            @include('partials.navbar')

            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    <div id="loader" class="loader">
                        <!-- Loader content here -->
                    </div>
                    <div class="breadcrumbs">
                        @yield('breadcrumbs')
                    </div>
                    <div id="printable-content">
                        @yield('content')
                    </div>
                </div>
                @include('partials.footer')

            </div>
        </div>
    </div>
    <!-- container-scroller -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/vendors/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    {{-- DATA TABLE --}}

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.colVis.min.js"></script>



    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#data-tebo1').DataTable({
                // dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                //     "<'row'<'col-sm-12'tr>>" +
                //     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // lengthChange: true,
                columnDefs: [{
                    visible: true,
                    targets: '_all'
                }, ],
                // buttons: [
                // {
                //     extend: 'print',
                //     exportOptions: {
                //         columns: ':visible'
                //     },
                //     messageTop: 'DATAAAAAAAAAA'

                // },
                // {
                //     extend: 'pdf',
                //     exportOptions: {
                //         columns: ':visible'
                //     },
                //     margin: [20, 20, 20, 20],
                //     padding: [20, 20, 20, 20],
                //     customize: function(doc) {
                //         doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                //             .length + 1).join('*').split('');
                //         doc.content[1].table.widths[0] = 'auto';
                //     }
                // },
                // {
                //     extend: 'excel',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // },
                // {
                //     extend: 'csv',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // },
                //     'colvis'
                // ]
            });
            table.buttons().container()
                .appendTo('#data-tebo1_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#data-tebo2').DataTable({
                // dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                //     "<'row'<'col-sm-12'tr>>" +
                //     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // lengthChange: true,
                columnDefs: [{
                    visible: true,
                    targets: '_all'
                }, ],
                // buttons: [{
                //         extend: 'print',
                //         exportOptions: {
                //             columns: ':visible'
                //         },
                //         messageTop: 'DATAAAAAAAAAA'

                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: ':visible'
                //         },
                //         margin: [20, 20, 20, 20],
                //         padding: [20, 20, 20, 20],
                //         customize: function(doc) {
                //             doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                //                 .length + 1).join('*').split('');
                //             doc.content[1].table.widths[0] = 'auto';
                //         }
                //     },
                //     {
                //         extend: 'excel',
                //         exportOptions: {
                //             columns: ':visible'
                //         }
                //     },
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: ':visible'
                //         }
                //     },
                //     'colvis'
                // ]
            });
            table.buttons().container()
                .appendTo('#data-tebo2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#data-tebo3').DataTable({
                // dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                //     "<'row'<'col-sm-12'tr>>" +
                //     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                // lengthChange: true,
                columnDefs: [{
                    visible: true,
                    targets: '_all'
                }, ],
                // buttons: [{
                //         extend: 'print',
                //         exportOptions: {
                //             columns: ':visible'
                //         },
                //         messageTop: 'DATAAAAAAAAAA'

                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: ':visible'
                //         },
                //         margin: [20, 20, 20, 20],
                //         padding: [20, 20, 20, 20],
                //         customize: function(doc) {
                //             doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                //                 .length + 1).join('*').split('');
                //             doc.content[1].table.widths[0] = 'auto';
                //         }
                //     },
                //     {
                //         extend: 'excel',
                //         exportOptions: {
                //             columns: ':visible'
                //         }
                //     },
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: ':visible'
                //         }
                //     },
                //     'colvis'
                // ]
            });
            table.buttons().container()
                .appendTo('#data-tebo2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loader = document.getElementById('loader');

            // Hide the loader initially
            loader.style.display = 'none';

            // Show the loader on form submit
            document.addEventListener('submit', function() {
                loader.style.display = 'block';
            });

            // Show the loader on link clicks or page navigation
            document.addEventListener('click', function(event) {
                var target = event.target;

                var isModalButton =
                    target.closest('[data-bs-toggle="modal"]') ||
                    target.closest('[data-toggle="modal"]') ||
                    target.closest('[data-bs-toggle="collapse"]') ||
                    target.closest('[data-toggle="collapse"]') ||
                    target.closest('.modal');

                var isDataTableNavButton = target.closest('.paginate_button') ||
                    target.closest('.previous') ||
                    target.closest('.next');

                if (
                    (target.tagName === 'A' || target.getAttribute('href')) &&
                    !isModalButton &&
                    !isDataTableNavButton
                ) {
                    //   showConfirmationDialog(event);
                    var loader = document.getElementById('loader');
                    loader.style.display = 'none';
                }
            });

            // Exclude Alt+Left Arrow key event from triggering the loader display
            window.addEventListener('keydown', function(event) {
                if (event.altKey && event.code === 'ArrowLeft') {
                    //   if (loader.style.display === 'block') {
                    loader.style.display = 'none';
                    //   }
                }
            });
        });
    </script>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
        function saveWebpage() {
            var pageTitle = document.title;
            var pageUrl = window.location.href;
            var html = document.documentElement.outerHTML;
            var now = new Date();
            var dateString = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate();

            var blob = new Blob([html], {
                type: "text/html;charset=utf-8"
            });
            saveAs(blob, dateString + " " + pageTitle + ".html");
        }

        function saveAs(blob, filename) {
            if (navigator.msSaveBlob) {
                // IE10+
                navigator.msSaveBlob(blob, filename);
            } else {
                var link = document.createElement("a");
                // Browsers that support HTML5 download attribute
                if (link.download !== undefined) {
                    var url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", filename);
                    link.style.visibility = "hidden";
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        }
    </script>
    @yield('scripts')
</body>

</html>
