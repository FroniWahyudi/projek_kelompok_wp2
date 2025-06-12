<!-- Profile Modal (Bootstrap) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Profile Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="profile-card">
          <div class="profile-img-container">
            <img src="{{ htmlspecialchars(auth()->user()->photo_url) }}" 
                 class="profile-img" 
                 alt="Profile Image">
          </div>
          
          <h4 class="profile-name">{{ htmlspecialchars(auth()->user()->name) }}</h4>
          <div class="profile-email">{{ htmlspecialchars(auth()->user()->email) }}</div>
          
          <div class="profile-contact">
            <i class="bi bi-telephone"></i>
            <span>{{ htmlspecialchars(auth()->user()->phone) }}</span>
          </div>
          
          @if(auth()->user()->bio)
            <div class="profile-bio">
              {{ htmlspecialchars(auth()->user()->bio) }}
            </div>
          @endif
          
          <h6 class="profile-section-title">Deskripsi Pekerjaan</h6>
          <div class="profile-job-desc">
            <ul>
              @foreach(explode(', ', auth()->user()->job_descriptions) as $jd)
                <li>{{ $jd }}</li>
              @endforeach
            </ul>
          </div>
          
          <div class="profile-join-date">
            <i class="bi bi-calendar-check"></i> Joined {{ \Carbon\Carbon::parse(auth()->user()->joined_at)->format('j F Y') }}
          </div>
          
          <a href="edit_profil/{{ auth()->user()->id }}" class="edit-profile-btn" style="text-decoration: none;">
            <i class="bi bi-pencil-square me-1"></i> Edit Profile
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
