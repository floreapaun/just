@extends('layouts.app')
@section('content')
    <file-component v-bind:props-fileid="{{ $id }}"></file-component>
@endsection

