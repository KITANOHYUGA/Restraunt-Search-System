<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantController extends Controller
{
    public function search(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 300);
        $smoking = $request->input('smoking'); // 喫煙可否
        $budget = $request->input('budget'); // 予算
        
        $apiKey = env('HOTPEPPER_API_KEY');
        $url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/";

        // 予算コードのマッピング
        $budgetMapping = [
            '1000' => 'B001',
            '3000' => 'B002',
            '5000' => 'B003',
        ];

        // $response = Http::get($url, [
            $queryParams = [
            'key' => $apiKey,
            'lat' => $latitude,
            'lng' => $longitude,
            'range' => $this->convertRadiusToRange($radius),
            'count' => 100, // 最大取得件数を指定
            'format' => 'json',
        ];

        // 喫煙可否の条件
        if (!empty($smoking)) {
            if ($smoking == '不可') {
                $queryParams['non_smoking'] = 1; // 喫煙不可
            }
        }
        
        // 予算の条件
        if (!empty($budget) && isset($budgetMapping[$budget])) {
            $queryParams['budget'] = $budgetMapping[$budget];
        }

        // APIリクエストを送信
        $response = Http::get($url, $queryParams);

        // エラー発生時の処理
        if ($response->failed()) {
            abort(500, 'APIリクエストに失敗しました。');
        }

        $restaurants = $response->json()['results']['shop'] ?? [];

        // ページネーションの設定
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // 現在のページ番号を取得
        $perPage = 5; // 1ページに表示する件数


        // 現在のページに表示するデータを抽出
        $currentPageItems = array_slice($restaurants, ($currentPage - 1) * $perPage, $perPage);

        // LengthAwarePaginatorを作成
        $paginator = new LengthAwarePaginator(
            $currentPageItems, // 現在のページに表示するデータ
            count($restaurants), // 全データ数
            $perPage, // 1ページあたりの件数
            $currentPage, // 現在のページ
            ['path' => $request->url(), 'query' => $request->query()] // URLとクエリ
        );

        // `$startNumber` を計算
        $startNumber = ($currentPage - 1) * $perPage + 1;

        // ビューにデータを渡す
        return view('restaurants.results', [
            'restaurants' => $paginator,
            'startNumber' => $startNumber,
        ]);

        // $perPage = 5; // 1ページあたりの表示件数
        // $page = $request->input('page', 1);
        // $total = count($restaurants);
    
        // $pagedRestaurants = array_slice($restaurants, ($page - 1) * $perPage, $perPage);
    
        // $paginator = new LengthAwarePaginator($pagedRestaurants, $total, $perPage, $page, [
        //     'path' => $request->url(),
        //     'query' => $request->query(),
        // ]);

        // return view('restaurants.results', ['restaurants' => $paginator]);
    }

    private function convertRadiusToRange($radius)
    {
        switch ($radius) {
            case 300: return 1;
            case 500: return 2;
            case 1000: return 3;
            case 2000: return 4;
            default: return 1;
        }
    }

    public function detail($id)
{
    $apiKey = env('HOTPEPPER_API_KEY');
    $url = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/";

    // APIを使用して詳細情報を取得
    $response = Http::get($url, [
        'key' => $apiKey,
        'id' => $id,
        'format' => 'json',
    ]);

    $restaurant = $response->json()['results']['shop'][0] ?? null;

    if (!$restaurant) {
        abort(404, 'レストランが見つかりません');
    }

    return view('restaurants.detail', compact('restaurant'));
}
}

