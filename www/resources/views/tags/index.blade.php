@extends('layouts.app')

@section('content')

<div class="heading-buttons">
	<h1>{{__('Tags')}} <span>{{__('Manage tags')}}</span></h1>	
	
	<tag-create-button></tag-create-button>  

	<form autocomplete="off" class="form-inline buttons pull-right" style="width: 30em">
		<div class="widget-search">
			<button type="button" class="btn btn-default pull-right"><i class="icon-search"></i></button>
			<div class="overflow-hidden">
				<input type="text" value="" class="form-control" placeholder="Search tags ..">
			</div>
		</div>
	</form>

	<div class='buttons pull-right' style='display: inline-flex; width: 100px;'>
		<div class="btn-group btn-block">
			<div class="leadcontainer">
				<button class="btn dropdown-lead btn-default" disabled>Sort</button>
			</div>
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> </a>
			<ul class="dropdown-menu pull-right">
				<li>@sortablelink('tag', 'Alphabetically [A-Z]', ['direction'=>'asc'])</li>
				<li>@sortablelink('tag', 'Reverse Alphabetically [Z-A]', ['direction'=>'desc'])</li>
				<li><a href="#">Most documents</a></li>
				<li><a href="#">Fewest documents</a></li>
				<li class="divider"></li>
				<li><a href="/tags">Reset (last on top)</a></li>
			</ul>
		</div>
	</div>
	
	<div class="clearfix"></div>
</div>  

<div class="innerLR">

	<!-- Table -->
	<table class="footable table table-striped table-bordered table-white table-primary">
	
		<!-- Table heading -->
		<thead>
			<tr>
				<th data-class="expand" class="cell-fit-content">Name</th>				
				<th data-hide="phone,tablet">Description</th>
				<th class="cell-fit-content">Action</th>
			</tr>
		</thead>
		<!-- // Table heading END -->
		
		<!-- Table body -->
		<tbody>
         
			@foreach ($tags as $tag)
				<tr> 									
					<td><span class="badge" style="background-color:{{$tag->color}}; color:{{$tag->fg_color}}">{{$tag->tag}}</span></td>
					<td>{{$tag->description}}</td>
					<td class="cell-fit-content">
						<tag-edit-button tag-id = "{{ $tag->id }}"></tag-edit-button>&nbsp;
						{{-- <a href="" class="btn btn-action remove icon-remove btn-default" onclick="return confirm('Are you sure you want to delete this item?');"></a> --}}
						<form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style='display:inline'>
							@csrf
							@method('DELETE')
							<button class="btn btn-action remove icon-remove btn-default" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');" />															
						</form>
					</td>
				</tr>
			@endforeach
					
		</tbody>
		<!-- // Table body END -->
		
	</table>
	<!-- // Table END -->
	
</div>

<modal-popup-root/>

@endsection

