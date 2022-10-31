<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('form/login.Sign in')}}</title>
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="stylesheet" href="{{asset('css/sign_in.css')}}">

  
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
          <h3 class="card-title text-center mb-5 fw-light fs-5">{{ __('form/login.Sign in')}}</h3>
          <form action="{{route('login.post')}}" method="POST">
            @csrf
            <div class="form-floating mb-3 @error('email') is-invalid @enderror">
              <input type="email" name="email" value="{{old('email', '')}}"
              class="form-control" id="floatingInput" placeholder="name@example.com">
              <label for="floatingInput">{{ __('form/login.Email address')}}</label>
            </div>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-floating mb-3 @error('password') is-invalid @enderror">
              <input type="password" name="password" value="{{old('password', '')}}"
              class="form-control" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">{{ __('form/login.Password')}}</label>
            </div>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
              <label class="form-check-label" for="rememberPasswordCheck">
              {{ __('form/login.Remember password')}}
              </label>
            </div>

            <div class="d-grid">
              <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                {{ __('form/login.Sign in')}}
              </button>
            </div>

            <a class="d-block text-center mt-2 small" href="{{route('forgotPassword')}}">Forgotten password?</a>

            <hr class="my-4">
            <div class="d-grid">
              <a class="position-absolute start-50 translate-middle btn btn-success btn-login text-uppercase fw-bold" href="{{route('register')}}">{{ __('form/login.Create New Account')}}</a>
            </div>
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