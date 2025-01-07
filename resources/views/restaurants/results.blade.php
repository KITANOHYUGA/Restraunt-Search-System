<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲食店検索結果</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
    @if (count($restaurants) > 0)

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-end">
                <a href="{{ url('/') }}" class="btn btn-secondary mb-3">現在地から検索する</a>
            </div>
        </div>

        <!-- 絞り込みフォーム -->
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('restaurants.search') }}" method="GET" class="row g-3">
                    <!-- 検索範囲を保持 -->
                    <input type="hidden" name="latitude" value="{{ request('latitude') }}">
                    <input type="hidden" name="longitude" value="{{ request('longitude') }}">
                    <input type="hidden" name="radius" value="{{ request('radius') }}">

                    <!-- 絞り込み: 喫煙可否 -->
                    <div class="col-4 col-md-3">
                        <label for="smoking" class="form-label">喫煙可否</label>
                        <select name="smoking" id="smoking" class="form-select">
                            <option value="">すべて</option>
                            <option value="不可" {{ request('smoking') == '不可' ? 'selected' : '' }}>喫煙不可</option>
                        </select>
                    </div>

                    <!-- 絞り込み: 予算 -->
                    <div class="col-4 col-md-3">
                        <label for="budget" class="form-label">予算</label>
                        <select name="budget" id="budget" class="form-select">
                            <option value="">指定なし</option>
                            <option value="1000" {{ request('budget') == '1000' ? 'selected' : '' }}>〜1000円</option>
                            <option value="3000" {{ request('budget') == '3000' ? 'selected' : '' }}>〜3000円</option>
                            <option value="5000" {{ request('budget') == '5000' ? 'selected' : '' }}>〜5000円</option>
                        </select>
                    </div>

                    <!-- 絞り込みボタン -->
                    <div class="col-4 col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary w-100">絞り込み</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center mt-5"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>近くの飲食店一覧</h3>
                    </div>
                    <div class="card-body">
                        @php
                            // Bladeで飲食店の番号を計算
                            $currentNumber = $startNumber;
                        @endphp

                        <div class="accordion accordion-flush" id="accordionFlush">
                            @foreach ($restaurants as $index => $restaurant)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="{{'#accordionFlush'.$restaurant['id']}}" aria-expanded="false" aria-controls="{{'#accordionFlush'.$restaurant['id']}}">
                                        <span class="badge bg-secondary">no.{{ $currentNumber + $index }}</span> 店名 : {{ $restaurant['name'] }}
                                        </button>
                                    </h2>

                                    <!-- 検索結果表示 -->
                                    <div id="{{'accordionFlush'.$restaurant['id']}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                                        <div class="accordion-body">
                                            <div class="row mb-3 align-items-center">
                                                <!-- アクセス情報 -->
                                                <div class="col-md-6">
                                                    <p class="mb-0">
                                                        <strong>アクセス:</strong> {{ $restaurant['access'] }}
                                                    </p>
                                                </div>
                                                <!-- レストラン画像 -->
                                                <div class="col-md-6 text-center">
                                                    <div class="ratio ratio-16x9" style="max-width: 300px; margin: 0 auto;">
                                                        <img src="{{ $restaurant['photo']['mobile']['l'] }}" alt="{{ $restaurant['name'] }}" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- 詳細ボタン -->
                                                <div class="col text-end">
                                                    <a href="{{ route('restaurants.detail', ['id' => $restaurant['id']]) }}" class="btn btn-primary">
                                                        詳細
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- ページネーションリンクの表示 -->
                        <div class="row align-items-center mt-4">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-center">
                                    {{ $restaurants->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            @else
            <div class="text-center mt-5">
                <p class="text-muted fs-5">該当する飲食店が見つかりませんでした。条件を変更して再検索してください。</p>
                <p class="text-muted fs-5">また、位置情報がオンになっているかをご確認ください。</p>
                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-repeat me-2"></i>現在地から再検索
                    </a>
                </div>
            </div>
            @endif      
    </div>
</body>
</html>
