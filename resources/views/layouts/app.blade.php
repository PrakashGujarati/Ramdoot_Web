<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <!-- <base href="../"> -->
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <!-- <link rel="shortcut icon" href="./images/favicon.png"> -->
    <!-- Page Title  -->
    <!-- Ramdoot Education |  -->
    <title>@yield('title')</title>
    <!-- StyleSheets  -->
    @yield('css')
    @include('layouts.style')
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            @include('layouts.sidebar')
            <!-- wrap @s -->
            <div class="nk-wrap ">
                @include('layouts.header')
                
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <!-- content @e -->
                @include('layouts.footer')
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    @include('layouts.scripts')

    @yield('scripts')
</body>
</html>