@extends('common.layout')

@section('title', 'Student Registration | Bright Boost')

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
                <form class="mx-auto my-auto px-5 py-5" accept="{{route('studentRegistration.post')}}" method="POST">
                  @csrf
                    <h1 class="text-center mb-4">Student Registration</h1>
                    <div class="mb-3">
                      <label for="InputFirstName" class="form-label">First Name</label>
                      <input type="text" class="form-control" id="InputFirstName" name="firstName">
                    </div>
                    <div class="mb-3">
                      <label for="InputLastName" class="form-label">Last Name</label>
                      <input type="text" class="form-control" id="InputLastName" name="lastName">
                    </div>
                    <div class="mb-3">
                      <label for="InputContactNumber" class="form-label">Contact Number</label>
                      <input type="text" class="form-control" id="InputContactNumber" name="contactNumber">
                    </div>
                    <div class="mb-3">
                      <label for="InputEmail" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="InputEmail" name="email">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" class="form-control" id="InputPassword" name="password">
                    </div>
                    <div class="mb-3">
                        Already have an account? <a href="{{route('login')}}" class="text-decoration-none">Login</a>!
                    </div>
                    <button type="submit" class="btn btn-primary">Signup</button>
                  </form>
            </div>
        </div>
    </div>
</div>
@endsection