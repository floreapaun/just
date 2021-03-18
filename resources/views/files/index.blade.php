@extends('layouts.app')

@section('content')
    <files-table-component v-bind:props-files="{{ $files }}"></files-table-component>
@endsection
