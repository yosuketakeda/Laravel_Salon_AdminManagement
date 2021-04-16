<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// lili 
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // store manager & store staff query part
    public function user_index(Request $request)
    {
        $user = auth()->user();
        if($user->permission == 2){  /// store manager
            $queries = DB::table('query')->where('type', 2)->where('Aid', 0)->get();
        }elseif($user->permission == 3){  /// customer
            $queries = DB::table('query')->where('type', 1)->where('Aid', 0)->get();            
        }        

        return view('user-question-menu')->with('queries', $queries);
    }

    public function user_answer_index(Request $request)
    {        
        if($request->step == 'first-step'){
            $type = $request->type;
            $query_id = $request->query_id;
            $category = $request->category;              
            $answer_id = $request->answer_id;
            
            if(!empty($answer_id)){
                $recommend = DB::table('answer')->where('id', $answer_id)->get()->first();
                $recommend = $recommend->recommend;
                $recommend += 1;
                DB::table('answer')->where('id', $answer_id)->update([
                    'recommend' => $recommend,
                ]);
            }

            $query = DB::table('query')->where('id', $query_id)->get()->first();
            $answers = DB::table('answer')->where('type', $type)->where('Qid', $query_id)->get();
            
            /// when add new question for answer --- new question number
            $result = '';            
            /*$Aid = $query->Aid;
            while(1){
                $a_buf = DB::table('answer')->where('id', $Aid)->get();
                $buf = $a_buf[0]->Anum; //// last num
                $result = $buf.'-'.$result;
                $Qid = $a_buf[0]->Qid;
                $q_buf = DB::table('query')->where('id', $Qid)->get();
                $buf = $q_buf[0]->Aid;
                if($buf == '0'){
                    $result = $q_buf[0]->Qnum.'-'.$result;
                    break;
                }else{
                    $Aid = $buf;
                }
            }

            //$result = substr($result, 0, -1);    
            */
            return view('user-answer')->with('query', $query)->with('answers', $answers)->with('result', $result)->with('type', $type)->with('step', $request->step)->with('query_id', $query_id)->with('answer_id', '')->with('index', null);
           
        }
        if($request->step == 'last-step'){
            $template_id = $request->template_id;
            $template_query = $request->template_query;
            
            return view('user-answer')->with('template_id',$template_id)->with('template_query', $template_query)->with('step', $request->step)->with('type', null)->with('index', null)->with('query_id', null);
        }
        if($request->step == 'choose'){
            $type = $request->type;
            $query_id = $request->query_id;            
            $query_content = $request->query_content;
            $index = $request->index;
            //$query = null;
            //$answers = array(0);

            return view('user-answer')->with('type', $type)->with('query_id', $query_id)->with('query_content', $query_content)->with('step', $request->step)->with('index', $index);
        }
    }   
 //////////////////////////////////////////////////////////////////   
    //// user list part

    public function index(Request $request)
    {
        if(empty($request->origin_id)){
            $last_user = DB::table('users')->latest('created_at')->first();
        
            if(empty($last_user)){
                $id = '0001';
            }else{
                $id = $last_user->user_id;
                
                $id += 1;
                $count = 0; 
                
                $temp = $id;
            
                while ($temp >= 1) 
                { 
                    $temp /= 10;                
                    $count++;
                } 
                $origin_id = $id;
                
                switch($count){
                    case 1:
                        $id = '000'.$id; 
                    break;
                    case 2:
                        $id = '00'.$id;
                    break;
                    case 3:
                        $id = '0'.$id;
                    break;
                }                   
            }
            $users = DB::select('select * from users where permission=?',[3]);
        }else{
            $origin_id = $request->origin_id;
            $id = $origin_id;
            $count = 0; 
            
            $temp = $id;
        
            while ($temp >= 1) 
            { 
                $temp /= 10;                
                $count++;
            } 
            $origin_id = $id;
            switch($count){
                case 1:
                    $id = '000'.$id; 
                break;
                case 2:
                    $id = '00'.$id;
                break;
                case 3:
                    $id = '0'.$id;
                break;
            }            
            $users = DB::select('select * from users where user_id= ?',[$origin_id]);
        }
        
        return view('user-part')->with('user_id', $id)->with('origin_id', $origin_id)->with('users', $users);
        
    }

    public function user_add(Request $request)
    {
        $origin_id = $request->origin_id;
        $account_name = $request->account_name;
        $permission = $request->permission;
        $organization = $request->organization;
        $login_id = $request->login_id;
        $password = $request->password;
        $temp_password = $password;
        $password = Hash::make($password);

        DB::insert('insert into users (user_id, name, permission, organization, password, temp_password, login_id) values (?,?,?,?,?,?,?)', [$origin_id, $account_name, $permission, $organization, $password, $temp_password, $login_id]);

        return redirect()->route('user.index', ['step'=>'list']);
    }

    public function user_update(Request $request)
    {
        $origin_id = $request->origin_id;
        $account_name = $request->account_name;
        $permission = $request->permission;
        $organization = $request->organization;
        $login_id = $request->login_id;
        $password = $request->password;
        $temp_password = $password;
        $password = Hash::make($password);

        DB::table('users')->where('user_id',$origin_id)
                ->update([
                    'name' => $account_name,
                    'permission' => $permission,
                    'organization' => $organization,
                    'login_id' => $login_id,
                    'password' => $password,
                    'temp_password' => $temp_password
            ]);    

        return redirect()->route('user.index', ['step'=>'account-confirm', 'origin_id'=>$origin_id]);
    }

}
