@extends('layouts.admin')

@section('style')
<style>
.add_item_form{
  border: solid 1px #dddddd;
  margin-bottom: 10px;
  padding: 10px;
}
.item_image{
    max-height: 300px;
    max-width: 200px;
}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">商品管理</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- メッセージが存在する場合には表示する -->
                    @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach

                    <form 
                        method="post" 
                        action="{{ route('admin.add_item') }}" 
                        enctype="multipart/form-data"
                        class="add_item_form col-md-6">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">名前: </label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="price">価格: </label>
                            <input class="form-control" type="number" name="price" id="price">
                        </div>
                        <div class="form-group">
                            <label for="stock">在庫数: </label>
                            <input class="form-control" type="number" name="stock" id="stock">
                        </div>
                        <div class="form-group">
                            <label for="category">カテゴリ: </label>
                            <select class="form-control" name="category" id="category">
                                <option value="1">1:マイク</option>
                                <option value="2">2:DTMソフト</option>
                                <option value="3">3:インターフェイス</option>
                                <option value="4">4:コード・周辺機器</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">詳細: </label>
                            <input class="form-control" type="textarea" name="detail" id="detail">
                        </div>
                        <div class="form-group">
                            <label for="image">商品画像: </label>
                            <input type="file" name="img" id="image">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス: </label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">公開</option>
                                <option value="0">非公開</option>
                            </select>
                        </div>
      
                        <input type="submit" value="商品追加" class="btn btn-primary">
                    </form>
                </div>
               
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>カテゴリ</th>
                            <th>説明</th>
                            <th>在庫数</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            @if($item->status === 0)
                            <tr style="background-color: #dddddd;">
                            @else
                            <tr>
                            @endif
                                <td><img src="{{ asset('storage/photos/' . $item->img) }}" class="item_image"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}円</td>
                                <td>
                                    @if( $item->category === 1)
                                        1:マイク
                                    @elseif( $item->category  === 2)
                                        2:DTMソフト
                                    @elseif( $item->category === 3)
                                        3:インターフェイス
                                    @else
                                        4:コード・周辺機器
                                    @endif
                                </td>
                                <td>{{ $item->detail }}</td>
                                <td>
                                    <form method="post" action="{{ route('admin.update_stock') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input  type="text" name="stock" value="{{ $item->stock }}">個
                                        </div>
                                        <input type="submit" value="変更" class="btn btn-secondary">
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="{{ route('admin.update_status') }}" class="operation">
                                        {{ csrf_field() }}
                                        @if( $item->status === 1)
                                            <input type="submit" value="公開 → 非公開" class="btn btn-secondary">
                                            <input type="hidden" name="status" value="0">
                                        @else
                                            <input type="submit" value="非公開 → 公開" class="btn btn-secondary">
                                            <input type="hidden" name="status" value="1">
                                        @endif
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    </form>

                                    <form method="post" action="{{ route('admin.delete_item') }}">
                                        {{ csrf_field() }}
                                        <input type="submit" value="削除" class="btn btn-danger delete">
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p>商品はありません。</p>
                        @endforelse 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // 削除ボタンをクリックした際、確認メッセージを表示
    $('.delete').on('click', function() {
        // console.log('jquery test');
        // form.submit();
        return confirm('本当に削除しますか？');
    });
</script>
@endsection