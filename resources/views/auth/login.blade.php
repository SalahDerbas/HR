<!DOCTYPE html>
<html>

<head>
    <title> {{ trans('auth.title') }} </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">

    <!-- css -->
    <link href="{{ URL::asset('auth/css/styles.css') }}" rel="stylesheet">

</head>

<body>

<div id="container" class="container">
		<!-- FORM SECTION -->
		<div class="row">
			<!-- SIGN UP -->
			<div class="col align-items-center flex-col sign-up">
				<div class="form-wrapper align-items-center">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
					<div class="form sign-up">
						<div class="input-group">
							<i class='bx bxs-user'></i>
							<input  id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ trans('auth.name')}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

						</div>
						<div class="input-group">
							<i class='bx bx-mail-send'></i>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                             name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ trans('auth.Email')}}">
                             @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

						</div>
						<div class="input-group">
							<i class='bx bxs-lock-alt'></i>
							<input t id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                             name="password" required autocomplete="new-password" placeholder="{{ trans('auth.Password')}}">
                             @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

						</div>
						<div class="input-group">
							<i class='bx bxs-lock-alt'></i>
							<input id="password-confirm" type="password" class="form-control"
                             name="password_confirmation" required autocomplete="new-password" placeholder="{{ trans('auth.Confirm_password')}} ">
						</div>
						<button>
							{{ trans('auth.Sign_up') }}
						</button>

        </form>
						<p>
							<span>
                            {{ trans('auth.already_exists') }}
							</span>
							<b onclick="toggle()" class="pointer">
                            {{ trans('auth.Sign_in_here') }}
							</b>
						</p>
					</div>
				</div>

			</div>
			<!-- END SIGN UP -->
			<!-- SIGN IN -->
			<div class="col align-items-center flex-col sign-in">
				<div class="form-wrapper align-items-center">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
					<div class="form sign-in">
						<div class="input-group">
							<i class='bx bxs-user'></i>
							<input type="email" placeholder="{{ trans('auth.Email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
						</div>
						<div class="input-group">
							<i class='bx bxs-lock-alt'></i>
							<input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="{{ trans('auth.Password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

						</div>
						<button>
                        {{ trans('auth.Submit') }}
						</button>
						<p>
							<b>
                                <a href="{{ route('forget_password')}}">
                                {{ trans('auth.ForgetPassword') }}
                                </a>
							</b>
						</p>
						<p>
							<span>
                            {{ trans('auth.Dont_account') }}


							</span>
							<b onclick="toggle()" class="pointer">
                            {{ trans('auth.Sign_up_here') }}
							</b>
						</p>
					</div>
                </form>


				</div>
				<div class="form-wrapper">

				</div>
			</div>
			<!-- END SIGN IN -->
		</div>
		<!-- END FORM SECTION -->
		<!-- CONTENT SECTION -->
		<div class="row content-row">
			<!-- SIGN IN CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="text sign-in">
					<h2>
						{{trans('auth.title')}}
					</h2>

				</div>
				<div class="img sign-in">

				</div>
			</div>
			<!-- END SIGN IN CONTENT -->
			<!-- SIGN UP CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="img sign-up">

				</div>
				<div class="text sign-up">
					<h2>
						{{ trans('auth.Join')}}
					</h2>

				</div>
			</div>
			<!-- END SIGN UP CONTENT -->
		</div>
		<!-- END CONTENT SECTION -->
	</div>



    @yield('js')


    <script type="text/javascript">
        let container = document.getElementById('container')

        toggle = () => {
            container.classList.toggle('sign-in')
            container.classList.toggle('sign-up')
        }

        setTimeout(() => {
            container.classList.add('sign-in')
        }, 200)
    </script>


</body>

</html>
