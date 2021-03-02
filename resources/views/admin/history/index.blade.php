@extends('layouts.admin')

@section('style')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">購入履歴</h3>
                </div>

                <div class="panel-body">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach

                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                        <tr>
                            <th>注文番号</th>
                            <th>購入日時</th>
                            <th>合計金額</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($history_items as $history)
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>{{ $history->created_at }}</td>
                            <td>{{ $total_price[$history->id] }}円</td>
                            <td>
                            <a href="{{ route('admin.history.detail', ['id'=>$history->id]) }}" class="btn btn-primary btn-sm btn-block">購入明細</a>
                            </td>
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