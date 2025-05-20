<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Edit User: {{ $user['name'] }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  </div>

  <form id="formEditUser"
        method="POST"
        action="{{ route('operator.update', $user['id']) }}">
    <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
      @csrf
      @method('PUT')

      <input type="hidden" name="id" value="{{ $user['id'] }}">

      <!-- Nama -->
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $user['name']) }}"
               required>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $user['email']) }}">
      </div>

      <!-- Role -->
      <div class="mb-3">
        <label class="form-label">Role</label>
        <input type="text"
               name="role"
               class="form-control"
               value="{{ old('role', $user['role']) }}">
      </div>

      <!-- Password (optional) -->
      <div class="mb-3">
        <label class="form-label">Password (kosongkan jika tidak mau diubah)</label>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="••••••••">
      </div>

      <!-- Phone -->
      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ old('phone', $user['phone'] ?? '') }}">
      </div>

      <!-- Photo URL -->
      <div class="mb-3">
        <label class="form-label">Photo URL</label>
        <input type="text"
               name="photo_url"
               class="form-control"
               value="{{ old('photo_url', $user['photo_url'] ?? '') }}">
      </div>

      <!-- Bio -->
      <div class="mb-3">
        <label class="form-label">Bio</label>
        <textarea name="bio"
                  class="form-control"
                  rows="3">{{ old('bio', $user['bio'] ?? '') }}</textarea>
      </div>

      <!-- Alamat -->
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text"
               name="alamat"
               class="form-control"
               value="{{ old('alamat', $user['alamat'] ?? '') }}">
      </div>

      <!-- Joined At -->
      <div class="mb-3">
        <label class="form-label">Joined At</label>
        <input type="date"
               name="joined_at"
               class="form-control"
               value="{{ old('joined_at', $user['joined_at'] ?? '') }}">
      </div>

      <!-- Education -->
      <div class="mb-3">
        <label class="form-label">Education</label>
        <input type="text"
               name="education"
               class="form-control"
               value="{{ old('education', $user['education'] ?? '') }}">
      </div>

      <!-- Department -->
      <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text"
               name="department"
               class="form-control"
               value="{{ old('department', $user['department'] ?? '') }}">
      </div>

      <!-- Level -->
      <div class="mb-3">
        <label class="form-label">Level</label>
        <input type="text"
               name="level"
               class="form-control"
               value="{{ old('level', $user['level'] ?? '') }}">
      </div>

      <!-- Job Descriptions -->
      <div class="mb-3">
        <label class="form-label">Job Descriptions</label>
        <textarea name="job_descriptions"
                  class="form-control"
                  rows="2">{{ old('job_descriptions', $user['job_descriptions'] ?? '') }}</textarea>
      </div>

      <!-- Skills -->
      <div class="mb-3">
        <label class="form-label">Skills</label>
        <input type="text"
               name="skills"
               class="form-control"
               value="{{ old('skills', $user['skills'] ?? '') }}">
      </div>

      <!-- Achievements -->
      <div class="mb-3">
        <label class="form-label">Achievements</label>
        <textarea name="achievements"
                  class="form-control"
                  rows="2">{{ old('achievements', $user['achievements'] ?? '') }}</textarea>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
    </div>
  </form>
</div>

<script>
document.getElementById('formEditUser').addEventListener('submit', function(e) {
  e.preventDefault();
  const form = e.target;
  const data = new FormData(form);
  fetch(form.action, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: data
  })
  .then(res => res.json())
  .then(json => {
    if (json.success) {
      const modalEl = document.querySelector('.modal.show');
      bootstrap.Modal.getInstance(modalEl).hide();
      location.reload();
    } else {
      alert('Gagal menyimpan perubahan');
    }
  })
  .catch(err => {
    console.error(err);
    alert('Error saat menyimpan');
  });
});
</script>
