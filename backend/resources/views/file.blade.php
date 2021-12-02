@extends('layouts.app')
@section('content')
    @auth
    <file-component v-bind:props-file-id="{{ $id }}" v-bind:props-is-admin='1'></file-component>
    @endauth

    @guest
    <file-component v-bind:props-file-id="{{ $id }}" v-bind:props-is-admin='0'></file-component>
    @endguest
@endsection

