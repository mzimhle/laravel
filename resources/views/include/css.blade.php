<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}" />
<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style type="text/css">
.social-part .fa{
    padding-right:20px;
}
ul li a{
    margin-right: 20px;
}
</style>
@yield('style')