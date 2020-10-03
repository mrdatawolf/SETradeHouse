@extends('layouts.app')
@section('title', 'Nebulon in The Nebulon Cluster')
@section('content')
<style>
    body {
        font-family: Monospace;
        background-color: #f0f0f0;
        margin: 0px;
        overflow: hidden;
    }
</style>


@endsection
@section('scripts')
    @parent
    <script src="/js/threejs/three.js"></script>
    <script src="/js/threejs/CanvasRenderer.js"></script>
    <script src="/js/threejs/Projector.js"></script>
    <script src="/js/threejs/stats.min.js"></script>
    <script src="/js/threejs/OrbitControls.js"></script>
    <script src="/js/threejs/systems/3d/nebulon.js"></script>
@endsection
