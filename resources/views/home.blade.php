@extends('layouts.app')

@section('style')
<style>
.img {
    height: 200px;
    width: 300px;
}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">カテゴリ一覧</h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="panel panel-success h-100 text-center">
                                    <div class="panel-heading">マイク</div>
                                    <a href="/item_list?category=1" class="panel-body">
                                        <img class="img" src="{{ asset('storage/photos/mic_category.jpg') }}">
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel panel-success h-100 text-center">
                                    <div class="panel-heading">DTMソフト</div>
                                    <a href="/item_list?category=2" class="panel-body">
                                        <img class="img" src="{{ asset('storage/photos/dtmsoft_category.jpg') }}">
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel panel-success h-100 text-center">
                                    <div class="panel-heading">インターフェイス</div>
                                    <a href="/item_list?category=3" class="panel-body">
                                        <img class="img" src="{{ asset('storage/photos/interface_category.jpg') }}">
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="panel panel-success h-100 text-center">
                                    <div class="panel-heading">コード・周辺機器</div>
                                    <a href="/item_list?category=4" class="panel-body">
                                        <img class="img" src="{{ asset('storage/photos/code_category.jpg') }}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
