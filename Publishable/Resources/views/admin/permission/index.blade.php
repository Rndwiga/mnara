@extends(config('mnara.views.layouts.master'))

@section('content')
    <div class="right_col" role="main">
        <h1>Permissions
            <div class="btn-group pull-right" role="group" aria-label="...">
                @if ( Auth::user()->can( config('mnara.acl.role.viewmatrix', false) ) )
                    <a href="{{ route('mnara.role.matrix') }}">
                        <button type="button" class="btn btn-default">
                            <i class="fa fa-th fa-fw"></i>
                            <span class="hidden-xs hidden-sm">Role Matrix</span>
                        </button></a>
                @endif

                @if ( Auth::user()->can( config('mnara.acl.permission.create', false) ) )
                    <a href="{{ route( config('mnara.route.as') .'permission.create') }}">
                        <button type="button" class="btn btn-info">
                            <i class="fa fa-plus fa-fw"></i>
                            <span class="hidden-xs hidden-sm">Add New Permission</span>
                        </button></a>
                @endif
            </div>
        </h1>

        <!-- search bar -->
        @include( config('mnara.views.layouts.search'), [ 'search_route' => config('mnara.route.as') .'permission.index', 'items' => $permissions, 'acl' => 'permission' ] )

        <div class="table">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th><th>Name</th><th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse($permissions as $item)
                    <tr>
                        <td>{{ $item->id }}</td>

                        <td>
                            <a href="{{ route( config('mnara.route.as') .'permission.show', $item->id) }}">{{ $item->name }}</a>
                        </td>

                        <td>
                            @if ( Auth::user()->can( config('mnara.acl.permission.role', false)) )
                                <a href="{{ route( config('mnara.route.as') .'permission.role.edit', $item->id) }}">
                                    <button type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-users fa-fw"></i>
                                        <span class="hidden-xs hidden-sm">Roles</span>
                                    </button></a>
                            @endif

                            @if ( Auth::user()->can( config('mnara.acl.permission.edit', false)) )
                                <a href="{{ route( config('mnara.route.as') .'permission.edit', $item->id) }}">
                                    <button type="button" class="btn btn-default btn-xs">
                                        <i class="fa fa-pencil fa-fw"></i>
                                        <span class="hidden-xs hidden-sm">Update</span>
                                    </button></a>
                            @endif

                            @if ( Auth::user()->can( config('mnara.acl.permission.destroy', false) ) )
                                {!! Form::open(['method'=>'delete','route'=> [ config('mnara.route.as') .'permission.destroy',$item->id], 'style' => 'display:inline']) !!}
                                <button type="submit" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash-o fa-lg"></i>
                                    <span class="hidden-xs hidden-sm">Delete</span>
                                </button>
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td>There are no permissions</td></tr>
                @endforelse

                <!-- pagination -->
                <tfoot>
                <tr>
                    <td colspan="3" class="text-center small">
                        {!! $permissions->render() !!}
                    </td>
                </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
    </div>

    
@endsection