<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant['name'] }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">{{ $restaurant['name'] }}</h2>
            </div>
            <div class="card-body">
                <!-- メイン情報 -->
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ $restaurant['photo']['mobile']['l'] }}" alt="{{ $restaurant['name'] }}" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <p><strong>住所:</strong> {{ $restaurant['address'] }}</p>
                        <p><strong>アクセス:</strong> {{ $restaurant['access'] }}</p>
                        <p><strong>営業時間:</strong> {{ $restaurant['open'] }}</p>
                        <p>
                            <strong>公式ページ:</strong> 
                            <a href="{{ $restaurant['urls']['pc'] }}" target="_blank" class="text-decoration-none">こちら</a>
                        </p>
                    </div>
                </div>

                <!-- 詳細情報 -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4 class="text-primary">店内情報</h4>
                        <p><strong>お店キャッチ:</strong>{{ $restaurant['catch'] }}</p>
                        <p><strong>クレジットカード:</strong>{{ $restaurant['card'] }}</p>
                        <p><strong>禁煙室:</strong>{{ $restaurant['non_smoking'] }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
