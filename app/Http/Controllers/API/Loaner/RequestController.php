<?php
namespace App\Http\Controllers\API\Loaner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestM;
use DB;

class RequestController extends Controller
{
    public function request($LoanerID)
    { 
        $sql="SELECT * FROM request
        INNER JOIN borrowlist ON borrowlist.borrowlistID = request.borrowlistID
        INNER JOIN borrowers ON request.BorrowerID  = borrowers.BorrowerID 
        WHERE request.status =0 AND  borrowlist.LoanerID = $LoanerID " ;
        $recount=DB::select($sql);         
        return response()->json($recount);
    }

    public function ViewBorrowerRequest($requestID)
    { 
        $sql="SELECT * FROM request
        INNER JOIN borrowlist ON borrowlist.borrowlistID = request.borrowlistID
        INNER JOIN borrowers ON request.BorrowerID  = borrowers.BorrowerID 
        WHERE request.RequestID= $requestID " ;
        $recount=DB::select($sql)[0];         
        return response()->json($recount);
    }
    
    public function updateUnpass($id,Request $request)
    {       
        
        $user = RequestM::find($id);
        $user->status = 4;     
        $user->dateCheck = date('Y-m-d');     
        if($request->get('comment') =="" ){
        $user->comment = "ไม่ได้ระบุ.";
        }else{
        $user->comment = $request->get('comment');  
        }
        
        $user->save();

        return response()->json(array(
            'message' => 'update successfully', 
            'status' => 'true'));
    }
    public function updatePass($id)
    {       
        $user = RequestM::find($id);
        $user->status = 1;     
        $user->dateCheck = date('Y-m-d');     
        $user->save();

        return response()->json(array(
            'message' => 'update successfully', 
            'status' => 'true'));
    }

}