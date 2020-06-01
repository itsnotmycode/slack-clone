@extends('layouts.app')
{{--@json($userInfo)--}}

@section('content')
    <home inline-template>
        <!-- Router Outlet -->
        <router-view></router-view>
    </home>
@endsection
