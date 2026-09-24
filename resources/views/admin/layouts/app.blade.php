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
    
            <main class="content">
                @include('admin.layouts.partials.message')
                @yield('content')
            </main>

        </div>
    </div>

    @include('admin.layouts.partials.script')
</body>

</html>