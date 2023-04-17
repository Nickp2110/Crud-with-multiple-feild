<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Student,User};
use Illuminate\Support\Facades\DB;
use DateTime;



class StudentController extends Controller
{

    public function store(Request $req){

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        if($user->save()){
            $userid = $user->id;
            $subjects = $req->subject;
            foreach((array)$subjects as $subject){
                Student::create([
                    'subject'=>$subject,
                    'user_id'=>$userid,
                ]);
            }
        }
        return back()->with('success', 'New subject has been added.');
    }

    public function getData(){
        $data = User::get();
        $students = Student::get();
        // $data = User::select('users.*','students.id as student_id','students.user_id','students.subject')
        //                 ->leftjoin('students','students.user_id','users.id')
        //                 // ->where('users.id',$id)
        //                 ->get();
        $add = [$data,$students];
        return response()->json($add);
    }

    public function add(Request $req){
        $id=$req->id;
        if($req->ajax()) {
            $add = User::select('users.*','students.id as student_id','students.user_id','students.subject')
                        ->leftjoin('students','students.user_id','users.id')
                        ->where('users.id',$id)
                        ->get();
            return response()->json($add);
        }
    }

    function viewsubject(Request $req){
        $id=$req->id;
        $student = User::select('users.*','students.id as student_id','students.user_id','students.subject')
                        ->leftjoin('students','students.user_id','users.id')
                        ->where('users.id',$id)
                        ->get();
        return response()->json($student);
    }

    function update(Request $req){
        $update = [
            'name' => $req->name,
            'email'=> $req->email,
        ];
        $edit = User::where('id', $req->id)->update($update);
        if($edit){
            $student = Student::where('user_id',$req->id)->delete();
            if($student){
                $subjects = $req->subject;
                foreach((array)$subjects as $subject){
                    $insert=Student::create([
                        'subject'=>$subject,
                        'user_id'=>$req->id,
                    ]);
                }
                if($insert){
                    $response = [
                        'status'=>'ok',
                        'success'=>true,
                        'message'=>'Record updated succesfully!'
                    ];
                    return $response;
                }else{
                    $response = [
                        'status'=>'404',
                        'success'=>false,
                        'message'=>'Record updated failed!'
                    ];
                    return $response;
                }
            }
        }
    }

    function delete(Request $req){
        $delete = User::destroy($req->id);
        $delete1 = Student::where('user_id',$req->id)->delete();
        if($delete && $delete1){
            $response = [
                'status'=>'ok',
                'success'=>true,
                'message'=>'Record deleted succesfully!'
            ];
            return $response;
        }else{
            $response = [
                'status'=>'ok',
                'success'=>false,
                'message'=>'Record deleted failed!'
            ];
            return $response;
        }
    }

    function query(){
        $query = Student::whereBetween('id',[486,490])->get();
        return view('add',compact('query'));
    }
}
