@extends('layouts.app')

@section('title', $title)

@section('content')
@include('landing.sections.hero')
@include('landing.sections.problems')
@include('landing.sections.solutions')
@include('landing.sections.features')
@include('landing.sections.steps')
@include('landing.sections.targets')
@include('landing.sections.cta')
@endsection
