@extends('admin.layouts.master')

@section('header')
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h2 class="mb-0">
				<span class="text-capitalize">Comments</span>
			</h2>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-flex justify-content-end">
			<ol class="breadcrumb mb-0 p-0 bg-transparent">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item active d-flex align-items-center">Comments</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
	<div class="row">
		<div class="col-12">
			

			
			<div class="card rounded">
				

				
				<div class="card-body">
				    <div class="table-responsive">
                        <table class="table" id="table1">
                          <thead>
                             <tr>
                                <th>Post Name </th>
                                <th>User Name</th>
                                <th>Comment </th>
                                <th>Date</th>
                                <th>Actions</th>
                             </tr>
                          </thead>
                          <tbody>
                            @foreach($comments as $comment)
                            <tr>
                              <td>{{ $comment->title }}</td>
                              <td>{{ $comment->name }}</td>
                              <td>{{ $comment->body }}</td>
                              <td>{{ $comment->created_at }}</td>
                              <td>
                                  
                                <form method="POST" action="{{ route('comments.destroy',['comment' => $comment->id]) }}">
                                  {{ csrf_field() }}
                                  <input name="_method" type="hidden" value="DELETE">
                                  <button class="btn btn-xs btn-danger" type="submit" id="btn-delete"> <i class="far fa-trash-alt"></i> Delete</button>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                       </table>
                    </div><!-- table-responsive -->
				</div>

			
				
        	</div>
    	</div>
	</div>
@endsection

@section('after_styles')
    {{-- DATA TABLES --}}
	{{--<link href="{{ asset('assets/plugins/datatables/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />--}}
	<link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/css/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
	
@endsection

@section('after_scripts')
    {{-- DATA TABLES SCRIPT --}}
	<script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/datatables/extensions/Responsive-2.2.9/js/responsive.bootstrap5.js') }}" type="text/javascript"></script>
	
	{{--
	<script src="{{ asset('assets/plugins/datatables/js/pages/datatable/custom-datatable.js') }}"></script>
	<script src="{{ asset('assets/plugins/datatables/js/pages/datatable/datatable-basic.init.js') }}"></script>
	--}}


    <script type="text/javascript">
        jQuery(document).ready(function($) {
            
             "use strict";
        
        jQuery('#table1').dataTable({
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ], 
            "order": [[ 0, "desc" ]],
            
        });

	
		}
    </script>

@endsection
