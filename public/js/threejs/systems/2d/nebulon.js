/**
 * Created by guihang on 2017/2/9.
 */
var container, stats;   //定义容器以及监视器

var camera, scene, renderer;

var controls;       //采用orbitcontrol的形式

var sun, mercury, venus, earth, mars, jupiter, saturn, uranus, neptune; //定义太阳以及八大行星

var moon;   //定义卫星

var skyBox;

var sunTexture;
var mercuryTexture;
var venusTexture;
var earthTexture;
var marsTexture;
var jupiterTexture;
var saturnTexture;
var uranusTexture;
var neptuneTexture;
var moonTexture;

//八大行星和月球的关注按半径
var RUN_RADIUS_MERCURY = 200;
var RUN_RADIUS_VENUS = 250;
var RUN_RADIUS_EARTH = 300;
var RUN_RADIUS_MARS = 350;
var RUN_RADIUS_JUPITER = 400;
var RUN_RADIUS_SATURN = 450;
var RUN_RADIUS_URANUS = 500;
var RUN_RADIUS_NEPTUNE = 550;
var RUN_RADIUS_MOON = 25;

//Resize
var windowHalfX = window.innerWidth / 2;
var windowHalfY = innerHeight / 2;

//用于光线投射交互
var raycaster = new THREE.Raycaster();
var mouse = new THREE.Vector2();
var displayName;    //当前显示的名字

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

    //栅格助手
    // var gridHelper = new THREE.GridHelper(400, 40, 0x0000ff, 0x808080);
    // scene.add(gridHelper);
    //
    // //极状栅格助手
    // var polarGridHelper = new THREE.PolarGridHelper(200, 16, 8, 64, 0x0000ff, 0x808080);
    // polarGridHelper.position.y = 0;
    // polarGridHelper.position.x = 0;
    // polarGridHelper.position.z = 0;
    // scene.add(polarGridHelper);

    //坐标系助手
    axes = new THREE.AxisHelper( 200 );
    scene.add( axes );

    var textureLoader = new THREE.TextureLoader();

    sunTexture = textureLoader.load( '/img/source/sun_texture.jpg' );
    earthTexture = textureLoader.load( '/img/source/earth.jpg' );
    jupiterTexture = textureLoader.load( '/img/source/jupiter_texture.jpg' );
    marsTexture = textureLoader.load( '/img/source/mars_texture.jpg' );
    mercuryTexture = textureLoader.load( '/img/source/mercury_texture.jpg' );
    neptuneTexture = textureLoader.load( '/img/source/neptune_texture.jpg' );
    saturnTexture = textureLoader.load( '/img/source/saturn_texture.jpg' );
    uranusTexture = textureLoader.load( '/img/source/uranus_texture.jpg' );
    venusTexture = textureLoader.load( '/img/source/ven.jpg' );
    moonTexture = textureLoader.load( '/img/source/moon_texture.jpg' );

    //太阳
    sun = creatPlanet( sunTexture, 30 );

    scene.add( sun );

    //水星
    mercury = creatPlanet( mercuryTexture );

    scene.add( mercury );

    track = creatTrack( RUN_RADIUS_MERCURY );

    scene.add( track );

    //金星
    venus = creatPlanet( venusTexture );
    scene.add( venus );

    track = creatTrack( RUN_RADIUS_VENUS );
    scene.add( track );

    //地球
    earth = creatPlanet( earthTexture );
    scene.add( earth );

    track = creatTrack( RUN_RADIUS_EARTH );
    scene.add( track );

    //月球
    moon = creatPlanet( moonTexture, 2 );
    scene.add( moon );

    //火星
    mars = creatPlanet( marsTexture );

    scene.add( mars );

    track = creatTrack( RUN_RADIUS_MARS );

    scene.add( track );

    //木星
    jupiter = creatPlanet( jupiterTexture );

    scene.add( jupiter );

    track = creatTrack( RUN_RADIUS_JUPITER );

    scene.add( track );

    //土星
    saturn = creatPlanet( saturnTexture );

    scene.add( saturn );

    track = creatTrack( RUN_RADIUS_SATURN );

    scene.add( track );

    //天王星
    uranus = creatPlanet( uranusTexture );

    scene.add( uranus );

    track = creatTrack( RUN_RADIUS_URANUS );

    scene.add( track );

    //海王星
    neptune = creatPlanet( neptuneTexture );

    scene.add( neptune );

    track = creatTrack( RUN_RADIUS_NEPTUNE );

    scene.add( track );

    skyBox = makeSkybox( [
        'source/skybox1/px.jpg',
        'source/skybox1/nx.jpg',
        'source/skybox1/py.jpg',
        'source/skybox1/ny.jpg',
        'source/skybox1/pz.jpg',
        'source/skybox1/nz.jpg'

    ], 4000 );

    scene.add( skyBox );

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
    controls.enableZoom = false;

    stats = new Stats();
    container.appendChild( stats.dom );


//
    document.addEventListener( 'mousemove', onDocumentMouseMove, false );

    window.addEventListener( 'resize', onWindowResize, false );

    //test
    var sunCopy = sun.clone( false );

    scene.remove( sun );

    scene.add( sunCopy );
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
    //行星的公转半径

    //对八大行星的公转动画进行编写

    //for test
    // var sunCopy = sun.clone();
    //
    // scene.remove( sun );
    //
    // scene.add( sunCopy );
    //for test

    var timer = Date.now() * 0.001;
    mercury.position.x = Math.cos( timer * Math.pow( 1 / 2, 0 ) ) * RUN_RADIUS_MERCURY;
    mercury.position.z = Math.sin( timer * Math.pow( 1 / 2, 0 ) ) * RUN_RADIUS_MERCURY;

    venus.position.x = Math.cos( timer * Math.pow( 1 / 2, 1 ) ) * RUN_RADIUS_VENUS;
    venus.position.z = Math.sin( timer * Math.pow( 1 / 2, 1 ) ) * RUN_RADIUS_VENUS;

    earth.position.x = Math.cos( timer * Math.pow( 1 / 2, 2 ) ) * RUN_RADIUS_EARTH;
    earth.position.z = Math.sin( timer * Math.pow( 1 / 2, 2 ) ) * RUN_RADIUS_EARTH;

    mars.position.x = Math.cos( timer * Math.pow( 1 / 2, 3 ) ) * RUN_RADIUS_MARS;
    mars.position.z = Math.sin( timer * Math.pow( 1 / 2, 3 ) ) * RUN_RADIUS_MARS;

    jupiter.position.x = Math.cos( timer * Math.pow( 1 / 2, 4 ) ) * RUN_RADIUS_JUPITER;
    jupiter.position.z = Math.sin( timer * Math.pow( 1 / 2, 4 ) ) * RUN_RADIUS_JUPITER;

    saturn.position.x = Math.cos( timer * Math.pow( 1 / 2, 5 ) ) * RUN_RADIUS_SATURN;
    saturn.position.z = Math.sin( timer * Math.pow( 1 / 2, 5 ) ) * RUN_RADIUS_SATURN;

    uranus.position.x = Math.cos( timer * Math.pow( 1 / 2, 6 ) ) * RUN_RADIUS_URANUS;
    uranus.position.z = Math.sin( timer * Math.pow( 1 / 2, 6 ) ) * RUN_RADIUS_URANUS;

    neptune.position.x = Math.cos( timer * Math.pow( 1 / 2, 7 ) ) * RUN_RADIUS_NEPTUNE;
    neptune.position.z = Math.sin( timer * Math.pow( 1 / 2, 7 ) ) * RUN_RADIUS_NEPTUNE;

    moon.position.x = earth.position.x + Math.cos( timer * Math.pow( 1 / 2, 0 ) ) * RUN_RADIUS_MOON;
    moon.position.z = earth.position.z + Math.sin( timer * Math.pow( 1 / 2, 0 ) ) * RUN_RADIUS_MOON;

    //对行星的自传动画进行编写
    sun.rotation.y = (sun.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : sun.rotation.y + 0.0008 * Math.PI);

    mercury.rotation.y = (mercury.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : mercury.rotation.y + 0.0008 * Math.PI);

    venus.rotation.y = (venus.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : venus.rotation.y + 0.0008 * Math.PI);

    earth.rotation.y = (earth.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : earth.rotation.y + 0.0008 * Math.PI);

    mars.rotation.y = (mars.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : mars.rotation.y + 0.0008 * Math.PI);

    jupiter.rotation.y = (jupiter.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : jupiter.rotation.y + 0.0008 * Math.PI);

    saturn.rotation.y = (saturn.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : saturn.rotation.y + 0.0008 * Math.PI);

    uranus.rotation.y = (uranus.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : uranus.rotation.y + 0.0008 * Math.PI);

    neptune.rotation.y = (neptune.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : neptune.rotation.y + 0.0008 * Math.PI);

    moon.rotation.y = (moon.rotation.y == 2 * Math.PI ? 0.008 * Math.PI : moon.rotation.y + 0.0008 * Math.PI);
//        camera.lookAt(system.position);

    //test

    getInformation();

    renderer.render( scene, camera );


}

//添加光线
function initLight() {

    //ambientLight会使得环境中所有的物体都着上指定的光照,贴图也将受影响
    var ambientLight = new THREE.AmbientLight( 0xffffff );
    scene.add( ambientLight );
}

function creatPlanet( planetTexture, size ) {

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

//添加天空盒子
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
    //     if ( intersections[ 0 ] === sun ) {
    //
    //         // console.log( "测试交互" );
    //
    //
    //         // var geometry = new THREE.TextGeometry( 'sun', {
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
    //         // // mesh.position.copy( sun );
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
    // // if ( intersections[ 0 ].object.name === 'sun' ) {

}

function testText( font ) {

    var geometry = new THREE.TextGeometry( 'sun', {

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
    // mesh.position.copy( sun );

    mesh.rotation.x = 0;
    mesh.rotation.y = Math.PI * 2;

    // group = new THREE.Group();
    // group.add(mesh);

    // scene.add(group);
    scene.add( mesh );
    console.log( "添加了太阳的text" );

}
