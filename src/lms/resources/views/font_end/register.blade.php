<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('form/register.Sign up')}}</title>
  <!-- Latest compiled and minified CSS -->
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="{{asset('css/sign_up.css')}}">


  
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
          <div class="card-img-left d-none d-md-flex">
            <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">{{ __('form/register.Sign up')}}</h5>
            <form action="{{route('register.post')}}" method="POST">

              @csrf
              <div class="row">
                <div class="col-6">
                  <div class="form-floating mb-3 @error('first_name') is-invalid @enderror">
                    <input type="text" class="form-control" name="first_name"
                    id="floatingInputUsername" placeholder="myusername" required autofocus>
                    <label for="floatingInputUsername">{{ __('form/register.First name')}}</label>
                  </div>
                  @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-6">
                  <div class="form-floating mb-3 @error('last_name') is-invalid @enderror">
                    <input type="text" class="form-control" name="last_name"
                    id="floatingInputUsername" placeholder="myusername" required autofocus>
                    <label for="floatingInputUsername">{{ __('form/register.Last name')}}</label>
                  </div>
                  @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="form-floating mb-3 @error('email') is-invalid @enderror">
                <input type="email" class="form-control" name="email"
                id="floatingInputEmail" placeholder="name@example.com">
                <label for="floatingInputEmail">{{ __('form/register.Email address')}}</label>
              </div>

              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              <div class="form-floating mb-3 @error('password') is-invalid @enderror">
                <input type="password" class="form-control" name="password"
                id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">{{ __('form/register.Password')}}</label>
              </div>

              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              <div class="form-floating mb-3 @error('password_confirmation') is-invalid @enderror">
                <input type="password" class="form-control" name="password_confirmation"
                id="floatingPasswordConfirm" placeholder="Confirm Password">
                <label for="floatingPasswordConfirm">{{ __('form/register.Confirm Password')}}</label>
              </div>

              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror


              <div class="form-floating mb-3 @error('address') is-invalid @enderror">
                <input type="text" class="form-control" name="address"
                id="floatingPasswordConfirm" placeholder="Address">
                <label for="floatingPasswordConfirm">{{ __('form/register.Address')}}</label>
              </div>

              @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              <div class="row">
                <div class="col-6">
                  <div class="form-floating mb-3 @error('phone') is-invalid @enderror">
                    <input type="text" class="form-control" name="phone"
                    id="floatingInputUsername" placeholder="phone" required autofocus>
                    <label for="floatingInputUsername">{{ __('form/register.Phone')}}</label>
                  </div>

                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-6">
                  <div class="form-floating mb-3 @error('birthday') is-invalid @enderror">
                    <input type="date" class="form-control" name="birthday"
                    id="floatingInputUsername" placeholder="birthday" required autofocus>
                    <label for="floatingInputUsername">{{ __('form/register.Date of birth')}}</label>
                  </div>

                  @error('birthday')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">{{ __('form/register.Sign up')}}</button>
              </div>

              <a class="d-block text-center mt-2 small" href="{{route('login')}}">{{ __('form/register.Have an account? Sign In')}}</a>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
</html>