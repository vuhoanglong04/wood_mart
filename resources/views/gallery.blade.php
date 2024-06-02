@extends('layout.main')
@section('content')
    <style>
        .vbox-overlay {
            --vbox-tools-color: #fff;
            --vbox-title-background: #101010;
            --vbox-title-width: 'auto';
            --vbox-title-radius: 0;
            --vbox-share-background: #101010;
            --vbox-share-width: 'auto';
            --vbox-share-radius: 0;
            --vbox-padding: 0;
            --vbox-max-width: 100%
        }

        .vbox-overlay *,
        .vbox-overlay :after,
        .vbox-overlay :before {
            -webkit-backface-visibility: hidden;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box
        }

        .vbox-overlay * {
            -webkit-backface-visibility: visible;
            backface-visibility: visible
        }

        .vbox-overlay {
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            flex-direction: column;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-align-items: center;
            align-items: center;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 999999
        }

        .vbox-share,
        .vbox-title {
            line-height: 1;
            position: fixed;
            z-index: 98;
            text-align: center;
            margin: 0 auto;
            color: var(--vbox-tools-color)
        }

        .vbox-title {
            font-size: 12px;
            background-color: var(--vbox-title-background);
            width: var(--vbox-title-width);
            border-radius: var(--vbox-title-radius);
            padding: 12px 54px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block
        }

        .vbox-share {
            font-size: 24px;
            padding: 0 .35em;
            background-color: var(--vbox-share-background);
            width: var(--vbox-share-width);
            border-radius: var(--vbox-share-radius)
        }

        .vbox-link-btn,
        button.vbox-link-btn,
        button.vbox-link-btn:active,
        button.vbox-link-btn:focus,
        button.vbox-link-btn:hover {
            border: none !important;
            background: 0 0 !important;
            box-shadow: none !important;
            color: inherit !important;
            padding: 6px 12px;
            outline: 0;
            display: inline-block;
            cursor: pointer
        }

        .vbox-share a {
            color: inherit !important;
            padding: 6px 12px;
            display: inline-block
        }

        .vbox-share svg {
            z-index: 10;
            vertical-align: middle
        }

        .vbox-close {
            cursor: pointer;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 99;
            padding: 6px 15px;
            color: #000;
            color: var(--vbox-tools-color);
            border: 0;
            font-size: 24px;
            display: flex;
            align-items: center;
            opacity: .8;
            transition: opacity .2s
        }

        .vbox-close:hover {
            opacity: 1
        }

        .vbox-left-corner {
            cursor: pointer;
            position: fixed;
            left: 0;
            top: 0;
            overflow: hidden;
            line-height: 1;
            font-size: 12px;
            z-index: 99;
            display: flex;
            align-items: center;
            color: var(--vbox-tools-color)
        }

        .vbox-num {
            display: inline-block;
            padding: 12px 15px
        }

        .vbox-left {
            left: 0
        }

        .vbox-right {
            right: 0
        }

        .vbox-top {
            top: 0
        }

        .vbox-bottom {
            bottom: 0
        }

        .vbox-next,
        .vbox-prev {
            position: fixed;
            top: 50%;
            margin-top: -15px;
            overflow: hidden;
            cursor: pointer;
            display: block;
            width: 45px;
            height: 45px;
            z-index: 99;
            opacity: .8;
            transition: opacity .2s
        }

        .vbox-next:hover,
        .vbox-prev:hover {
            opacity: 1
        }

        .vbox-next span,
        .vbox-prev span {
            position: relative;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top-color: var(--vbox-tools-color);
            border-right-color: var(--vbox-tools-color);
            text-indent: -100px;
            position: absolute;
            top: 8px;
            display: block
        }

        .vbox-prev {
            left: 15px
        }

        .vbox-next {
            right: 15px
        }

        .vbox-prev span {
            left: 10px;
            -ms-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg)
        }

        .vbox-next span {
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            right: 10px
        }

        .vbox-open {
            overflow: hidden
        }

        .vbox-container {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            overflow-x: hidden;
            overflow-y: scroll;
            overflow-scrolling: touch;
            -webkit-overflow-scrolling: touch;
            z-index: 20;
            max-height: 100%;
            padding: 30px 0
        }

        .vbox-content {
            opacity: 0;
            text-align: center;
            width: 100%;
            position: relative;
            overflow: hidden;
            padding: 0 4%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100%
        }

        .vbox-container img {
            max-width: 100%;
            height: auto
        }

        .vbox-child {
            box-shadow: 0 0 12px rgba(0, 0, 0, .19), 0 6px 6px rgba(0, 0, 0, .23);
            max-width: var(--vbox-max-width);
            text-align: initial;
            padding: var(--vbox-padding)
        }

        .vbox-child img {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -o-user-select: none;
            user-select: none;
            display: block
        }

        .vbox-fit .vbox-child img,
        .vbox-fit .vbox-child.venoratio {
            max-height: calc(100vh - 60px)
        }

        .vbox-inline,
        .venoratio {
            position: relative;
            width: 100%;
            margin: 0 auto
        }

        .venoratio::before {
            display: block;
            padding-top: var(--vb-aspect-ratio);
            content: ""
        }

        .venoratio>* {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: var(--vbox-padding)
        }

        .venoratio-1x1 {
            --vb-aspect-ratio: 100%;
            max-width: calc(min(var(--vbox-max-width), (100vh - 60px)))
        }

        .venoratio-4x3.vbox-child.venoratio {
            --vb-aspect-ratio: calc(3 / 4 * 100%);
            max-width: calc(min(var(--vbox-max-width), (100vh - 60px) * 4 / 3))
        }

        .venoratio-16x9.vbox-child.venoratio {
            --vb-aspect-ratio: calc(9 / 16 * 100%);
            max-width: calc(min(var(--vbox-max-width), (100vh - 60px) * 16 / 9))
        }

        .venoratio-21x9.vbox-child.venoratio {
            --vb-aspect-ratio: calc(9 / 21 * 100%);
            max-width: calc(min(var(--vbox-max-width), (100vh - 60px) * 21 / 9))
        }

        .venoratio-full {
            --vb-aspect-ratio: calc(100vh - 60px)
        }

        .vbox-grab .vbox-child img {
            cursor: grab
        }

        .vbox-child>iframe {
            border: none !important
        }

        .vbox-content.swipe-left {
            margin-left: -200px !important
        }

        .vbox-content.swipe-right {
            margin-left: 200px !important
        }

        .vbox-preloader {
            -webkit-transform: translateZ(0);
            -moz-transform: translateZ(0);
            -o-transform: translateZ(0);
            transform: translateZ(0)
        }

        .vbox-preloader .vbox-preloader-inner {
            opacity: 1;
            transition: opacity .2s
        }

        .vbox-hidden {
            display: none
        }

        .vbox-preloader.vbox-hidden .vbox-preloader-inner {
            opacity: 0
        }

        .vbox-backdrop {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            -webkit-transform: translateZ(-1px);
            -moz-transform: translateZ(-1px);
            -o-transform: translateZ(-1px);
            transform: translateZ(-1px);
            z-index: 0
        }

        .vbox-tooltip {
            position: relative;
            display: inline-block
        }

        .vbox-tooltip .vbox-tooltip-text {
            visibility: hidden;
            color: #fff;
            text-align: center;
            padding: 0;
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 0;
            opacity: 0;
            transition: opacity .3s;
            margin-bottom: 2px;
            font-family: sans-serif
        }

        .vbox-top .vbox-tooltip .vbox-tooltip-text {
            bottom: auto;
            top: 100%;
            margin-bottom: 0;
            margin-top: 2px
        }

        .vbox-tooltip-inner {
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, .9);
            border-radius: 6px;
            font-size: 10px
        }

        .vbox-tooltip:hover .vbox-tooltip-text {
            visibility: visible;
            opacity: 1
        }

        .vbox-overlay {
            --sk-size: 40px;
            --sk-color: #333
        }

        .sk-center {
            margin: auto
        }

        .sk-plane {
            width: var(--sk-size);
            height: var(--sk-size);
            background-color: var(--sk-color);
            animation: sk-plane 1.2s infinite ease-in-out
        }

        @keyframes sk-plane {
            0% {
                transform: perspective(120px) rotateX(0) rotateY(0)
            }

            50% {
                transform: perspective(120px) rotateX(-180.1deg) rotateY(0)
            }

            100% {
                transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg)
            }
        }

        .sk-chase {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative;
            animation: sk-chase 2.5s infinite linear both
        }

        .sk-chase-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            animation: sk-chase-dot 2s infinite ease-in-out both
        }

        .sk-chase-dot:before {
            content: '';
            display: block;
            width: 25%;
            height: 25%;
            background-color: var(--sk-color);
            border-radius: 100%;
            animation: sk-chase-dot-before 2s infinite ease-in-out both
        }

        .sk-chase-dot:nth-child(1) {
            animation-delay: -1.1s
        }

        .sk-chase-dot:nth-child(2) {
            animation-delay: -1s
        }

        .sk-chase-dot:nth-child(3) {
            animation-delay: -.9s
        }

        .sk-chase-dot:nth-child(4) {
            animation-delay: -.8s
        }

        .sk-chase-dot:nth-child(5) {
            animation-delay: -.7s
        }

        .sk-chase-dot:nth-child(6) {
            animation-delay: -.6s
        }

        .sk-chase-dot:nth-child(1):before {
            animation-delay: -1.1s
        }

        .sk-chase-dot:nth-child(2):before {
            animation-delay: -1s
        }

        .sk-chase-dot:nth-child(3):before {
            animation-delay: -.9s
        }

        .sk-chase-dot:nth-child(4):before {
            animation-delay: -.8s
        }

        .sk-chase-dot:nth-child(5):before {
            animation-delay: -.7s
        }

        .sk-chase-dot:nth-child(6):before {
            animation-delay: -.6s
        }

        @keyframes sk-chase {
            100% {
                transform: rotate(360deg)
            }
        }

        @keyframes sk-chase-dot {

            100%,
            80% {
                transform: rotate(360deg)
            }
        }

        @keyframes sk-chase-dot-before {
            50% {
                transform: scale(.4)
            }

            0%,
            100% {
                transform: scale(1)
            }
        }

        .sk-bounce {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative
        }

        .sk-bounce-dot {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: var(--sk-color);
            opacity: .6;
            position: absolute;
            top: 0;
            left: 0;
            animation: sk-bounce 2s infinite cubic-bezier(.455, .03, .515, .955)
        }

        .sk-bounce-dot:nth-child(2) {
            animation-delay: -1s
        }

        @keyframes sk-bounce {

            0%,
            100% {
                transform: scale(0)
            }

            45%,
            55% {
                transform: scale(1)
            }
        }

        .sk-wave {
            width: var(--sk-size);
            height: var(--sk-size);
            display: flex;
            justify-content: space-between
        }

        .sk-wave-rect {
            background-color: var(--sk-color);
            height: 100%;
            width: 15%;
            animation: sk-wave 1.2s infinite ease-in-out
        }

        .sk-wave-rect:nth-child(1) {
            animation-delay: -1.2s
        }

        .sk-wave-rect:nth-child(2) {
            animation-delay: -1.1s
        }

        .sk-wave-rect:nth-child(3) {
            animation-delay: -1s
        }

        .sk-wave-rect:nth-child(4) {
            animation-delay: -.9s
        }

        .sk-wave-rect:nth-child(5) {
            animation-delay: -.8s
        }

        @keyframes sk-wave {

            0%,
            100%,
            40% {
                transform: scaleY(.4)
            }

            20% {
                transform: scaleY(1)
            }
        }

        .sk-pulse {
            width: var(--sk-size);
            height: var(--sk-size);
            background-color: var(--sk-color);
            border-radius: 100%;
            animation: sk-pulse 1.2s infinite cubic-bezier(.455, .03, .515, .955)
        }

        @keyframes sk-pulse {
            0% {
                transform: scale(0)
            }

            100% {
                transform: scale(1);
                opacity: 0
            }
        }

        .sk-flow {
            width: calc(var(--sk-size) * 1.3);
            height: calc(var(--sk-size) * 1.3);
            display: flex;
            justify-content: space-between
        }

        .sk-flow-dot {
            width: 25%;
            height: 25%;
            background-color: var(--sk-color);
            border-radius: 50%;
            animation: sk-flow 1.4s cubic-bezier(.455, .03, .515, .955) 0s infinite both
        }

        .sk-flow-dot:nth-child(1) {
            animation-delay: -.3s
        }

        .sk-flow-dot:nth-child(2) {
            animation-delay: -.15s
        }

        @keyframes sk-flow {

            0%,
            100%,
            80% {
                transform: scale(.3)
            }

            40% {
                transform: scale(1)
            }
        }

        .sk-swing {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative;
            animation: sk-swing 1.8s infinite linear
        }

        .sk-swing-dot {
            width: 45%;
            height: 45%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            background-color: var(--sk-color);
            border-radius: 100%;
            animation: sk-swing-dot 2s infinite ease-in-out
        }

        .sk-swing-dot:nth-child(2) {
            top: auto;
            bottom: 0;
            animation-delay: -1s
        }

        @keyframes sk-swing {
            100% {
                transform: rotate(360deg)
            }
        }

        @keyframes sk-swing-dot {

            0%,
            100% {
                transform: scale(.2)
            }

            50% {
                transform: scale(1)
            }
        }

        .sk-circle {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative
        }

        .sk-circle-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0
        }

        .sk-circle-dot:before {
            content: '';
            display: block;
            width: 15%;
            height: 15%;
            background-color: var(--sk-color);
            border-radius: 100%;
            animation: sk-circle 1.2s infinite ease-in-out both
        }

        .sk-circle-dot:nth-child(1) {
            transform: rotate(30deg)
        }

        .sk-circle-dot:nth-child(2) {
            transform: rotate(60deg)
        }

        .sk-circle-dot:nth-child(3) {
            transform: rotate(90deg)
        }

        .sk-circle-dot:nth-child(4) {
            transform: rotate(120deg)
        }

        .sk-circle-dot:nth-child(5) {
            transform: rotate(150deg)
        }

        .sk-circle-dot:nth-child(6) {
            transform: rotate(180deg)
        }

        .sk-circle-dot:nth-child(7) {
            transform: rotate(210deg)
        }

        .sk-circle-dot:nth-child(8) {
            transform: rotate(240deg)
        }

        .sk-circle-dot:nth-child(9) {
            transform: rotate(270deg)
        }

        .sk-circle-dot:nth-child(10) {
            transform: rotate(300deg)
        }

        .sk-circle-dot:nth-child(11) {
            transform: rotate(330deg)
        }

        .sk-circle-dot:nth-child(1):before {
            animation-delay: -1.1s
        }

        .sk-circle-dot:nth-child(2):before {
            animation-delay: -1s
        }

        .sk-circle-dot:nth-child(3):before {
            animation-delay: -.9s
        }

        .sk-circle-dot:nth-child(4):before {
            animation-delay: -.8s
        }

        .sk-circle-dot:nth-child(5):before {
            animation-delay: -.7s
        }

        .sk-circle-dot:nth-child(6):before {
            animation-delay: -.6s
        }

        .sk-circle-dot:nth-child(7):before {
            animation-delay: -.5s
        }

        .sk-circle-dot:nth-child(8):before {
            animation-delay: -.4s
        }

        .sk-circle-dot:nth-child(9):before {
            animation-delay: -.3s
        }

        .sk-circle-dot:nth-child(10):before {
            animation-delay: -.2s
        }

        .sk-circle-dot:nth-child(11):before {
            animation-delay: -.1s
        }

        @keyframes sk-circle {

            0%,
            100%,
            80% {
                transform: scale(0)
            }

            40% {
                transform: scale(1)
            }
        }

        .sk-circle-fade {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative
        }

        .sk-circle-fade-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0
        }

        .sk-circle-fade-dot:before {
            content: '';
            display: block;
            width: 15%;
            height: 15%;
            background-color: var(--sk-color);
            border-radius: 100%;
            animation: sk-circle-fade 1.2s infinite ease-in-out both
        }

        .sk-circle-fade-dot:nth-child(1) {
            transform: rotate(30deg)
        }

        .sk-circle-fade-dot:nth-child(2) {
            transform: rotate(60deg)
        }

        .sk-circle-fade-dot:nth-child(3) {
            transform: rotate(90deg)
        }

        .sk-circle-fade-dot:nth-child(4) {
            transform: rotate(120deg)
        }

        .sk-circle-fade-dot:nth-child(5) {
            transform: rotate(150deg)
        }

        .sk-circle-fade-dot:nth-child(6) {
            transform: rotate(180deg)
        }

        .sk-circle-fade-dot:nth-child(7) {
            transform: rotate(210deg)
        }

        .sk-circle-fade-dot:nth-child(8) {
            transform: rotate(240deg)
        }

        .sk-circle-fade-dot:nth-child(9) {
            transform: rotate(270deg)
        }

        .sk-circle-fade-dot:nth-child(10) {
            transform: rotate(300deg)
        }

        .sk-circle-fade-dot:nth-child(11) {
            transform: rotate(330deg)
        }

        .sk-circle-fade-dot:nth-child(1):before {
            animation-delay: -1.1s
        }

        .sk-circle-fade-dot:nth-child(2):before {
            animation-delay: -1s
        }

        .sk-circle-fade-dot:nth-child(3):before {
            animation-delay: -.9s
        }

        .sk-circle-fade-dot:nth-child(4):before {
            animation-delay: -.8s
        }

        .sk-circle-fade-dot:nth-child(5):before {
            animation-delay: -.7s
        }

        .sk-circle-fade-dot:nth-child(6):before {
            animation-delay: -.6s
        }

        .sk-circle-fade-dot:nth-child(7):before {
            animation-delay: -.5s
        }

        .sk-circle-fade-dot:nth-child(8):before {
            animation-delay: -.4s
        }

        .sk-circle-fade-dot:nth-child(9):before {
            animation-delay: -.3s
        }

        .sk-circle-fade-dot:nth-child(10):before {
            animation-delay: -.2s
        }

        .sk-circle-fade-dot:nth-child(11):before {
            animation-delay: -.1s
        }

        @keyframes sk-circle-fade {

            0%,
            100%,
            39% {
                opacity: 0;
                transform: scale(.6)
            }

            40% {
                opacity: 1;
                transform: scale(1)
            }
        }

        .sk-grid {
            width: var(--sk-size);
            height: var(--sk-size)
        }

        .sk-grid-cube {
            width: 33.33%;
            height: 33.33%;
            background-color: var(--sk-color);
            float: left;
            animation: sk-grid 1.3s infinite ease-in-out
        }

        .sk-grid-cube:nth-child(1) {
            animation-delay: .2s
        }

        .sk-grid-cube:nth-child(2) {
            animation-delay: .3s
        }

        .sk-grid-cube:nth-child(3) {
            animation-delay: .4s
        }

        .sk-grid-cube:nth-child(4) {
            animation-delay: .1s
        }

        .sk-grid-cube:nth-child(5) {
            animation-delay: .2s
        }

        .sk-grid-cube:nth-child(6) {
            animation-delay: .3s
        }

        .sk-grid-cube:nth-child(7) {
            animation-delay: 0s
        }

        .sk-grid-cube:nth-child(8) {
            animation-delay: .1s
        }

        .sk-grid-cube:nth-child(9) {
            animation-delay: .2s
        }

        @keyframes sk-grid {

            0%,
            100%,
            70% {
                transform: scale3D(1, 1, 1)
            }

            35% {
                transform: scale3D(0, 0, 1)
            }
        }

        .sk-fold {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative;
            transform: rotateZ(45deg)
        }

        .sk-fold-cube {
            float: left;
            width: 50%;
            height: 50%;
            position: relative;
            transform: scale(1.1)
        }

        .sk-fold-cube:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--sk-color);
            animation: sk-fold 2.4s infinite linear both;
            transform-origin: 100% 100%
        }

        .sk-fold-cube:nth-child(2) {
            transform: scale(1.1) rotateZ(90deg)
        }

        .sk-fold-cube:nth-child(4) {
            transform: scale(1.1) rotateZ(180deg)
        }

        .sk-fold-cube:nth-child(3) {
            transform: scale(1.1) rotateZ(270deg)
        }

        .sk-fold-cube:nth-child(2):before {
            animation-delay: .3s
        }

        .sk-fold-cube:nth-child(4):before {
            animation-delay: .6s
        }

        .sk-fold-cube:nth-child(3):before {
            animation-delay: .9s
        }

        @keyframes sk-fold {

            0%,
            10% {
                transform: perspective(140px) rotateX(-180deg);
                opacity: 0
            }

            25%,
            75% {
                transform: perspective(140px) rotateX(0);
                opacity: 1
            }

            100%,
            90% {
                transform: perspective(140px) rotateY(180deg);
                opacity: 0
            }
        }

        .sk-wander {
            width: var(--sk-size);
            height: var(--sk-size);
            position: relative
        }

        .sk-wander-cube {
            background-color: var(--sk-color);
            width: 20%;
            height: 20%;
            position: absolute;
            top: 0;
            left: 0;
            --sk-wander-distance: calc(var(--sk-size) * 0.75);
            animation: sk-wander 2s ease-in-out -2s infinite both
        }

        .sk-wander-cube:nth-child(2) {
            animation-delay: -.5s
        }

        .sk-wander-cube:nth-child(3) {
            animation-delay: -1s
        }

        @keyframes sk-wander {
            0% {
                transform: rotate(0)
            }

            25% {
                transform: translateX(var(--sk-wander-distance)) rotate(-90deg) scale(.6)
            }

            50% {
                transform: translateX(var(--sk-wander-distance)) translateY(var(--sk-wander-distance)) rotate(-179deg)
            }

            50.1% {
                transform: translateX(var(--sk-wander-distance)) translateY(var(--sk-wander-distance)) rotate(-180deg)
            }

            75% {
                transform: translateX(0) translateY(var(--sk-wander-distance)) rotate(-270deg) scale(.6)
            }

            100% {
                transform: rotate(-360deg)
            }
        }

        /*# sourceMappingURL=venobox.min.css.map */
    </style>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Gallery</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Gallery</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Products</h5>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">
                        @foreach ($imageProducts as $item)
                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                <a class="card-gallery my-link" data-gall="myGallery" href="{{ $item->product_theme }}">
                                    <img class="img-fluid" src="{{ $item->product_theme }}" alt="Card image">

                                </a>
                            </div>
                        @endforeach
                        @foreach ($imageVariant as $item)
                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                <a class="card-gallery my-link" data-gall="myGallery" href="{{ $item->img }}">
                                    <img class="img-fluid" src="{{ $item->img }}" alt="Card image">

                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Users</h5>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">

                        @foreach ($imageUser as $item)
                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                <a class="card-gallery my-link" data-gall="myGallery" href="{{ $item->img }}">
                                    <img class="img-fluid" src="{{ $item->img }}" alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Category</h5>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">
                        @foreach ($imageCategory as $item)
                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                <a class="card-gallery my-link" data-gall="myGallery" href="{{ $item->background }}">
                                    <img class="img-fluid" src="{{ $item->background }}" alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Posts</h5>
                </div>
                <div class="card-body">
                    <div class="grid row g-3">
                        @foreach ($imagePosts as $item)
                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                <a class="card-gallery my-link" data-gall="myGallery" href="{{ $item->theme }}">
                                    <img class="img-fluid" src="{{ $item->theme }}" alt="Card image">
                                    <div class="gallery-hover-data card-body justify-content-end">

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        new VenoBox({
            selector: ".my-link",
            navigation: 'true',
            fitView: 'true',
            spinner: 'grid',
            infinigall: 'true',
            maxWidth: '100%'
        });
    </script>
@endpush
