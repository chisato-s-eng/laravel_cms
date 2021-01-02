@extends('layouts.app')

@section('style')
<style>
.img{
    max-width: 150px;
    max-height: 150px;
}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">カート</h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach

                    <div class="panel">
                        <div class="row">
                            @forelse($carts as $cart)
                            <div class="col-sm-12">
                                <div class="panel panel-success h-100 text-center">
                                    <table class="table">
                                        <tr>
                                            <td class="col-sm-3">
                                                <img class="img center-block img-responsive" src="{{ asset('storage/photos/' . $cart->item->img) }}">
                                            </td>
                                            <td class="col-sm-3">{{ $cart->item->name }}</td>
                                            <td class="col-sm-2">{{ $cart->item->price }}円</td>
                                            <td class="col-sm-1">
                                                <form method="post" action="{{ route('cart.update_amount') }}">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <input  type="text" name="amount" value="{{ $cart->amount }}">個
                                                    </div>
                                                    <input type="submit" value="変更" class="btn btn-secondary">
                                                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                                </form>
                                            </td>
                                            <td class="col-sm-2">{{ $cart->item->price * $cart->amount }}円</td>
                                            <td class="col-sm-1">
                                                <form method="post" action="{{ route('cart.delete') }}">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="削除" class="btn btn-danger delete">
                                                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @empty
                                <p>商品はありません</p>
                            @endforelse
                        </div>
                        <div class="row">
                            <p class="text-right">合計金額: {{ $total_price }}円</p>
                            <form method="post" action="{{ route('cart.purchase') }}">
                                {{ csrf_field() }}
                                <input class="btn btn-block btn-primary" type="submit" value="購入する">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div1>
    </div>
</div>
@endsection
