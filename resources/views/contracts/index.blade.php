<x-layout>
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Contracts</h1>
    <x-upload-dialog />
  </div>
  <div class="bg-white rounded-2xl shadow divide-y">
    @foreach($contracts as $c)
      <a href="{{ route('contracts.show',$c->public_id) }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
        <div>
          <div class="font-medium">{{ $c->title }}</div>
          <div class="text-sm text-gray-500">Status: {{ $c->status }} · Updated {{ $c->updated_at->diffForHumans() }}</div>
        </div>
        <div class="text-sm px-2 py-1 rounded-full {{ $c->status==='NeedsReview' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
          {{ $c->risk_level ?? '—' }}
        </div>
      </a>
    @endforeach
  </div>
  <div class="mt-6">{{ $contracts->links() }}</div>
</x-layout>
