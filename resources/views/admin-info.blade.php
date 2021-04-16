@include('include/header-admin')

<div class="admin-info">
    <div class="container">
        <div  class="top">
            <div class="card-header">管理者情報</div>
            <a class="link" href="{{route('admin_dashboard.index')}}">TOPに戻る</a>
            <div class="row">
                <div class="col-md-3 col-sm-3">ログインID</div>
                <div class="col-md-9 col-sm-9">{{$admin->name}}</div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">パスワード</div>
                <div class="col-md-9 col-sm-9">-- セキュリティ上、表示をふせています --</div>
            </div>
            <div class="btn-section">
                <a class="link" href="{{route('admin_info.index', ['step'=>'edit'])}}">編集</a>
            </div>
        </div>
        <div class="edit">
            <form action="{{route('admin_info.change')}}" method="POST">
                @csrf
                <div class="card-header">管理者情報編集 入力</div>
                <a class="link" href="{{route('admin_dashboard.index')}}">TOPに戻る</a>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ログインID</div>
                    <div class="col-md-9 col-sm-9">
                        <input type="text" class="admin-name" name="admin_name" value="{{empty($new_name) ? $admin->name : $new_name}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">パスワード</div>
                    <div class="col-md-9 col-sm-9">
                        <input id="password" type="password" class="password" name="admin_password" value="{{$admin->temp_password}}" required>
                        <label  class="eye-img" id="eye-img">
                            <img src="{{URL::asset('public/assets/images/password_eye.png')}}">
                            <input type="checkbox" class="toggle-password" hidden>
                        </label>
                    </div>
                </div>
                <div class="btn-section">
                    <div style="margin:auto; display:flex">
                        <a class="link" href="{{route('admin_info.index',['step'=>'top'])}}">キャンセル</a>
                        <button class="confirm">確認</button>
                    </div>
                </div>
            </form>
        </div>
        <div  class="confirm-section">
            <form action="{{route('admin_info.confirm')}}" method="POST">
                @csrf
                <div class="card-header">管理者情報編集 確認</div>
                <input name = "new_name" value="{{$new_name}}" hidden>
                <input name = "new_password" value="{{$new_password}}" hidden>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ログインID</div>
                    <div class="col-md-9 col-sm-9">{{$new_name}}</div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">パスワード</div>
                    <div class="col-md-9 col-sm-9">-- セキュリティ上、表示をふせています --</div>
                </div>
                <div class="btn-section">
                    <div style="margin:auto; display:flex">
                    <a class="link" href="{{route('admin_info.index', ['step'=>'edit', 'new_name'=>$new_name, 'new_password'=>$new_password])}}">編集</a>
                        <button class="confirm" style="margin-left: 15px">決定</button>
                    </div>
                </div>
            </form>
        </div>        
    </div>
</div>

@include('include/footer')