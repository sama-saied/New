@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<div class="app-title">  
    <div>
        <h1><i class="fa fa-comments"></i> {{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>   
</div>

@include('admin.partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th>ProductId</th>
                            <th>User Name</th>
                            <th>Comments</th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                                <tr>
                                    <td> {{$comment->product_id}} </td>
                                    <td> {{$comment->user->full_name}} </td>
                                    <td> {{$comment->body}} </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group"> 
                                            <a href="{{ route('comment.delete', $comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>    
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush