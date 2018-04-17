<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN PAGE</title>
    <link type="text/css" href="{{asset('back-end/css/bootstrap.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('back-end/css/login-2.css')}}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="{{asset('back-end/images/avatar_2x.png')}}" />
        <p id="profile-name" class="profile-name-card"></p>
        <form action="{{ route('admin.login') }}" class="form-signin form-validate-login" method="post">
            {{ csrf_field() }}
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputEmail" class="form-control" name="email" placeholder="Email Address" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me" name="remember"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form><!-- /form -->
    </div><!-- /card-container -->
</div><!-- /container -->
<script src="{{asset('back-end/js/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('back-end/js/bootstrap.min.js')}}"></script>
<script src="{{asset('back-end/js/jquery.validate.min.js')}}"></script>
<script>
    $(function() {
        $.validator.addMethod("customemail",
            function (value, element) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(value);
            },
            "Please enter a valid email address. For example johndoe@domain.com."
        );

        $(".form-validate-login").validate({
            rules: {
                email: {
                    required: true,
                    customemail: true
                },
                password: {
                    required: true,
                    minlength: 6,
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>
</body>
</html>