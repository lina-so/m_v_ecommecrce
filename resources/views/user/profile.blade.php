@extends('dashboard.layouts.main')
@section('title' ,'User Profile')

@section('breadcrumb')
   @parent
   <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<!-- Main content -->
<div class="content">
   <div class="container-fluid">
      user profile
   </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->
@endsection
