<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html+CSS实现太阳系轨道</title>
    <style type="text/css">
        .solary{
            width: 800px;
            height: 800px;
            position: relative;
            margin: 0 auto;
            background-color: #000000;
            padding: 0;
            transform: scale(1);
        }

        .sun{
            left:355px;
            top:355px;
            height: 90px;
            width: 90px;
            background-color: rgb(248,107,35);
            border-radius: 50%;
            box-shadow: 5px 5px 10px rgb(248,107,35), -5px -5px 10px rgb(248,107,35), 5px -5px 10px rgb(248,107,35), -5px 5px 10px rgb(248,107,35);
            position: absolute;
            margin: 0;
        }

        .mercuryOrbit{
            left:342.5px;
            top:342.5px;
            height: 115px;
            width: 115px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            margin: 0px;
            padding: 0px;
        }

        .mercury{
            left:337.5px;
            top:395px;
            height: 10px;
            width: 10px;
            background-color: rgb(166,138,56);
            border-radius: 50%;
            position: absolute;
            transform-origin: 62.5px 5px;
            animation: rotate 1.5s infinite linear;
        }

        /*金星*/
        .venus {
            left:309px;
            top:389px;
            height: 22px;
            width: 22px;
            background-color: rgb(246,157,97);
            border-radius: 50%;
            position: absolute;
            transform-origin: 91px 11px;
            animation: rotate 3.84s infinite linear;
        }

        /*金星轨道*/
        .venusOrbit {
            left:320px;
            top:320px;
            height: 160px;
            width: 160px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*地球*/
        .earth {
            left:266.5px;
            top:391px;
            height: 18px;
            width: 18px;
            background-color: rgb(115,114,174);
            border-radius: 50%;
            position: absolute;
            /*transform-origin: 134px 9px;*/
            transform-origin: 40% 20%;
            animation: rotate 6.25s infinite linear;
        }

        /*地球轨道*/
        .earthOrbit {
            left:275px;
            top:275px;
            height: 250px;
            width: 250px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*火星*/
        .mars {
            left:222.5px;
            top:392.5px;
            height: 15px;
            width: 15px;
            background-color: rgb(140,119,63);
            border-radius: 50%;
            position: absolute;
            transform-origin: 177.5px 7.5px;
            animation: rotate 11.75s infinite linear;
        }

        /*火星轨道*/
        .marsOrbit {
            left:230px;
            top:230px;
            height: 340px;
            width: 340px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*木星*/
        .jupiter {
            left:134px;
            top:379px;
            height: 42px;
            width: 42px;
            background-color: rgb(156,164,143);
            border-radius: 50%;
            position: absolute;
            transform-origin: 266px 21px;
            animation: rotate 74.04s infinite linear;
        }

        /*木星轨道*/
        .jupiterOrbit {
            left:155px;
            top:155px;
            height: 490px;
            width: 490px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*土星*/
        .saturn {
            left:92px;
            top:387px;
            height: 26px;
            width: 26px;
            background-color: rgb(215,171,68);
            border-radius: 50%;
            position: absolute;
            transform-origin: 308px 13px;
            animation: rotate 183.92s infinite linear;
        }

        /*土星轨道*/
        .saturnOrbit {
            left:105px;
            top:105px;
            height: 590px;
            width: 590px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*天王星*/
        .uranus {
            left:41.5px;
            top:386.5px;
            height: 27px;
            width: 27px;
            background-color: rgb(164,192,206);
            border-radius: 50%;
            position: absolute;
            transform-origin: 358.5px 13.5px;
            animation: rotate 524.46s infinite linear;
        }

        /*天王星轨道*/
        .uranusOrbit {
            left:55px;
            top:55px;
            height: 690px;
            width: 690px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        /*海王星*/
        .neptune {
            left:10px;
            top:390px;
            height: 20px;
            width: 20px;
            background-color: rgb(133,136,180);
            border-radius: 50%;
            position: absolute;
            transform-origin: 390px 10px;
            animation: rotate 1028.76s infinite linear;
        }

        /*海王星轨道*/
        .neptuneOrbit {
            left:20px;
            top:20px;
            height: 760px;
            width: 760px;
            background-color: transparent;
            border-radius: 50%;
            border-style: dashed;
            border-color: gray;
            position: absolute;
            border-width: 1px;
            /*margin: 100px;*/
            /*transform-origin: -75px -75px;*/
            /*animation: rotate 4s infinite linear;*/
            margin: 0px;
            padding: 0px;
        }

        @keyframes rotate {
            100%{
                transform: rotate(-360deg);
            }
        }
    </style>

</head>
<body>
<div class="solary">
    <div class='sun'></div>

    <!--水星轨道-->
    <div class='mercuryOrbit'></div>

    <!--水星-->
    <div class='mercury'></div>

    <!--金星轨道-->
    <div class='venusOrbit'></div>

    <!--金星-->
    <div class='venus'></div>

    <!--地球轨道-->
    <div class='earthOrbit'></div>

    <!--地球-->
    <div class='earth'></div>

    <!--火星轨道-->
    <div class='marsOrbit'></div>

    <!--火星-->
    <div class='mars'></div>

    <!--木星轨道-->
    <div class='jupiterOrbit'></div>

    <!--木星-->
    <div class='jupiter'></div>

    <!--土星轨道-->
    <div class='saturnOrbit'></div>

    <!--土星-->
    <div class='saturn'></div>

    <!--天王星轨道-->
    <div class='uranusOrbit'></div>

    <!--天王星-->
    <div class='uranus'></div>

    <!--海王星轨道-->
    <div class='neptuneOrbit'></div>

    <!--海王星-->
    <div class='neptune'></div>
</div>
</body>
</html>
