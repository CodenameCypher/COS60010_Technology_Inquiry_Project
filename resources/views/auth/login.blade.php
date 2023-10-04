@extends('common.layout')

@section('title', 'Login | Bright Boost')

@section('body')
<div class="mt-5">
  @if ($errors->any())
      <div class="col-12">
          @foreach ($errors->all() as $error)
              <div class="alert alert-danger">
                  {{$error}}
              </div>
          @endforeach
      </div>
  @endif

  @if (session()->has('error'))
      <div class="alert alert-danger">
          {{session('error')}}
      </div>
  @endif

  @if (session()->has('success'))
      <div class="alert alert-success ">
          {{session('success')}}
      </div>
  @endif
</div>

<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="jumbotron">
                <form class="mx-auto my-auto px-5 py-5" action="{{route('login.post')}}" method="POST">
                  @csrf
                  <h1 class="text-center mb-4">Login</h1>
                    <div class="mb-3">
                      <label for="InputEmail" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" name="email">
                      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" class="form-control" id="InputPassword" name="password">
                    </div>
                    <div class="mb-3">
                        Don't have an account? <br> Signup as a <a href="{{route('teacherRegistration')}}" class="text-decoration-none">teacher</a> or <a href="{{route('studentRegistration')}}" class="text-decoration-none">student</a>!
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                  </form>
            </div>
        </div>
    </div>
</div>
@endsection