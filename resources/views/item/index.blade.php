@extends('layouts.app')

@section('style')
<style>
.img{
    max-width: 200px;
    max-height: 200px;
}
.title{
    height: 100px;
}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">商品一覧</h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel">
                        <div class="row">
                            @forelse($items as $item)
                            <div class="col-sm-6">
                                <div class="panel panel-success h-100 text-center">
                                    <div class="panel-heading title">{{ $item->name }}</div>
                                    <figure class="panel-body">
                                        <img class="img center-block img-responsive" src="{{ asset('storage/photos/' . $item->img) }}">
                                        <figcaption>
                                            {{ $item->price }}円
                                            @if( $item->stock > 0)
                                                <form action="{{ route('cart.add') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                </form>
                                            @else
                                                <p class="text-danger">現在売り切れです。</p>
                                            @endif
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                            @empty
                                <p>商品はありません</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div1>
    </div>
</div>
@endsection
