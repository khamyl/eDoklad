@extends('layouts.auth')

@section('content')
<!-- Wrapper -->
<div id="login">

	<div class="container">
	
		<div class="wrapper">
		
			<h1 class="glyphicons lock">{{config('app.name')}}<i></i></h1>
		
			<!-- Box -->
			<div class="widget widget-heading-simple widget-body-gray">
				
				<div class="widget-body">
				
					<!-- Form -->
                    <form method="post" action="{{ route('login') }}" class="row">
                        @csrf
						<label for="email">{{ __('Username') }}</label>
						<input id="email" type="email" class="input-block-level form-control" name="email" value = "{{ old('email') }}" placeholder="{{ __('Your Username or Email address') }}" required autofocus/> 
						<label for="password">{{ __('Password') }} <a class="password" href="">{{ __('Frgot it?') }}</a></label>
						<input id="password" type="password" name="password" class="input-block-level form-control margin-none" placeholder="{{ __('Your password') }}" required />
						<div class="separator bottom"></div> 
						
							<div class="col-md-8 padding-none ">
								<div class="uniformjs innerL"><label class="checkbox" for="remember"><input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>{{ __('Remember me!') }}</label></div>
							</div>
							<div class="col-md-4 pull-right padding-none">
								<button class="btn btn-block btn-inverse" type="submit">{{ __('Sign in!') }}</button>
							</div>
						
					</form>
					<!-- // Form END -->
							
				</div>
				<div class="widget-footer">
					<p class="glyphicons restart"><i></i>Please enter your username and password ...</p>
				</div>
			</div>
			<!-- // Box END -->
			
			<div class="innerT center">
			
				<a href="#">{{ __('Sign up!') }}</span></a>				
                <p>Having troubles? <a href="faq.html?lang=en&amp;layout_type=fluid&amp;menu_position=menu-left&amp;style=style-default-menus-dark&amp;sidebar_type=collapsible">Get Help</a></p>
			</div>			
		</div>		
	</div>	
</div>
<!-- // Wrapper END -->	
@endsection
