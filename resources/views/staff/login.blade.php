<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/styleGS.css')}}" />
    <title>Login</title>
  </head>
  <body>
    <div class="container">


      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <a href="index.html" style="text-decoration:none;" ><h2>Whatschool</h2></a>
            <p>
                access your account
            </p>

          </div>
          <img src="{{ asset('assets/img/log.svg')}}" class="image" alt="" />
        </div>
        <div class="forms-container">
          <div class="signin-signup">
            <form action="/app/login" method="POST" class="sign-in-form">
                @csrf
              <h2 class="title">Log in</h2>
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="email" name="email" placeholder="email" />
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="mote de pass" />
              </div>
              <input type="submit" value="Login" class="btn solid" />
              <span>
                not logged in ? <a href="/app/register">register </a>
            </span>
            </form>

            </div>

          </div>
      </div>
    </div>

    <script src="{{ asset('assets/js/app.js')}}"></script>
  </body>
</html>
