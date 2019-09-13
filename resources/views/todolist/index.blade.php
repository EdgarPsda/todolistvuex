@extends('layouts.master')

@section('title')
    Basic Todo List - PsdaDev
@endsection

@section('content')
    <todo-index :user="{{ Auth::user() }}"></todo-index>
@endsection