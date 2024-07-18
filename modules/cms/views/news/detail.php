<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="keywords" content="海角社区">
    <meta name="description" content="海角社区">
    <link rel="icon" href="/images/common/project/favicon.ico">
    <link rel="stylesheet" href="/hj/css/webuploader.css">
    <style>#initializeView {
            position: fixed;
            z-index: 999998;
            height: 100%;
            width: 100%;
            background-size: cover;
        }

        #initializeView div.centerBar.center {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        #initializeView div.centerBar.center h1 {
            text-align: center;
            font-size: 24px;
        }

        #initializeView div.centerBar .mainExample {
            padding: 100px 0;
            text-align: center;
        }

        #initializeView div.centerBar .copyright {
            display: flex;
            align-items: center;
            text-align: center;
            color: rgba(0, 0, 0, 0.45);
            font-size: 12px;
        }

        #initializeView div.centerBar .copyright > div {
            display: inline-block;
            margin-right: 0.75rem;
            width: 16px;
            height: 16px;
        }

        #initializeView div.centerBar .copyright > div .logo {
            max-width: 100%;
        }

        /*这里是加载动画。*/
        .ant-spin {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            color: rgba(0, 0, 0, 0.65);
            font-size: 14px;
            font-variant: tabular-nums;
            line-height: 1.5;
            list-style: none;
            font-feature-settings: 'tnum';
            position: absolute;
            display: none;
            color: #1890ff;
            text-align: center;
            vertical-align: middle;
            opacity: 0;
            transition: transform 0.3s cubic-bezier(0.78, 0.14, 0.15, 0.86);
        }

        .ant-spin-spinning {
            position: static;
            display: inline-block;
            opacity: 1;
        }

        .ant-spin-nested-loading {
            position: relative;
        }

        .ant-spin-nested-loading > div > .ant-spin {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 4;
            display: block;
            width: 100%;
            height: 100%;
            max-height: 400px;
        }

        .ant-spin-nested-loading > div > .ant-spin .ant-spin-dot {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -10px;
        }

        .ant-spin-nested-loading > div > .ant-spin .ant-spin-text {
            position: absolute;
            top: 50%;
            width: 100%;
            padding-top: 5px;
            text-shadow: 0 1px 2px #fff;
        }

        .ant-spin-nested-loading > div > .ant-spin.ant-spin-show-text .ant-spin-dot {
            margin-top: -20px;
        }

        .ant-spin-nested-loading > div > .ant-spin-sm .ant-spin-dot {
            margin: -7px;
        }

        .ant-spin-nested-loading > div > .ant-spin-sm .ant-spin-text {
            padding-top: 2px;
        }

        .ant-spin-nested-loading > div > .ant-spin-sm.ant-spin-show-text .ant-spin-dot {
            margin-top: -17px;
        }

        .ant-spin-nested-loading > div > .ant-spin-lg .ant-spin-dot {
            margin: -16px;
        }

        .ant-spin-nested-loading > div > .ant-spin-lg .ant-spin-text {
            padding-top: 11px;
        }

        .ant-spin-nested-loading > div > .ant-spin-lg.ant-spin-show-text .ant-spin-dot {
            margin-top: -26px;
        }

        .ant-spin-container {
            position: relative;
            transition: opacity 0.3s;
        }

        .ant-spin-container::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            display: none \9;
            width: 100%;
            height: 100%;
            background: #fff;
            opacity: 0;
            transition: all 0.3s;
            content: '';
            pointer-events: none;
        }

        /* .ant-spin-blur {clear: both;overflow: hidden;opacity: 0.5;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;pointer-events: none;} */
        .ant-spin-blur::after {
            opacity: 0.4;
            pointer-events: auto;
        }

        .ant-spin-tip {
            color: rgba(0, 0, 0, 0.45);
        }

        .ant-spin-dot {
            position: relative;
            display: inline-block;
            font-size: 20px;
            width: 1em;
            height: 1em;
        }

        .ant-spin-dot-item {
            position: absolute;
            display: block;
            width: 9px;
            height: 9px;
            background-color: #1890ff;
            border-radius: 100%;
            transform: scale(0.75);
            transform-origin: 50% 50%;
            opacity: 0.3;
            -webkit-animation: antSpinMove 1s infinite linear alternate;
            animation: antSpinMove 1s infinite linear alternate;
        }

        .ant-spin-dot-item:nth-child(1) {
            top: 0;
            left: 0;
        }

        .ant-spin-dot-item:nth-child(2) {
            top: 0;
            right: 0;
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        .ant-spin-dot-item:nth-child(3) {
            right: 0;
            bottom: 0;
            -webkit-animation-delay: 0.8s;
            animation-delay: 0.8s;
        }

        .ant-spin-dot-item:nth-child(4) {
            bottom: 0;
            left: 0;
            -webkit-animation-delay: 1.2s;
            animation-delay: 1.2s;
        }

        .ant-spin-dot-spin {
            transform: rotate(45deg);
            -webkit-animation: antRotate 1.2s infinite linear;
            animation: antRotate 1.2s infinite linear;
        }

        .ant-spin-sm .ant-spin-dot {
            font-size: 14px;
        }

        .ant-spin-sm .ant-spin-dot i {
            width: 6px;
            height: 6px;
        }

        .ant-spin-lg .ant-spin-dot {
            font-size: 32px;
        }

        .ant-spin-lg .ant-spin-dot i {
            width: 14px;
            height: 14px;
        }

        .ant-spin.ant-spin-show-text .ant-spin-text {
            display: block;
        }

        @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
            .ant-spin-blur {
                background: #fff;
                opacity: 0.5;
            }
        }

        @-webkit-keyframes antSpinMove {
            to {
                opacity: 1;
            }
        }

        @keyframes antSpinMove {
            to {
                opacity: 1;
            }
        }

        @-webkit-keyframes antRotate {
            to {
                transform: rotate(405deg);
            }
        }

        @keyframes antRotate {
            to {
                transform: rotate(405deg);
            }
        }

        #fixed_bg {
            top: 0;
            left: 0;
            z-index: -1;
            background: url('/images/common/filter-bg.jpg') center center no-repeat;
            background-size: 100% 100%;
        }</style>
    <title></title>
    <link href="/hj/css/app.2a50d195.css" rel="preload" as="style">
    <link href="/hj/css/chunk-vendors.d5d4ee22.css" rel="preload" as="style">
    <link href="/hj/js/app.a845670c.js" rel="preload" as="script">
    <link href="/hj/js/chunk-vendors.aa431b3e.js" rel="preload" as="script">
    <link href="/hj/css/chunk-vendors.d5d4ee22.css" rel="stylesheet">
    <link href="/hj/css/app.2a50d195.css" rel="stylesheet">
</head>
<body id="body">
<div id="initializeView" class="bg">
    <div class="centerBar center">
        <div class="mainExample">
            <div class="ant-spin ant-spin-lg ant-spin-spinning"><span class="ant-spin-dot ant-spin-dot-spin"><i
                            class="ant-spin-dot-item"></i> <i class="ant-spin-dot-item"></i> <i
                            class="ant-spin-dot-item"></i> <i class="ant-spin-dot-item"></i></span></div>
        </div>
    </div>
</div>
<div id="app"><?=$model['content']?></div>
<script src="/hj/js/jquery-3.6.0.min.js"></script>
<script src="/hj/js/webuploader.min.js"></script>
<script src="/hj/js/DPlayer.min.js"></script>
<script src="/hj/js/hls.min.js"></script>
<script src="/hj/js/chunk-vendors.aa431b3e.js"></script>
<script src="/hj/js/app.a845670c.js"></script>
</body>
</html>