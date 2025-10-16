@props(['title'])
<div {{ $attributes->merge(['class'=>'bg-white rounded-2xl shadow p-4']) }}>
  @if($title)<div class="text-lg font-medium mb-2">{{ $title }}</div>@endif
  {{ $slot }}
</div>
