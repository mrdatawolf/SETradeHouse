/**
 * Created by guihang on 2017/2/9.
 * Modified by MrDataWolf 09/24/2020.
 */

//these should be pulled from the database and converted
var devisor = 18000;
var starSize = 30;
var planetSize = 3;
var moonSize = 1;
var moonGPSx = Math.round(16384/devisor);
var moonGPSy = Math.round(136384/devisor);
var moonGPSz = Math.round(-113616/devisor);
var marsGPSx = Math.round(1031072/devisor);
var marsGPSy = Math.round(131072/devisor);
var marsGPSz = Math.round(1631072/devisor);
var europaGPSx = Math.round(916384/devisor);
var europaGPSy = Math.round(16384/devisor);
var europaGPSz = Math.round(1616384/devisor);
var alienGPSx = Math.round(131072/devisor);
var alienGPSy = Math.round(131072/devisor);
var alienGPSz = Math.round(5731072/devisor);
var titanGPSx = Math.round(36384/devisor);
var titanGPSy = Math.round(226384/devisor);
var titanGPSz = Math.round(5796384/devisor);

var container, stats;

var camera, scene, renderer;

var controls;       //orbitcontrol

var europa, alien, earth, mars, titan, nebulon;

var moon;

var skyBox;

var earthTexture;
var moonTexture;
var marsTexture;
var alienTexture;
var nebulonTexture;
var europaTexture;
var titanTexture;

var RUN_RADIUS_NEBULON = 400;
var RUN_RADIUS_ALIEN = alienGPSy;
var RUN_RADIUS_MARS = marsGPSy;
var RUN_RADIUS_MOON = moonGPSy;
var RUN_RADIUS_EUROPA = europaGPSy;
var RUN_RADIUS_TITAN = titanGPSy;

//Resize
var windowHalfX = window.innerWidth / 2;
var windowHalfY = innerHeight / 2;

var raycaster = new THREE.Raycaster();
var mouse = new THREE.Vector2();
var displayName;

init();
animate();


function onDocumentMouseMove( event ) {

    event.preventDefault();

    mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
    mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;

}

function init() {

    container = document.createElement( 'div' );
    document.body.appendChild( container );

    var info = document.createElement( 'div' );
    info.style.position = 'absolute';
    info.style.top = '10px';
    info.style.width = '100%';
    info.style.textAlign = 'center';
    info.innerHTML = 'Drag to spin the system';
    container.appendChild( info );

    camera = new THREE.PerspectiveCamera( 70, innerWidth / innerHeight, 1, 5000 );
    camera.position.y = 150;
    camera.position.z = 500;

    scene = new THREE.Scene();

    initLight();

    // var gridHelper = new THREE.GridHelper(400, 40, 0x0000ff, 0x808080);
    // scene.add(gridHelper);
    //
    // //极状栅格助手
    // var polarGridHelper = new THREE.PolarGridHelper(200, 16, 8, 64, 0x0000ff, 0x808080);
    // polarGridHelper.position.y = 0;
    // polarGridHelper.position.x = 0;
    // polarGridHelper.position.z = 0;
    // scene.add(polarGridHelper);

    axes = new THREE.AxisHelper( 200 );
    scene.add( axes );

    var textureLoader = new THREE.TextureLoader();

    earthTexture = textureLoader.load( '/img/source/earth.jpg' );
    titanTexture = textureLoader.load( '/img/source/titan_texture.jpg' );
    marsTexture = textureLoader.load( '/img/source/mars_texture.jpg' );
    europaTexture = textureLoader.load( '/img/source/europa_texture.jpg' );
    nebulonTexture = textureLoader.load( '/img/source/nebulon_texture.jpg' );
    alienTexture = textureLoader.load( '/img/source/alien.jpg' );
    moonTexture = textureLoader.load( '/img/source/moon_texture.jpg' );

    nebulon = createPlanet( nebulonTexture, starSize );
    scene.add( nebulon );
    //track = creatTrack( RUN_RADIUS_NEBULON );
    //scene.add( track );

    earth = createPlanet( earthTexture , planetSize);
    scene.add( earth );

    alien = createPlanet( alienTexture, planetSize);
    scene.add( alien );
    //track = creatTrack( RUN_RADIUS_ALIEN );
    //scene.add( track );

    mars = createPlanet( marsTexture, planetSize);
    scene.add( mars );
    //track = creatTrack( RUN_RADIUS_MARS );
    //scene.add( track );

    europa = createPlanet( europaTexture, moonSize);
    scene.add( europa );
    //track = creatTrack( RUN_RADIUS_EUROPA );
    //scene.add( track );

    moon = createPlanet( moonTexture, moonSize);
    scene.add( moon );
    //track = creatTrack( RUN_RADIUS_MOON );
    //scene.add( track );

    titan = createPlanet( titanTexture, moonSize);
    scene.add( titan );
   // track = creatTrack( RUN_RADIUS_TITAN );
    //scene.add( track );

    skyBox = makeSkybox( [
        '/img/source/skybox1/px.jpg',
        '/img/source/skybox1/nx.jpg',
        '/img/source/skybox1/py.jpg',
        '/img/source/skybox1/ny.jpg',
        '/img/source/skybox1/pz.jpg',
        '/img/source/skybox1/nz.jpg'

    ], 4000 );

    // removed to make the planets easier to see
    //scene.add( skyBox );

    var material = new THREE.MeshBasicMaterial(
//        var material = new THREE.MeshPhongMaterial(
        {
            vertexColors: THREE.FaceColors,
            overdraw: 0.5,
            wireframe: false,
//                    map:earthTexture
        } );

    renderer = new THREE.WebGLRenderer( { antialias: true } );
    renderer.setClearColor( 0x000000 );
    renderer.setPixelRatio( window.devicePixelRatio );
    renderer.setSize( innerWidth, innerHeight );
    container.appendChild( renderer.domElement );


    controls = new THREE.OrbitControls( camera, renderer.domElement );
    controls.addEventListener( 'change', render );
    controls.enableZoom = true;

    stats = new Stats();
    container.appendChild( stats.dom );


//
    document.addEventListener( 'mousemove', onDocumentMouseMove, false );

    window.addEventListener( 'resize', onWindowResize, false );

    //test
    var earthCopy = earth.clone( false );

    scene.remove( earth );

    scene.add( earthCopy );
    //test

}

function onWindowResize() {

    windowHalfX = window.innerWidth / 2;
    windowHalfY = window.innerHeight / 2;
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize( window.innerWidth, window.innerHeight );

}


function animate() {

    requestAnimationFrame( animate );

    stats.begin();
    render();
    stats.end();

}

function render() {
    //for test
    // var earthCopy = earth.clone();
    //
    // scene.remove( earth );
    //
    // scene.add( earthCopy );
    //for test

    var timer = Date.now() * 0.01;
    europa.position.x = europaGPSx;
    europa.position.z = europaGPSz;

    alien.position.x = alienGPSx;
    alien.position.z = alienGPSz;

    mars.position.x = marsGPSx;
    mars.position.z = marsGPSz;

    titan.position.x = titanGPSx;
    titan.position.z = titanGPSz;

    nebulon.position.x = Math.cos( timer * Math.pow( 1 / 2, 7 ) ) * RUN_RADIUS_NEBULON;
    nebulon.position.z = Math.sin( timer * Math.pow( 1 / 2, 7 ) ) * RUN_RADIUS_NEBULON;

    moon.position.x = earth.position.x + moonGPSx;
    moon.position.z = earth.position.z + moonGPSz;

    europa.rotation.y = (europa.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : europa.rotation.y + 0.0008 * Math.PI);

    alien.rotation.y = (alien.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : alien.rotation.y + 0.0008 * Math.PI);



    mars.rotation.y = (mars.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : mars.rotation.y + 0.0008 * Math.PI);

    titan.rotation.y = (titan.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : titan.rotation.y + 0.0008 * Math.PI);

    nebulon.rotation.y = (nebulon.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : nebulon.rotation.y + 0.0008 * Math.PI);

    moon.rotation.y = (moon.rotation.y === 2 * Math.PI ? 0.008 * Math.PI : moon.rotation.y + 0.0008 * Math.PI);
//        camera.lookAt(system.position);

    //test

    getInformation();

    renderer.render( scene, camera );


}

function initLight() {

    //ambientLight会使得环境中所有的物体都着上指定的光照,贴图也将受影响
    var ambientLight = new THREE.AmbientLight( 0xaaaaaa );
    scene.add( ambientLight );
}

function createPlanet(planetTexture, size ) {

    size = size || 10;
    var planet = new THREE.Mesh( new THREE.SphereGeometry( size, 20, 20 ),
        new THREE.MeshBasicMaterial( {
            map: planetTexture
        } ) );
    return planet;
}

function creatTrack( runRadius ) {
    var track;
    track = new THREE.Mesh( new THREE.RingGeometry( runRadius - 0.2, runRadius + 0.2, 64, 1 ),
        new THREE.MeshBasicMaterial( {
            color: 0x888888,
            side: THREE.DoubleSide
        } )
    );
    track.rotation.x = - Math.PI / 2;
    return track;
}

function makeSkybox( urls, size ) {
    var skyboxCubemap = new THREE.CubeTextureLoader().load( urls );
    skyboxCubemap.format = THREE.RGBFormat;

    var skyboxShader = THREE.ShaderLib[ 'cube' ];
    skyboxShader.uniforms[ 'tCube' ].value = skyboxCubemap;

    return new THREE.Mesh(
        new THREE.BoxGeometry( size, size, size ),
        new THREE.ShaderMaterial( {
            fragmentShader: skyboxShader.fragmentShader, vertexShader: skyboxShader.vertexShader,
            uniforms: skyboxShader.uniforms, depthWrite: false, side: THREE.BackSide
        } )
    );
}

function getInformation() {

    // raycaster.setFromCamera( mouse, camera );
    //
    // var intersections = raycaster.intersectObjects( scene.children );
    //
    // // console.log( "测试getInformation" );
    //
    // if ( intersections.length > 0 ) {
    //     var intersection = intersections[ 0 ];
    //     console.log( "raycaster获取到的是" + intersection );
    //
    //     testText();
    //
    //     if ( intersections[ 0 ] === earth ) {
    //
    //         // console.log( "测试交互" );
    //
    //
    //         // var geometry = new THREE.TextGeometry( 'earth', {
    //         //
    //         //     font: font,
    //         //     size: 80,
    //         //     height: 20,
    //         //     curveSegments: 2
    //         //
    //         // } );
    //         //
    //         // geometry.computeBoundingBox();
    //         //
    //         // var centerOffset = - 0.5 * ( geometry.boundingBox.max.x - geometry.boundingBox.min.x );
    //         //
    //         // var material = new THREE.MultiMaterial( [
    //         //     new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff, overdraw: 0.5 } ),
    //         //     new THREE.MeshBasicMaterial( { color: 0x000000, overdraw: 0.5 } )
    //         // ] );
    //         //
    //         // var mesh = new THREE.Mesh( geometry, material );
    //         //
    //         // mesh.position.x = centerOffset;
    //         // mesh.position.y = 100;
    //         // mesh.position.z = 0;
    //         // // mesh.position.copy( earth );
    //         //
    //         // mesh.rotation.x = 0;
    //         // mesh.rotation.y = Math.PI * 2;
    //         //
    //         // // group = new THREE.Group();
    //         // // group.add(mesh);
    //         //
    //         // // scene.add(group);
    //         // scene.add( mesh );
    //         // console.log( "添加了太阳的text" );
    //
    //     }
    // }
    // // if ( intersections[ 0 ].object.name === 'earth' ) {

}

function testText( font ) {

    var geometry = new THREE.TextGeometry( 'earth', {

        font: font,
        size: 80,
        height: 20,
        curveSegments: 2

    } );

    geometry.computeBoundingBox();

    var centerOffset = - 0.5 * ( geometry.boundingBox.max.x - geometry.boundingBox.min.x );

    var material = new THREE.MultiMaterial( [
        new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff, overdraw: 0.5 } ),
        new THREE.MeshBasicMaterial( { color: 0x000000, overdraw: 0.5 } )
    ] );

    var mesh = new THREE.Mesh( geometry, material );

    mesh.position.x = centerOffset;
    mesh.position.y = 100;
    mesh.position.z = 0;
    // mesh.position.copy( earth );

    mesh.rotation.x = 0;
    mesh.rotation.y = Math.PI * 2;

    // group = new THREE.Group();
    // group.add(mesh);

    // scene.add(group);
    scene.add( mesh );
    console.log( "text" );

}
