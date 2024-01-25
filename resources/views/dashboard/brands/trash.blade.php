@extends('dashboard.layouts.main')
@section('title', 'Trashed brands')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection


@section('content')

<div class="mb-5 ml-3">
    <a href="{{ route('dashboard.brands.index') }}" class="btn btn-sm btn-outline-dark mr-2">back</a>
    <button class="btn btn-outline-danger btn-sm " data-toggle="modal" data-target="#deleteModal" id="btn_delete_selected" disabled>Delete Selected</button>
</div>

    <form action="{{ URL::current() }}" method="get" class="mb-4 d-flex justify-content-between">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <button type="submit" class="btn btn-dark btn-sm mx-2">Find</button>
    </form>

    <x-alert.alert type="success" />
    <x-alert.alert type="info" />


    <table class="table" id="datatable">
        <thead>
            <tr>
                <th><input name="select_all" id="example-select-all" type="checkbox" onclick="checkAll('box1',this)"> </th>
                <th>ID</th>
                <th>Name</th>
                <th>deleted at</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @forelse ($brands as $brand)
                <tr>
                    @php $i++ @endphp
                    <td><input type="checkbox" value="{{ $brand->id }}" class="box1"> </td>
                    <td>{{ $i }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->deleted_at }}</td>
                    {{-- restore --}}
                    <td>
                        <form action="{{ route('dashboard.brands.restore', $brand->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn  btn-outline-warning btn-sm">Restore</button>
                        </form>
                    </td>
                    {{-- forceDelete --}}
                    <td>
                        <form action="{{ route('dashboard.brands.forceDelete', $brand->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Force Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="background-color:#007bff; color:white" class="text-center">No brands
                        Difined</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete all selected brands?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="{{ route('dashboard.brands.deleteAll') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="delete_all_id" id="delete_all_id" value=''>
                        <input type="hidden" name="force" id="force" value='force'>


                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{ $brands->withQueryString()->links() }}
@endsection
