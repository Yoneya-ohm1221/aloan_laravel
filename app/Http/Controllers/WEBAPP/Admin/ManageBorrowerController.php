<?php

namespace App\Http\Controllers\WEBAPP\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Borrowers;
use App\Models\Borrower;

class ManageBorrowerController extends Controller
{
    public function show(Request $request){
        
        $status=$request->get('status'); 

         if($status=="1"){
         $post = Borrower::where('verify', '=', 0)->get();
         }
         if($status=="2"){
          $sql = "SELECT * FROM borrowers" ;
          $post = DB::select($sql);
         }else{
             $post = Borrower::where('verify', '=', 0)->get();
         }
        
        return view('dashboard.admin.borrowermanage', ['post'=> $post]);
    }

    public function view($BorrowerID){
        
         
        $sql = "SELECT * FROM borrowers WHERE BorrowerID =$BorrowerID";
        $post = DB::select($sql)[0];
        
        return view('dashboard.admin.borrowerview', ['view'=> $post]);
    }

    public function update1($BorrowerID){
        
        $a =Borrowers::where('BorrowerID', '=', $BorrowerID)->firstOrFail();
        $a->verify = 1;
        $a->save();
 
        return redirect('admin/borrowerview/view/'.$BorrowerID)->with('success','Approve Success');
    }
    public function update2($BorrowerID){
        
        $a =Borrowers::where('BorrowerID', '=', $BorrowerID)->firstOrFail();
        $a->verify = 2;
        $a->save();

        return redirect('admin/borrowerview/view/'.$BorrowerID)->with('fail','Reject Success');
    }


}
