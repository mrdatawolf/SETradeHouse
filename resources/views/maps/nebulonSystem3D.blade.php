@extends('layouts.tests')
@section('title', 'Nebulon in The Nebulon Cluster')
@section('menu')
@parent
@endsection
@section('content')
<style>
    body {
        font-family: Monospace;
        background-color: #f0f0f0;
        margin: 0px;
        overflow: hidden;
    }
</style>
<script src="/js/threejs/three.js"></script>
<script src="/js/threejs/CanvasRenderer.js"></script>
<script src="/js/threejs/Projector.js"></script>
<script src="/js/threejs/stats.min.js"></script>
<script src="/js/threejs/OrbitControls.js"></script>
<script src="/js/threejs/systems/3d/nebulon.js"></script>

@endsection
@section('scripts')
    @parent
@endsection
