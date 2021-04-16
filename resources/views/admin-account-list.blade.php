@include('include/header-admin')

<div class="admin-account-list">
    <div class="container">
        <div class="list">
            <div class="card-header">アカウント一覧</div>
            <div class="row">                
                <button class="store-manager">店舗管理者</button>                
                <button class="users">利用者</button>
                <a class="add-new" href="{{route('admin_account_list.index', ['step'=>'add-new'])}}">新規登録</a>
            </div>
            <div class="table-section">
                <table>
                    <th>ID</th>
                    <th>アカウント名</th>
                    <th>権限</th>
                    <th>登録日時</th>
                    <th>操作</th>
                    @if(!empty($users))
                        @foreach($users as $user)
                            @if($user->permission == 2)
                            <tr class="store-section">
                                <td id="user_id">
                                    <span style="display:none">{{$user->user_id}}</span>
                                    <a href="{{route('admin_account_list.index', ['step'=>'account-info', 'origin_id'=>$user->user_id])}}">
                                    <?php 
                                        $each_id = $user->user_id;
                                        $count = 0;                                         
                                        $temp = $each_id;                                    
                                        while ($temp >= 1) 
                                        { 
                                            $temp /= 10;                
                                            $count++;
                                        }                                         
                                        switch($count){
                                            case 1:
                                                $each_id = '000'.$each_id; 
                                            break;
                                            case 2:
                                                $each_id = '00'.$each_id;
                                            break;
                                            case 3:
                                                $each_id = '0'.$each_id;
                                            break;
                                        }                                                    
                                    ?>
                                    {{$each_id}}
                                    </a>
                                </td>
                                <td>{{$user->name}}</td>
                                <td>店舗管理者</td>
                                <td>{{str_replace('-', '/', explode(' ', $user->created_at)[0])}}</td>
                                <td>                            
                                    <a href="{{route('admin_account_list.index', ['step'=>'edition', 'origin_id'=>$user->user_id])}}" class="edit">編集</a>
                                    <a href="javascript:void(0);" class="delete">削除</a>
                                </td>
                            </tr>
                            @else
                            <tr class="users-section">
                                <td id="user_id">
                                    <span style="display:none">{{$user->user_id}}</span>
                                    <a href="{{route('admin_account_list.index', ['step'=>'account-info', 'origin_id'=>$user->user_id])}}">
                                    <?php
                                        $each_id = $user->user_id;
                                        $count = 0;                                         
                                        $temp = $each_id;                                    
                                        while ($temp >= 1) 
                                        { 
                                            $temp /= 10;                
                                            $count++;
                                        }                                         
                                        switch($count){
                                            case 1:
                                                $each_id = '000'.$each_id; 
                                            break;
                                            case 2:
                                                $each_id = '00'.$each_id;
                                            break;
                                            case 3:
                                                $each_id = '0'.$each_id;
                                            break;
                                        }                                                    
                                    ?>
                                    {{$each_id}}
                                    </a>
                                </td>
                                <td>{{$user->name}}</td>
                                <td>利用者</td>
                                <td>{{str_replace('-', '/', explode(' ', $user->created_at)[0])}}</td>
                                <td>                            
                                    <a href="{{route('admin_account_list.index', ['step'=>'edition', 'origin_id'=>$user->user_id])}}" class="edit">編集</a>
                                    <a href="javascript:void(0);" class="delete">削除</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                </table>                
            </div>
        </div><!--------- top list ----------->
        <div class="add-new">
            <form action="{{route('admin_account.add')}}" method="POST">
                @csrf
                <div class="card-header">アカウント編集 入力</div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ID</div>
                    <div class="col-md-9 col-sm-9" style="display: flex; align-items:center;">
                        <span>{{empty($user_id) ? '' : $user_id}}</span>
                    </div>
                    <input name="origin_id" value="{{empty($origin_id) ? '' : $origin_id}}" hidden>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">アカウント名</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="account_name" class="account-name" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">権限</div>
                    <div class="col-md-9 col-sm-9">
                        <select class="permission">
                            <option value="2">店舗管理者</option>
                            <option value="3">利用者</option>
                        </select>
                        <input name="permission" class="input-permission" value="2" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">組織</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="organization" class="organization" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ログインID</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="login_id" class="login-id" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">パスワード</div>
                    <div class="col-md-9 col-sm-9">
                        <input type="password" name="password" class="password" value="" required>
                        <label  class="eye-img" id="eye-img">
                            <img src="{{URL::asset('public/assets/images/password_eye.png')}}">
                            <input type="checkbox" class="toggle-password" hidden>
                        </label>
                    </div>
                </div>
                <div class="btn-section">
                    <div style="margin:auto; display:flex">
                        <a class="link" href="{{route('admin_account_list.index', ['step'=>'list'])}}">キャンセル</a>
                        <button class="confirm">確認</button>
                    </div>
                </div>
            </form>
        </div><!------------- add new --------------->        
        <div class="account-info">
            <div class="card-header">アカウント情報</div>
            <div class="row">
                <div class="col-md-3 col-sm-3">ID</div>
                <div class="col-md-9 col-sm-9" style="display: flex; align-items:center;">
                    <span>{{empty($user_id) ? '' : $user_id}}</span>
                </div>
            </div>            
            <div class="row">
                <div class="col-md-3 col-sm-3">権限</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->permission == 2 ? '店舗管理者' : '利用者'}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">組織</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->organization}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">アカウント名</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->name}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">ログインID</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->login_id}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">パスワード</div>
                <div class="col-md-9 col-sm-9">
                    <input type="password" name="password" class="password" value="{{empty($users) ? '' : $users[0]->temp_password}}">
                    <label  class="eye-img" id="eye-img">
                        <img src="{{URL::asset('public/assets/images/password_eye.png')}}">
                        <input type="checkbox" class="toggle-password" hidden>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">登録日時</div>
                <div class="col-md-9 col-sm-9">
                    @if(!empty($users))
                        <span>{{str_replace('-', '/', explode(' ', $users[0]->created_at)[0])}}</span>
                    @endif
                </div>
            </div>
            <div class="btn-section">
                <div style="margin:auto; display:flex">
                    <a class="link" href="{{route('admin_account_list.index', ['step'=>'edition', 'origin_id'=>$origin_id])}}">編集</a>
                    <button class="delete">削除</button>
                </div>
            </div>
        </div><!-----------------  account-info  -------------------->
        <div class="edition">
            <form action="{{route('admin_account.update')}}" method="POST">
                @csrf
                <div class="card-header">アカウント編集 入力</div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ID</div>
                    <div class="col-md-9 col-sm-9" style="display: flex; align-items:center;">
                        <span>{{$user_id}}</span>
                    </div>
                    <input name="origin_id" value="{{$origin_id}}" hidden>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">アカウント名</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="account_name" class="account-name" value="{{empty($users) ? '' :$users[0]->name}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">権限</div>
                    <div class="col-md-9 col-sm-9">
                        <select class="permission">
                            <option value="2" {{empty($users) ? '' : $users[0]->permission == 2 ? 'selected' : ""}}>店舗管理者</option>
                            <option value="3" {{empty($users) ? '' : $users[0]->permission == 3 ? 'selected' : ""}}>利用者</option>
                        </select>
                        <input name="permission" class="input-permission" value="{{empty($users) ? '' : $users[0]->permission}}" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">組織</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="organization" class="organization" value="{{empty($users) ? '' : $users[0]->organization}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">ログインID</div>
                    <div class="col-md-9 col-sm-9">
                        <input name="login_id" class="login-id" value="{{empty($users) ? '' : $users[0]->login_id}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">パスワード</div>
                    <div class="col-md-9 col-sm-9">
                        <input type="password" name="password" class="password" value="{{empty($users) ? '' : $users[0]->temp_password}}" required>
                        <label  class="eye-img" id="eye-img">
                            <img src="{{URL::asset('public/assets/images/password_eye.png')}}">
                            <input type="checkbox" class="toggle-password" hidden>
                        </label>
                    </div>
                </div>
                <div class="btn-section">
                    <div style="margin:auto; display:flex">
                        <a class="link" href="{{route('admin_account_list.index', ['step'=>'account-info', 'origin_id'=>$origin_id])}}">キャンセル</a>
                        <button class="confirm">確認</button>
                    </div>
                </div>
            </form>
        </div> <!----------------- edition --------------------->
        <div class="account-confirm">
            <div class="card-header">アカウント編集 確認</div>
            <div class="row">
                <div class="col-md-3 col-sm-3">ID</div>
                <div class="col-md-9 col-sm-9" style="display: flex; align-items:center;">
                    <span>{{$user_id}}</span>
                </div>
            </div>            
            <div class="row">
                <div class="col-md-3 col-sm-3">アカウント名</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->name}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">権限</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->permission == 2 ? '店舗管理者' : '利用者'}}</span>                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">組織</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->organization}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">ログインID</div>
                <div class="col-md-9 col-sm-9">
                    <span>{{empty($users) ? '' : $users[0]->login_id}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">パスワード</div>
                <div class="col-md-9 col-sm-9">
                    <span>-- セキュリティ上、表示をふせています --</span>
                </div>
            </div>
            <div class="btn-section">
                <div style="margin:auto; display:flex">
                    <a class="link" href="{{route('admin_account_list.index',['step'=>'edition', 'origin_id'=>$origin_id])}}">編集</a>
                    <a class="confirm" href="{{route('admin_account_list.index',['step'=>'list'])}}">決定</a>
                </div>
            </div>
        </div><!-------------- confirm ---------------->        
    </div>
    <div id="dialog-warning">
        <div class="body">
            <p> Would you delete this account really? </p>
            <p> If you delete this account, all data of this account will be lost. </p>
            <div class="btn-section">
                <button class="del-ok">OK</button>    
                <button class="del-cancel">Cancel</button>
            </div>
            <input class="del-id" value="" hidden>
        </div>
    </div>
</div>

@include('include/footer')
 
<script>
$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#dialog-warning .del-ok").click(function(){
        $("#dialog-warning").css("display", "none");
        var user_id = $("#dialog-warning .del-id").val();
        
        $.ajax({
            url: "{{route('admin_account.delete')}}",
            type: "POST",
            data: { "user_id":user_id },
            success: function (data) {
                if(data.success){
                    console.log(data.data);
                    console.log("Successed!");
                    window.location.href="{{route('admin_account_list.index', ['step'=>'list'])}}";
                }else{
                    console.log("Upload Failed!");                    
                }
            },
            error: function(data) {
                console.log("Errors!!");
            }
        });
    });
    $("#dialog-warning .del-cancel").click(function(){
        $("#dialog-warning").css("display", "none");        
    });

    $(".admin-account-list .account-info .delete").click(function(){
        $("#dialog-warning").css("display", "block");
        var user_id = {{$origin_id}};
        $("#dialog-warning .del-id").val(user_id);
    });

    $(".admin-account-list .list .table-section .delete").click(function(event){
        $("#dialog-warning").css("display", "block");
        var user_id = $(event.target).closest("tr").find("#user_id span").text();       
        $("#dialog-warning .del-id").val(user_id);
    });
    
});
</script>