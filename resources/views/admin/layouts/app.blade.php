<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.partials.head')
</head>

<body>
    <div class="app">

        <!-- ================= SIDEBAR ================= -->
        @include('admin.layouts.partials.sidebar')

        <!-- ================= MAIN ================= -->
        <div class="main">
            @include('admin.layouts.partials.header')
            @include('admin.layouts.partials.message')

            <main class="content">
                @yield('content')
            </main>

        </div>
    </div>

    @include('admin.layouts.partials.script')
</body>

</html>