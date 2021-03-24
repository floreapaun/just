@extends('layouts.app')
@section('content')
    @auth
    <file-component v-bind:props-fileid="{{ $id }}" v-bind:props-isadmin='1'></file-component>
    @endauth

    @guest
    <file-component v-bind:props-fileid="{{ $id }}" v-bind:props-isadmin='0'></file-component>
    @endguest
@endsection

