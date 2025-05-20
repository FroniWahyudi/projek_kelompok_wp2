<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
    margin: 0;
    padding-top: 40px;
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
}
.account-settings .user-profile {
    margin: 0 0 1rem 0;
    padding-bottom: 1rem;
    text-align: center;
}
.account-settings .user-profile .user-avatar {
    margin: 0 0 1rem 0;
}
.account-settings .user-profile .user-avatar img {
    width: 90px;
    height: 90px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    border-radius: 100px;
}
.account-settings .user-profile h5.user-name {
    margin: 0 0 0.5rem 0;
}
.account-settings .user-profile h6.user-email {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 400;
    color: #9fa8b9;
}
.account-settings .about {
    margin: 2rem 0 0 0;
    text-align: center;
}
.account-settings .about h5 {
    margin: 0 0 15px 0;
    color: #007ae1;
}
.account-settings .about p {
    font-size: 0.825rem;
}
.form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .825rem;
    background: #ffffff;
    color: #2e323c;
}

.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}

.tombol-upload {
    width: 60%;
    height: 50%;
    font-size: 80%;
    margin-top: 15px;
}
.me-2 {
    margin-right: 0.5rem !important;
    margin-top: 0.5rem !important;
}

  </style>
</head>
<body>
  <div class="container">
    <form action="{{ isset($user) && is_object($user) ? route('profil.update', $user->id) : '#' }}" method="POST" enctype="multipart/form-data">
      @csrf
      @if(isset($user) && is_object($user))
        @method('PUT')
      @endif
      <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="account-settings">
                <div class="user-profile">
                  <div class="user-avatar">
                    <img src="{{ is_object($user) && isset($user->photo_url) ? asset($user->photo_url) : asset('default-avatar.png') }}" alt="User Avatar">
                  </div>
                  <h5 class="user-name">{{ is_object($user) && isset($user->name) ? $user->name : '' }}</h5>
                  <h6 class="user-email">{{ is_object($user) && isset($user->email) ? $user->email : '' }}</h6>
                  <input type="file" name="photo" class="form-control mt-2">
                </div>
                <div class="about mt-3">
                  <h5>About</h5>
                  <p>{{ is_object($user) && isset($user->bio) ? $user->bio : '' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="row gutters">
                <div class="col-12">
                  <h6 class="mb-2 text-primary">Personal Details</h6>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Enter full name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Enter email ID">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Enter phone number">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password (leave blank to keep current password)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bio">Bio</label>
                    <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', $user->bio ?? '') }}" placeholder="Enter your bio">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" name="role" value="{{ old('role', $user->role ?? '') }}" placeholder="Enter your role">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="alamat">Address</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat ?? '') }}" placeholder="Enter your address">
                  </div>
                </div>
              </div>
              <div class="row gutters">
                <div class="col-12 text-right">
                  <button type="reset" class="btn btn-secondary me-2">Cancel</button>
                  <button type="submit" class="btn btn-primary me-2">Update</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => document.body.classList.add('fade-in'), 50);
    });
  </script>
</body>
</html>
