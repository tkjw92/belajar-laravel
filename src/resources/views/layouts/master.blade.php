<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modernize Free</title>
        <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />
        <link rel="stylesheet" href="/assets/css/styles.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
        @yield("style")
    </head>

    <body>
        <!--  Body Wrapper -->
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed">
            <!-- Sidebar Start -->
            @include("layouts.sidebar")
            <!--  Sidebar End -->
            <!--  Main wrapper -->
            <div class="body-wrapper">
                <!--  Header Start -->
                @include("layouts.header")
                <!--  Header End -->
                <div class="container-fluid">
                    @yield("content")
                </div>
            </div>
        </div>

        @include("layouts.js")

        @yield("script")
    </body>

</html>
