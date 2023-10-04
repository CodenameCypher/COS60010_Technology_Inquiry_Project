<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Bright Boost</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
          </li>
          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{auth()->user()->name}}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
            </ul>
          </li>
          @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Authentication
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('login')}}">Login</a></li>
              <li><a class="dropdown-item" href="{{route('teacherRegistration')}}">Register as a Teacher</a></li>
              <li><a class="dropdown-item" href="{{route('studentRegistration')}}">Register as a Student</a></li>
            </ul>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>