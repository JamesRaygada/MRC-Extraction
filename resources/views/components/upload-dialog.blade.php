<form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data" class="flex flex-wrap gap-3 items-center">
  @csrf
  <input type="text" name="title" placeholder="Contract title" class="input w-56" required>
  <input type="email" name="uploader_email" placeholder="Email" class="input w-56">
  <input type="file" name="primary" accept=".pdf,.doc,.docx" required>
  <input type="file" name="spreadsheets[]" accept=".xlsx,.csv" multiple>
  <button class="btn">Upload</button>
</form>
