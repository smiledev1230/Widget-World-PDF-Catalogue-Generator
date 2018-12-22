<template>
    <div class="loading-overlay">
        <div class="loading-background"></div>
        <div class="half-circle-spinner">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <span class="loading-title">
                <div id="inTurnFadingTextG_1" class="inTurnFadingTextG">L</div>
                <div id="inTurnFadingTextG_2" class="inTurnFadingTextG">o</div>
                <div id="inTurnFadingTextG_3" class="inTurnFadingTextG">a</div>
                <div id="inTurnFadingTextG_4" class="inTurnFadingTextG">d</div>
                <div id="inTurnFadingTextG_5" class="inTurnFadingTextG">i</div>
                <div id="inTurnFadingTextG_6" class="inTurnFadingTextG">n</div>
                <div id="inTurnFadingTextG_7" class="inTurnFadingTextG">g</div>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'spinner',
    };
</script>

<style lang="scss" scoped>
    .loading-overlay {
        z-index: 9999;
        position: fixed;
        display: flex;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        align-items: center;
        justify-content: center;
    }

    .loading-background {
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        position: absolute;
        background: #fff;
        opacity: .5;
    }

    .half-circle-spinner, .half-circle-spinner * {
        box-sizing: border-box;
    }

    .half-circle-spinner {
        width: 80px;
        height: 80px;
        border-radius: 100%;
        position: relative;
    }

    .half-circle-spinner .circle {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        border: calc(72px / 10) solid transparent;
    }

    .half-circle-spinner .circle.circle-1 {
        border-top-color: #7FFF00;
        animation: half-circle-spinner-animation 1s infinite;
    }

    .half-circle-spinner .circle.circle-2 {
        border-bottom-color: #7FFF00;
        animation: half-circle-spinner-animation 1s infinite alternate;
    }

    @keyframes half-circle-spinner-animation {
        0% {
            transform: rotate(0deg);

        }
        100% {
            transform: rotate(360deg);
        }
    }

    .loading-title {
        position: absolute;
        top: 32px;
        left: 12px;
        text-transform: uppercase;
        animation: loading 8s linear;
    }

    .inTurnFadingTextG{
        color: #7FFF00;
        font-size:12px;
        text-decoration:none;
        font-weight:normal;
        font-style:normal;
        float:left;
        animation-name:bounce_inTurnFadingTextG;
        -o-animation-name:bounce_inTurnFadingTextG;
        -ms-animation-name:bounce_inTurnFadingTextG;
        -webkit-animation-name:bounce_inTurnFadingTextG;
        -moz-animation-name:bounce_inTurnFadingTextG;
        animation-duration:2.09s;
        -o-animation-duration:2.09s;
        -ms-animation-duration:2.09s;
        -webkit-animation-duration:2.09s;
        -moz-animation-duration:2.09s;
        animation-iteration-count:infinite;
        -o-animation-iteration-count:infinite;
        -ms-animation-iteration-count:infinite;
        -webkit-animation-iteration-count:infinite;
        -moz-animation-iteration-count:infinite;
        animation-direction:normal;
        -o-animation-direction:normal;
        -ms-animation-direction:normal;
        -webkit-animation-direction:normal;
        -moz-animation-direction:normal;
    }

    #inTurnFadingTextG_1{
        animation-delay:0.75s;
        -o-animation-delay:0.75s;
        -ms-animation-delay:0.75s;
        -webkit-animation-delay:0.75s;
        -moz-animation-delay:0.75s;
    }
    #inTurnFadingTextG_2{
        animation-delay:0.9s;
        -o-animation-delay:0.9s;
        -ms-animation-delay:0.9s;
        -webkit-animation-delay:0.9s;
        -moz-animation-delay:0.9s;
    }
    #inTurnFadingTextG_3{
        animation-delay:1.05s;
        -o-animation-delay:1.05s;
        -ms-animation-delay:1.05s;
        -webkit-animation-delay:1.05s;
        -moz-animation-delay:1.05s;
    }
    #inTurnFadingTextG_4{
        animation-delay:1.2s;
        -o-animation-delay:1.2s;
        -ms-animation-delay:1.2s;
        -webkit-animation-delay:1.2s;
        -moz-animation-delay:1.2s;
    }
    #inTurnFadingTextG_5{
        animation-delay:1.35s;
        -o-animation-delay:1.35s;
        -ms-animation-delay:1.35s;
        -webkit-animation-delay:1.35s;
        -moz-animation-delay:1.35s;
    }
    #inTurnFadingTextG_6{
        animation-delay:1.5s;
        -o-animation-delay:1.5s;
        -ms-animation-delay:1.5s;
        -webkit-animation-delay:1.5s;
        -moz-animation-delay:1.5s;
    }
    #inTurnFadingTextG_7{
        animation-delay:1.64s;
        -o-animation-delay:1.64s;
        -ms-animation-delay:1.64s;
        -webkit-animation-delay:1.64s;
        -moz-animation-delay:1.64s;
    }

    @keyframes bounce_inTurnFadingTextG{
        0%{
            color:rgb(255, 255, 255);
        }

        100%{
            color:rgb(117, 255, 0);
        }
    }

    @-o-keyframes bounce_inTurnFadingTextG{
        0%{
            color:rgb(255, 255, 255);
        }

        100%{
            color:rgb(117, 255, 0);
        }
    }

    @-ms-keyframes bounce_inTurnFadingTextG{
        0%{
            color:rgb(255, 255, 255);
        }

        100%{
            color:rgb(117, 255, 0);
        }
    }

    @-webkit-keyframes bounce_inTurnFadingTextG{
        0%{
            color:rgb(255, 255, 255);
        }

        100%{
            color:rgb(117, 255, 0);
        }
    }

    @-moz-keyframes bounce_inTurnFadingTextG{
        0%{
            color:rgb(255, 255, 255);
        }

        100%{
            color:rgb(117, 255, 0);
        }
    }
</style>
