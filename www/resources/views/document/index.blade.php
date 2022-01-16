@extends('layouts.app')

@section('content')

<h1>Documents</h1>

<div class="innerLR">

	<!-- Widget -->
	<div class="widget widget-heading-simple widget-body-gray">
		<div class="widget-body center">
			<p class="lead margin-none">Unlimited Columns &amp; Expandable Rows. Tables for Desktop, Tablet &amp; Mobile. Resize your browser to try them.</p>
		</div>
	</div>
		
	<h5 class="text-uppercase strong separator bottom margin-none">Example Using jQuery</h5>
	<!-- Table -->
	<table class="footable table table-striped table-bordered table-white table-primary">
	
		<!-- Table heading -->
		<thead>
			<tr>
				<th data-class="expand">Name</th>				
				<th data-hide="phone,tablet">Tags</th>
				<th data-hide="phone,tablet">Issuer</th>
				<th data-hide="phone">Issue date</th>
				<th>Action</th>
			</tr>
		</thead>
		<!-- // Table heading END -->
		
		<!-- Table body -->
		<tbody>

			@foreach ($documents as $document)            
				<tr> 
					<td><b>{{$document['name']}}</b></td> 
					<td>
						@if (count($document->tags))
							{{$document->tags->pluck('tag')->implode(', ')}}
						@else 
							<span class='no-value'>- No Tags -</span>
						@endif  
					</td>
					<td> 
						@if (count($document->parties))
							@foreach ($document->parties as $party_of_doc)
								{{$party_of_doc->party->name}}
							@endforeach
						@else 
							<span class='no-value'>- No Parties -</span>
						@endif  
					</td>   
					<td>{{$document['issue_date']}}</td>					
					<td> [ - BUTTON - ]</td>
				</tr>
			@endforeach
					
			
		</tbody>
		<!-- // Table body END -->
		
	</table>
	<!-- // Table END -->
	
</div>


@endsection

