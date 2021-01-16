@extends('layouts.admin')

@section('style')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">購入明細</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h4>注文番号：{{ $history->id }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>注文日時：{{ $history->created_at }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-right">合計金額: {{ $total_price }}円</h4>
                        </div>
                    </div>

                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                        <tr>
                            <th>商品名</th>
                            <th>購入価格</th>
                            <th>購入数</th>
                            <th>小計</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($history->detail as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_price }}円</td>
                            <td>{{ $item->item_amount }}点</td>
                            <td>{{ $item->item_price * $item->item_amount }}</td>
                        </tr>
                        @empty
                            <p>購入したものはありません</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection