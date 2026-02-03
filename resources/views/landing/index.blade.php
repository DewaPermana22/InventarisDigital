@extends('layouts.app')

@section('title', $title)
@section('meta_description', 'InventarisDigital membantu bisnis mengelola stok barang, aset, dan laporan inventaris. Solusi modern untuk efisiensi bisnis Anda.')
@section('content')
@include('landing.sections.hero')
@include('landing.sections.problems')
@include('landing.sections.solutions')
@include('landing.sections.features')
@include('landing.sections.steps')
@include('landing.sections.targets')
@include('landing.sections.pricings')
@include('landing.sections.cta')
@endsection

@push('scripts')
<script type="application/ld-json">
{
  "@@context": "https://schema.org",
  "@@type": "SoftwareApplication",
  "name": "InventarisDigital",
  "operatingSystem": "Web-Based",
  "applicationCategory": "BusinessApplication",
  "offers": {
    "@@type": "Offer",
    "price": "0",
    "priceCurrency": "IDR"
  }
}
</script>
@endpush
