<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// lili 
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $queries = DB::table('query')->where('type', 1)->where('Aid', 0)->get();

        return view('home')->with('queries', $queries);
    }

    public function common_index(Request $request)
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
            return view('common-answer')->with('query', $query)->with('answers', $answers)->with('result', $result)->with('type', $type)->with('step', $request->step)->with('query_id', $query_id)->with('answer_id', '')->with('index', null);
           
        }
        if($request->step == 'last-step'){
            $template_id = $request->template_id;
            $template_query = $request->template_query;
            
            return view('common-answer')->with('template_id',$template_id)->with('template_query', $template_query)->with('step', $request->step)->with('type', null)->with('index', null)->with('query_id', null);
        }
        if($request->step == 'choose'){
            $type = $request->type;
            $query_id = $request->query_id;            
            $query_content = $request->query_content;
            $index = $request->index;
            //$query = null;
            //$answers = array(0);

            return view('common-answer')->with('type', $type)->with('query_id', $query_id)->with('query_content', $query_content)->with('step', $request->step)->with('index', $index);
        }
    }   
    public function last_template_view_index(Request $request)
    {
        $file = $request->file;
        $last_id = $request->id;
        //$img = $request->img;
        
        return view('last-template-view')->with('last_id', $last_id)->with('file', $file);
    }

    public function common_answers(Request $request)
    {
        $type = $request->type;
        $query_id = $request->query_id;
        $index = $request->index;   
        $mode = $request->mode;    
        
        $final_template = false;
        
        $query = DB::table('query')->where('id', $query_id)->get()->first();
        $Aid = $query->Aid;
      
        $queries = DB::table('query')->where('type', $type)->where('Aid', $Aid)->get();        
        $ct = count($queries);
        
        if($index < $ct){
            if($mode == 'yes'){
                $recommend = $query->rate_yes;
                $recommend += 1;
                DB::table('query')->where('id', $query_id)->update([
                    'rate_yes' => $recommend, 
                ]);
            }else if($mode == 'no'){
                $recommend = $query->rate_no;
                $recommend += 1;
                DB::table('query')->where('id', $query_id)->update([
                    'rate_no' => $recommend, 
                ]);
            }            
        }
        $last_id = null;       
        $last_query = null;
        if($index == ($ct-1)){
            $final_template = true;
            $last_template = DB::table('last_template')->where('id', $query->last_template)->get()->first();
            $last_query = $last_template->template_query;
            $last_id = $last_template->id;
            
            $query_content = null;
        }
        $index++; 

        if( $final_template == false ){
            $next_query = $queries[$index];
            $query_id = $next_query->id;
            $query_content = $next_query->query_content;
        }

        return response()->json(['status'=>true, 'success'=>true, 'index'=>$index, 'final_template'=>$final_template, 'type'=>$type, 'query_id'=>$query_id, 'query_content'=>$query_content, 'last_id'=>$last_id, 'last_query'=>$last_query]);
    }

    public function common_final(Request $request)
    {
        $final_id = $request->final_id;
        $mode = $request->mode;

        $last_template = DB::table('last_template')->where('id', $final_id)->get()->first();        
        $last_file = $last_template->refer_file;
        $last_url = $last_template->web_url;

        if($mode == 'yes'){
            $recommend = $last_template->rate_yes;
            $recommend += 1;
            DB::table('last_template')->where('id', $final_id)->update([
                'rate_yes' => $recommend, 
            ]);
        }else if($mode == 'no'){
            $recommend = $last_template->rate_no;
            $recommend += 1;
            DB::table('last_template')->where('id', $final_id)->update([
                'rate_no' => $recommend, 
            ]);
        }            

        return response()->json(['status'=>true, 'success'=>true, 'last_id'=>$final_id, 'last_file'=>$last_file, 'last_url'=>$last_url]);
    }

    
}
