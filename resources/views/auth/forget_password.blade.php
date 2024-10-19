<!DOCTYPE html>
<html>

<head>
    <title> {{ trans('auth.title') }} </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900" rel="stylesheet">

    <!-- css -->
    <link href="{{ URL::asset('auth/css/forget.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">{{ trans('auth.ForgetPassword')}}</h2>
                  <p>{{ trans('auth.can_reset_password')}}</p>
                  <div class="panel-body">

                    <form id="register-form" action="{{route('password.email')}}" role="form" autocomplete="off" class="form" method="post">

                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="email" name="email" placeholder="{{ trans('auth.Email')}}" class="form-control"  type="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="{{ trans('auth.reset_password')}}" type="submit">
                      </div>

                      <input type="hidden" class="hide" name="token" id="token" value="">
                    </form>
                    <a class="btn btn-info" href="/login">
                        {{ trans('auth.Go_To_login') }}
                    </a>

                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>

    @yield('js')
</body>

</html>
