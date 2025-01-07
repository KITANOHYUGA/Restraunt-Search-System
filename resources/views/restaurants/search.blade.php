<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レストラン検索</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .branding {
            text-align: center;
            margin-bottom: 2rem;
        }
        .branding .title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #f76b1c;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        .branding .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>
<body onload="getLocation()" class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container text-center bg-white p-5 rounded shadow">
        
        <!-- Branding Section -->
        <div class="branding">
            <div class="title">ごちナビ！</div>
            <div class="subtitle">近くの美味しいを、ごちナビで。</div>
        </div>

        <!-- Search Form -->
        <h3 class="mb-4">近くの飲食店を検索</h3>
        <form method="GET" action="{{ route('restaurants.search') }}">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div class="mb-3">
                <label for="radius" class="form-label">現在地からの範囲（m）:</label>
                <select id="radius" name="radius" class="form-select">
                    <option value="300">300m</option>
                    <option value="500">500m</option>
                    <option value="1000">1km</option>
                    <option value="2000">2km</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
</body>

<script>
        async function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            } else {
                alert("Geolocationはサポートされていません。");
            }
        }
</script>
</html>
