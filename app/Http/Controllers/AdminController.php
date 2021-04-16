<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// lili 
use DB;
use Illuminate\Support\Facades\Hash;
use Charts;
use App\User;


class AdminController extends Controller
{
////////////////////// admin dashboard ///////////////////////

    public function admin_dashboard(Request $request)
    {
        $query = DB::table('query')->where('Aid', 0)->get();
        $last_template = DB::table('last_template')->get();
        
        return view('admin-dashboard')->with("query", $query)->with("last_template", $last_template);
    }

/////////////////////////// admin add new & edit ///////////////////////////////////
    public function admin_add_new_index(Request $request)
    {
        $type = $request->type;
        $query = null;
        $answer = null;
        $Qid = $request->transID;  // id of query table 
        
        $last_query = DB::table('query')->where('type', $type)->latest('created_at')->first();
        if(empty($last_query)){
            // create new
            $id = 1;
        }else{
            //add new
            // check Aid == 0 and plus num
            $id = DB::table('query')->where('type', $type)->where('Aid', 0)->max('Qnum'); // last top query number
            $id += 1;  // new number
            
            $query = DB::select('select * from query where id=? and type=? ',[$Qid, $type]); // oneself query
            $answer = DB::select('select * from answer where Qid= ? and type=?',[$Qid, $type]); // oneself answer
        }
        
        $Qnum = DB::table('query')->where('id', $Qid)->get();
        if(count($Qnum) == 0){
            $Qnum = null;
        }else{
            $Qnum = $Qnum[0]->Qnum;
        }          
        
        return view('admin-add-new')->with("id", $id)->with("type", $type)->with("query", $query)->with("answer", $answer)->with("query_id", $Qid)->with('Qnum', $Qnum);
    }    

    public function admin_top_add_first(Request $request)
    {
        $type = $request->type;
        $query_id = $request->query_id;
        $category = $request->first_category;
        $query = $request->query_content;        
        $answers = $request->query_answer;
        
        $Qnum = $query_id;
        
        DB::insert('insert into query (type, Aid, Qnum, category, query_content) values (?,?,?,?,?)',
                [$type, 0, $Qnum, $category, $query]);
        
        $Qid = DB::table('query')->where('type', $type)->where('Aid', 0)->latest('id')->first();
        $Qid = $Qid->id;

        $i = 1;
        foreach($answers as $answer){
            if($answer != ''){
                DB::insert('insert into answer (type, Qid, Anum, answer_content) values (?,?,?,?)',
                    [$type, $Qid, $i, $answer]);
                $i++;
            }            
        }
        
        $query_id = DB::table('query')->where('Qnum', $Qnum)->get();
        $query_id = $query_id[0]->id;
        
        return redirect()->route('admin_dashboard.index');
    }

////////////////// administrator info
    public function admin_info_index(Request $request)
    {   
        $step = $request->step;
        $new_name = $request->new_name;
        $new_password = $request->new_password;
        
        $admin = DB::table('users')->where('email', 'admin@admin.com')->get();
        $admin = $admin[0];
        return view('admin-info')->with('admin', $admin)->with('new_name', $new_name)->with('new_password', $new_password);
    }

    public function admin_info_change(Request $request)
    {
        $new_name = $request->admin_name;
        $new_password = $request->admin_password;
        
        return redirect()->route('admin_info.index', ['step'=>'confirm', 'new_name'=>$new_name, 'new_password'=>$new_password ]);
    }

    public function admin_info_confirm(Request $request)
    {
        $new_name = $request->new_name;
        $new_password = $request->new_password;
        
        DB::table('users')->where('email', 'admin@admin.com')
            ->update([
                'name' => $new_name,
                'password' =>  Hash::make($new_password),
                'temp_password' => $new_password,
        ]);

        return redirect()->route('admin_info.index', ['step'=>'top']);
    }

////////////////////////////// admin multiple //////////////////////////////////
    public function admin_multiple_index(Request $request)
    {
        $step = $request->step;
        $type = $request->type;
        $query_id = $request->query_id;
        $answer_id = $request->answer_id;
        $category = $request->category;       

        $result = '';
        $Aid = $answer_id;
        
        /// when add new question for answer --- new question number
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

        $result = substr($result, 0, -1);               

        $query = null;
        $answers = null;
        $parent_answer = null;
        $child_answer = null;
        $return_mode = 0;
        $return_query_id = null;
        $return_answer_id = null;

        if($request->step == 'multiple-choice'){
            
            /// on here : $answer_id is preview answer id.

            $query = DB::table('query')->where('id', $query_id)->get()->first(); 

            $child_answer = DB::table('answer')->where('Qid', $query_id)->get();
            
            $parent_answer = DB::table('answer')->where('id', $answer_id)->get();
            if(!empty($parent_answer)) $parent_answer = $parent_answer[0]->answer_content;

            // get preview question
            $pre_answer = DB::table('answer')->where('id', $answer_id)->get()->first();
            $pre_Qid = $pre_answer->Qid;
            $pre_query = DB::table('query')->where('id', $pre_Qid)->get()->first();
            
            if($pre_query->Aid == 0){  
                $return_mode = 1;    // return admin_add_new.index            
            }else{
                $return_mode = 2;    // return 
            }
            $return_query_id = $pre_query->id;
            $return_answer_id = $pre_query->Aid;
        
        }else if($request->step == 'multiple-edition'){

            $query = DB::table('query')->where('id', $query_id)->get()->first(); 

            $child_answer = DB::table('answer')->where('Qid', $query_id)->get();
            
            $parent_answer = DB::table('answer')->where('id', $answer_id)->get();
            if(!empty($parent_answer)) $parent_answer = $parent_answer[0]->answer_content;
            

        }else if($request->step == 'register'){
            
            $parent_answer = DB::table('answer')->where('id', $answer_id)->get();
                
            if(!empty($parent_answer)) $parent_answer = $parent_answer[0]->answer_content;                        
        }
        return view('admin-multiple')->with('step', $step)->with("type", $type)->with("query_id", $query_id)->with("answer_id", $answer_id)->with("query", $query)->with('parent_answer', $parent_answer)->with("category", $category)->with('result', $result)->with('child_answer', $child_answer)->with('return_mode', $return_mode)->with('return_query_id', $return_query_id)->with('return_answer_id', $return_answer_id);
    }

    public function admin_multiple_add_new(Request $request)
    {
        $type = $request->type;
        $query_id = $request->query_id;
        $answer_id = $request->answer_id;
        $answers = $request->query_answer;  // input array
        $category = $request->category;
        
        $Qnum = DB::table('query')->where('type', $type)->where('Aid', $answer_id)->max('Qnum'); // last top query number
        if(empty($Qnum)){
            $Qnum = 1;
        }else{
            $Qnum += 1;
        }
        DB::insert('insert into query (type, Aid, Qnum, category, query_content) values (?,?,?,?,?)',
                [$type, $answer_id, $Qnum, $category, $request->query_content]);        
        $Qid = DB::table('query')->where('Aid', $answer_id)->where('type', $type)->get();
        $Qid = $Qid[0]->id;
        $query_id = $Qid; /// new query_id

        $i = 1;
        foreach($answers as $answer){
            DB::insert('insert into answer (type, Qid, Anum, answer_content) values (?,?,?,?)',
                [$type, $Qid, $i, $answer]);
            $i++;
        }
                
        return redirect()->route('admin_multiple.index', ['step' => 'multiple-choice', 'type'=>$type,'query_id'=>$query_id, 'category'=>$category,'answer_id'=>$answer_id] );        
    }
    
/////////////////// admin choice ///////////

    public function admin_choice_index(Request $request)    
    {
        $type = $request->type;
        $query_id = $request->query_id;
        $answer_id = $request->answer_id;        
        $category = $request->category;
        
        $parent_answer = DB::table('answer')->where('id', $answer_id)->get();
        if(!empty($parent_answer)) $parent_answer = $parent_answer[0]->answer_content;
        //////////////////////
        
        $queries = DB::table('query')->where('type', $type)->where('Qnum', 0)->where('Aid', $answer_id)->get();

        $last_template_selected = null;
        if(count($queries) != 0) $last_template_selected = $queries[0]->last_template;

        $last_template = DB::table('last_template')->get();

        $result = '';
        $Aid = $answer_id;
        /// when add new question for answer --- new question number
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

        $result = substr($result, 0, -1);

        return view('admin-choice')->with('type', $type)->with('query_id', $query_id)->with('answer_id', $answer_id)->with('parent_answer', $parent_answer)->with('category', $category)->with('queries', $queries)->with('last_template_selected', $request->last_template_selected)->with('last_template', $last_template)->with('result', $result);
    }

    public function admin_choice_register(Request $request)
    {
        $type = $request->type;
        $query_id = $request->query_id;
        $answer_id = $request->answer_id;
        $category = $request->category;
        $queries = $request->query_content;
       
        $param = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
       
        $old_queries = DB::table('query')->where('type', $type)->where('Aid', $answer_id)->where('Qnum', 0)->get();
        $i = 0;
        if(count($old_queries)==0){            
            foreach($queries as $query){
                DB::insert('insert into query (type, Aid, Qnum, choice_id, category, query_content) values (?,?,?,?,?,?)',
                    [$type, $answer_id, 0, $param[$i], $category, $query]);
                $i++;
            }
        }else{
            $old_count = count($old_queries);
            foreach($queries as $query){
                if($i < $old_count){
                    DB::table('query')->where('type', $type)->where('Aid', $answer_id)->where('choice_id', $param[$i])->update([
                        'query_content' => $query,
                        ]);
                }
                else{
                    DB::insert('insert into query (type, Aid, Qnum, choice_id, category, query_content) values (?,?,?,?,?,?)',
                    [$type, $answer_id, 0, $param[$i], $category, $query]);
                }
                $i++;
            }
        }
        /*
        if(count($old_queries)==0){
            $i = 0;
            foreach($queries as $query){
                if($i == 0){
                    DB::insert('insert into query (type, Aid, Qnum, choice_id, category, query_content) values (?,?,?,?,?,?)',
                    [$type, $answer_id, 0, 'A', $category, $query]);
                }else{
                    DB::insert('insert into query (type, Aid, Qnum, choice_id, category, query_content) values (?,?,?,?,?,?)',
                    [$type, $answer_id, 0, 'B', $category, $query]);
                }
                $i++;
            }
        }else{
            $i = 0;            
            if(count($old_queries) == 1){
                foreach($queries as $query){
                    if($i == 0){
                        DB::table('query')
                            ->where('type', $type)->where('Aid',$answer_id)->where('choice_id', 'A')
                            ->update([                                
                                'query_content' => $query,
                                'category' => $category
                        ]);                    
                    }else{
                        DB::insert('insert into query (type, Aid, Qnum, choice_id, category, query_content) values (?,?,?,?,?,?)',
                            [$type, $answer_id, 0, 'B', $category, $query]);
                    }
                    $i++;
                }    
            }else{
                foreach($queries as $query){
                    if($i == 0){
                        DB::table('query')
                            ->where('type', $type)->where('Aid',$answer_id)->where('choice_id', 'A')
                            ->update([
                                'query_content' => $query,
                        ]); 
                    }else{
                        DB::table('query')
                            ->where('type', $type)->where('Aid',$answer_id)->where('choice_id', 'B')
                            ->update([
                                'query_content' => $query,
                        ]);
                    }
                    $i++;
                }
            }
        }
        */
        return redirect()->route('admin_choice.index', ['step'=>'choice-edition', 'type'=>$type, 'answer_id'=>$answer_id, 'query_id'=>$query_id, 'category'=>$category]);       
    }

    public function admin_choice_edition(Request $request)
    {
        $query_id = $request->query_id;
        $answer_id = $request->answer_id;
        $last_template_selected = $request->last_template_selected;
        $type = $request->type;     
        $category = $request->category;
        
        DB::table('query')->where('Aid', $answer_id)->update([
            'last_template'=>$last_template_selected,
        ]);

        return redirect()->route('admin_choice.index', ['step'=>'choice-management', 'type'=>$type, 'answer_id'=>$answer_id, 'query_id'=>$query_id, 'category'=>$category, 'last_template_selected'=>$last_template_selected]);        
    }

/////////////// admin last template ///////////////////////

    public function admin_last_template_index(Request $request)
    {
        $step = $request->step;
        $mode = $request->mode;

        $last_query = DB::table('last_template')->latest('created_at')->first();
        $template = null;
        if(empty($last_query)){
            $template_id = 1;
        }else{
            //add new
            $template_id = $last_query->template_id + 1;

            //edition
            $preview_id = $request->template_id;

            $template = DB::select('select * from last_template where template_id= ?',[$preview_id]);
        }
        return view('admin-last-template')->with('step', $step)->with('template_id', $template_id)->with('template', $template)->with('mode', $mode);
    }

    public function admin_last_template_add(Request $request)
    {   
        $mode = $request->mode;
        $template_id = $request->template_id;
        $filename = $request->real_name;
        $template_name = $request->template_name;
        $template_query = $request->query_content;
        $web_url = $request->web_url;

        if(empty($mode)){
            DB::insert('insert into last_template (template_id, template_name, template_query, refer_file, web_url) values (?,?,?,?,?)', [$template_id, $template_name, $template_query, $filename, $web_url]);
        }else{
            DB::table('last_template')->where('template_id',$template_id)
                ->update([
                    'template_name' => $template_name,
                    'template_query' => $template_query,
                    'refer_file' => $filename,
                    'web_url' => $web_url,
            ]);    
        }

        $id = DB::table('last_template')->where('template_id', $template_id)->get()->first();
        $id = $id->id;
        
        // file upload path
        
        if(!empty($filename)){
            $directory_path = public_path('uploads/last_template/'.$id.'/');
            //$mode = 0777;
            //@mkdir( $directory_path, $mode, false);        
            $path = public_path('uploads/last_template/'.$id.'/'.$filename);
            $file = $request->file('filename');
            $input['filename'] = $filename.'.'.$file->getClientOriginalExtension();
            $file->move($directory_path, $filename);
        }        
        //////////////        
        return redirect()->route('admin_last_template.index', ['step'=>'last-template-management', 'template_id'=>$template_id]);
    }
    
    /////////////////////// Admin Account ////////////////////////
    /***************
     * 
     * Permission : 1 - administrator, 2 - store manager, 3 - user
     * 
     * *****************/
    
    public function admin_account_list_index(Request $request)
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
            $users = DB::select('select * from users where permission != ?',[1]);
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
        return view('admin-account-list')->with('user_id', $id)->with('origin_id', $origin_id)->with('users', $users);
    }

    public function admin_account_add(Request $request)
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

        return redirect()->route('admin_account_list.index', ['step'=>'list']);
    }


    public function admin_account_update(Request $request)
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
                    'temp_password' => $temp_password,
            ]);    

        return redirect()->route('admin_account_list.index', ['step'=>'account-confirm', 'origin_id'=>$origin_id]);
    }

//////////////////// overall //////////////

    public function admin_query_overall(Request $request)
    {
        $index = $request->index;
        $id = $request->next_id;
        $queries = DB::table('query')->where('Aid', '0')->get();
        
        $top_query = null;
        $top_answer = null;

        if(count($queries) != 0){
            if(empty($id)){
                $top_query = $queries->first();
            }else{
                $top_query = $queries[$index];                
            }
            $Qid = $top_query->id;
            $top_answer = DB::table('answer')->where('Qid', $Qid)->get();
        }
        
        return view('admin-query-overall')->with('queries', $queries)->with('top_query', $top_query)->with('top_answer', $top_answer)->with('index', $index);
    }

    public function admin_query_overall_change(Request $request)
    {
        $index = $request->index;   
        return redirect()->route('admin_query_overall.index');
    }

    public function admin_overall_delete(Request $request)
    {
        $query_id  = $request->query_id;

        if(strpos( $query_id, 'temp-') !== false){
            $query_id = str_replace("temp-", "", $query_id);
            DB::table('last_template')->where('id', $query_id)->delete();
        }else{
            DB::table('query')->where('id', $query_id)->delete();
        }

        return response()->json(['status'=>true, 'success'=>true, 'value'=>$query_id]);
    }
    ///////////////////// admin rate /////////////////////

    public function admin_rate_view(Request $request)
    {        
        $query_id = $request->query_id;        
        
        $query = DB::table('query')->where('id', $query_id)->get()->first();
        $choice_id = $query->choice_id;
        
        $label = array();        
        $value = array();
        $color = array();
                
        if(empty($choice_id)){
            $answers = DB::table('answer')->where('Qid', $query_id)->get();
        
            foreach($answers as $answer){
                $label[] = $answer->answer_content;
                $value[] = $answer->recommend;
                $color[] = "#".(str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT)).(str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT)).(str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT));
            }      
        }else{
            $label[0] = 'YES';
            $label[1] = 'NO';
            $color[0] = '#2ace54';
            $color[1] = '#820b16';
            $value[0] = $query->rate_yes;
            $value[1] = $query->rate_no;
        }

		$pie  =	 Charts::create('pie', 'highcharts')				    
                    //->labels(['First', 'Second', 'Third'])
                    ->labels($label)
                    ->values($value)
                    ->colors($color)
                    ->dimensions('900','600')
				    ->responsive(false);
        //return view('chart',compact('chart'));
        $query = DB::table('query')->where('id', $query_id)->get()->first();
        return view('rate' , compact('pie'))->with('query_id', $query_id)->with('query', $query);
    }


/////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// ajax ///////////////////////////////////////

    public function admin_top_edition(Request $request)
    {
        $data = $request->data;
        
        $type = $data['type'];
        $query_id = $data['query_id'];
        $category = $data['category'];
        $query_content = $data['query_content'];
        $answers = $data['answers'];
        
        DB::table('query')
            ->where('id',$query_id)->where('type', $type)
            ->update([
                'category' => $category,
                'query_content' => $query_content,
        ]);
            
        $answer_ids = [];        
        foreach($answers as $answer){
            $answer_ids[] = $answer['id'];
        }
        $ids = implode(',', $answer_ids);
        
        //$old = DB::select('select * from answer where id not in (?) and Qid =? ',[$ids, $query_id]);
        DB::table('answer')->select('*')->whereNotIn('id', $answer_ids)->where('Qid', $query_id)->delete();
        
        // update and insert new value
        $i = 1;
        foreach($answers as $answer){
            if($answer['id'] == 0){
                DB::table('answer')->insert([
                    'type'=>$type,
                    'Qid'=>$query_id,
                    'answer_content'=>$answer['query_content'],
                    'Anum' => $i
                ]);
            }else{
                DB::table('answer')->where('id', $answer['id'])->update([
                    'answer_content' => $answer['query_content'],
                    'Anum'=>$i
                ]);
            }
            $i++;
        }
        
        return response()->json(['status'=>true, 'success'=>true]);
    }
    
    public function admin_multiple_edition(Request $request)
    {
        $data = $request->data;
        
        $type = $data['type'];
        $query_id = $data['query_id'];
        //$category = $data['category'];
        $query_content = $data['query_content'];
        $answers = $data['answers'];
       
        DB::table('query')
            ->where('id',$query_id)->where('type', $type)
            ->update([            
                'query_content' => $query_content,
        ]);

        $answer_ids = [];        
        foreach($answers as $answer){
            $answer_ids[] = $answer['id'];
        }
        $ids = implode(',', $answer_ids);
        
        //$old = DB::select('select * from answer where id not in (?) and Qid =? ',[$ids, $query_id]);
        DB::table('answer')->select('*')->whereNotIn('id', $answer_ids)->where('Qid', $query_id)->delete();
        
        // update and insert new value
        $i = 1;
        foreach($answers as $answer){
            if($answer['id'] == 0){
                DB::table('answer')->insert([
                    'type'=>$type,
                    'Qid'=>$query_id,
                    'answer_content'=>$answer['query_content'],
                    'Anum' => $i
                ]);
            }else{
                DB::table('answer')->where('id', $answer['id'])->update([
                    'answer_content' => $answer['query_content'],
                    'Anum'=>$i
                ]);
            }
            $i++;
        }

        return response()->json(['status'=>true, 'success'=>true]);
    }

    public function admin_top_query_delete(Request $request)
    {
        $id = $request->query_id;
        $table_id = $request->table_id;  // 1 => answer , 2 => question
        $type = $request->type;
        $return_mode = $request->return_mode;

        if($type == 3){            
            DB::table('last_template')->where('template_id',$id)->delete();
            $i = 1;
            $templates = DB::table('last_template')->get();
            foreach($templates as $temp){
                DB::table('last_template')->where('id', $temp->id)->update([
                    'template_id'=> $i,
                ]);
                $i++;
            }   
        }else{
            if($table_id == 1){  // answer
                DB::table('answer')->where('id',$id)->delete();  
                DB::table('query')->where('type', $type)->where('Aid', $id)->delete();
            }else{  // query
                DB::table('query')->where('id',$id)->delete();    
                DB::table('answer')->where('type', $type)->where('Qid', $id)->delete();
            }
        }
        return response()->json(['status'=>true, 'success'=>true, 'return_mode'=>$return_mode]);
    }
    public function admin_multiple_delete(Request $request)
    {
        $id = $request->query_id;
        $type = $request->type;
        $return_mode = $request->return_mode;
        $Qid = DB::table('query')->where('Aid', $id)->get();
        $Qid = $Qid[0]->id;

        DB::table('query')->where('Aid', $id)->delete();
        DB::table('answer')->where('Qid', $Qid)->where('type', $type)->delete();
        return response()->json(['status'=>true, 'success'=>true, 'return_mode'=>$return_mode]);
    }
    public function admin_choice_delete(Request $request)
    {
        $query_id = $request->query_id;
        
        DB::table('query')->where('id', $query_id)->delete();

        return response()->json(['status'=>true, 'success'=>true, 'id'=>$query_id]);
    }

    // admin last template 
    public function admin_last_template_delete(Request $request){
        $template_id = $request->template_id;
        DB::table('last_template')->where('template_id', $template_id)->delete();
        $i = 1;
        $templates = DB::table('last_template')->get();
        foreach($templates as $temp){
            DB::table('last_template')->where('id', $temp->id)->update([
                'template_id'=> $i,
            ]);
            $i++;
        }
        return response()->json(['status'=>true, 'success'=>true]);
    }

    /// admin account delete
    public function admin_account_delete(Request $request)
    {
        $user_id = $request->user_id;
        DB::table('users')->where('user_id', $user_id)->delete();
        return response()->json(['status'=>true, 'success'=>true, 'data'=>$user_id]);
    }


}
