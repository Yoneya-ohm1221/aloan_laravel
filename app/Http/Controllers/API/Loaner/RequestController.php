<?php
namespace App\Http\Controllers\API\Loaner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestM;
use Illuminate\Support\Facades\Mail;
use DB;

class RequestController extends Controller
{
    public function request($LoanerID)
    { 
        $sql="SELECT borrowers.*,request.* FROM request
        INNER JOIN borrowlist ON borrowlist.borrowlistID = request.borrowlistID
        INNER JOIN borrowers ON request.BorrowerID  = borrowers.BorrowerID 
        WHERE (request.status = 0 OR request.status = 1) AND  borrowlist.LoanerID = $LoanerID " ;
        $recount=DB::select($sql);         
        return response()->json($recount);
    }
    //ดูข้อมูลจากไอดี
    public function ViewBorrowerRequest($requestID)
    { 
        $sql="SELECT * FROM request
        INNER JOIN borrowlist ON borrowlist.borrowlistID = request.borrowlistID
        INNER JOIN borrowers ON request.BorrowerID  = borrowers.BorrowerID 
        WHERE request.RequestID= $requestID " ;
        $recount=DB::select($sql)[0];      
           
        return response()->json($recount);
    }

    public function MenuWaitingPay($LoanerID)
    { 
        $sql="SELECT borrowers.*,request.* FROM request
        INNER JOIN borrowlist ON borrowlist.borrowlistID = request.borrowlistID
        INNER JOIN borrowers ON request.BorrowerID  = borrowers.BorrowerID 
        WHERE request.status = 2 AND  borrowlist.LoanerID = $LoanerID " ;
        $recount=DB::select($sql);         
        return response()->json($recount);
    }
    
    public function updateUnpass($id,Request $request)
    {       
        date_default_timezone_set('Asia/Bangkok');
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
    public function updatePass($id,Request $request)
    {       
        $loanerID = $request->get('loanerID');  
        $sql="SELECT * FROM borrowlist WHERE LoanerID = $loanerID";
        $data= DB::select($sql)[0];

        if($request->get('money_confirm') > $data-> money_max || $request->get('instullment_confirm') > $data-> instullment_max	){
            return response()->json(array(
                'message' => 'เกินจากจำนวนที่ตั้งไว้', 
                'status' => 'fail'));
           
        }else{
               date_default_timezone_set('Asia/Bangkok');
        $user = RequestM::find($id);
        $user->status = 1;     
        $user->dateCheck = date('Y-m-d');  
        $user->money_confirm = $request->get('money_confirm');  
        $user->instullment_confirm = $request->get('instullment_confirm');     
        $user->save();

        return response()->json(array(
            'message' => 'สำเร็จ', 
            'status' => 'true'));
        }


     
    }

       public function viewUnpass($loanerID)
    { 
   
        $sql="SELECT request.*,borrowers.*  FROM request
        INNER JOIN borrowers ON request.BorrowerID = borrowers.BorrowerID
        INNER JOIN borrowlist ON request.borrowlistID = borrowlist.borrowlistID
        WHERE 1  AND  borrowlist.LoanerID  =$loanerID AND 
        (request.status = 4 OR request.status =14) ";
     
        $recount=DB::select($sql);         
        return response()->json($recount);
    }

}