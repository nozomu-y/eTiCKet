@extends('layouts.main')
@section('title', __('qrreader'))

@section('style')
    <style>
        video {
            width: 100% !important;
            border-radius: 0.5rem !important;
        }

    </style>
@endsection

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('qrreader') }}</h1>
    <div class="row">
        <div class="col-12">
            <section id="qrreader">
                <video class="shadow mb-3" id="camera" muted autoplay playsinline></video>
                <canvas id="picture" hidden></canvas>
            </section>
            <form action="{{ route('post_qrreader') }}" method="POST" name="QRPost">
                @csrf
                <input type="hidden" name="data" value="" />
            </form>
            <a class="btn btn-primary" href="{{ route('qrcode_unreadable') }}">{{ __('qrcode_unreadable') }}</a>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/jsQR.js') }}"></script>
    <script>
        if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
            alert("このブラウザーは未対応です");
            exit();
        }

        const video = document.querySelector("#camera");
        const canvas = document.querySelector("#picture");
        const ctx = canvas.getContext("2d");

        window.onload = () => {
            /** カメラ設定 */
            const constraints = {
                audio: false,
                video: {
                    width: 300,
                    height: 200,
                    facingMode: "environment" // 背面カメラを利用する
                    // facingMode: "user" // フロントカメラを利用する
                }
            };

            /** sync camera and <video> tag **/
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(function(stream) {
                    video.srcObject = stream;
                    video.onloadedmetadata = function(e) {
                        video.play();
                        checkPicture();
                    };
                })
                .catch(function(err) {
                    console.log(err.name + ": " + err.message);
                });
        };

        /*
         * QRコードの読み取り
         */
        function checkPicture() {
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);

            // QRコードが存在する場合
            if (code) {
                sendQRResult(code.data);
            } else {
                setTimeout(
                    function() {
                        checkPicture();
                    }.bind(this),
                    300
                );
            }
        }

        function sendQRResult(data) {
            var f = document.forms["QRPost"];
            f.data.value = data;
            f.submit();
        }
    </script>
@endsection
