<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #F0F0F0 !important;">


    <h1 style="text-align: center;"> {{ env('APP_NAME') }} </h1>

    <div style="display: flex; justify-content: center; padding: 50px">
        <div style="margin-top: 10px; width: 100%;background-color:#E8E8E8; margin-bottom: 10px; padding:60px">
            <p style="font-size: 15px !important; margin-left:30px; font-family:Segoe UI">Dear valued customer,</p>
            <p style="font-size: 14px !important;margin-left:30px;font-family:Segoe UI">
                Please copy the OTP of your email address. <span>{{ $data['email'] }}</span>
            </p>
            <p style="font-size: 14px !important;margin-left:30px;font-family:Segoe UI">
                `OTP` :  <h1> {{ $data['otp'] }} </h1>
            </p>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
