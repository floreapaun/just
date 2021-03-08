@extends('layouts.app')
@section('content')
    {{ $id }}
    <file-component v-bind:props-fileid="{{ $id }}"></file-component>
@endsection

