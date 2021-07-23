@extends('dashboard.borrower.dashboardlayout')

@section('content')
<div class="header pb-4"  style="background: linear-gradient(90deg, rgba(252,176,69,1) 0%, rgba(253,29,29,1) 71%, rgba(131,58,180,1) 100%);"> 
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="{{ route('borrower.home') }}"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('borrower.home') }}">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Default</li>
                  </ol>
              </nav>
            </div>
          </div>
      </div>
    </div>
</div>
</div>
<link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <?php
    $BorrowerID = Auth::guard('borrower')->user()->BorrowerID;
    $sql="SELECT request.*,loaners.*  FROM request
    INNER JOIN borrowlist ON borrowlist.borrowlistID =request.borrowlistID
    INNER JOIN loaners ON loaners.LoanerID  =borrowlist.LoanerID 
    WHERE 1  AND (request.status = 4 OR request.status = 14) AND request.BorrowerID ='$BorrowerID'";
    
 
        $post = DB::select($sql); 
    ?>

		<div class="container-fluid mt--4">
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl">
						  <thead>
						    <tr>
						
						    	<th>ผู้ให้กู้</th>
                  <th>จำนวนเงิน</th>
						      <th>รายการ</th>
                  <th>สถานะ</th>
						      <th>Action</th>
						
						    </tr>
						  </thead>
						  <tbody>
                          @foreach($post as $item)
						    <tr class="alert" role="alert">
                           
						      <td class="d-flex align-items-center">
                              <div class="img" style="background-image: url(/assets/uploadfile/Loaner/profile/{{$item->imageProfile}});">
                            </div>
						      	<div class="pl-3 email">
                                  <span>{{$item->firstname}} {{$item->lastname}}</span>
						      		<span></span>
						      		
						      	</div>
						      </td>
                              <td  style="color: green;">
                              <div class="pl-3 email">
						      		<span>จำนวนเงินที่กู้: ฿{{$item->Money}}</span>
						      		<span>จำนวนงวด: {{$item->instullment_request}} </span>
                         
						      	</div>  
                  </td>
						      <td>
                              <div class="pl-3 email">
                              <span>วันที่เริ่ม: {{$item->dateRe}} </span>
                              <span>วันที่ส่งคำขอ: {{$item->dateCheck}} </span>
						      	</div>  
                              </td>
                              <td style="color: red;">ไม่สำเร็จ</td>
                              <td>
                              <a href="" button class="btn btn-info"  data-toggle="modal" data-target="#unpass{{$item->RequestID}}" type="button">สาเหตุ</a>           
				        	</td>
                            
                  <div class="modal fade" id="unpass{{$item->RequestID}}" tabindex="-1" role="dialog" aria-labelledby="criModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title " id="criModalLabel">สาเหตุ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                              <div class="modal-body">
                                                <form  action="#" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                      <div class="row">
                                                          <div class="col-lg-5">
                                                                    <h4><label class="card-title col-md-11 col-form-label text-md-center">สาเหตุเพราะ</label></h4> 
                                                          </div>
                                                          <div class="col-md-6">
                                                            <div class="input-group"> 
                                                              <textarea class="form-control" disabled="disabled">{{$item->comment}}</textarea>
                                                               </div>     
                                                            </div>   
                                                      </div>
 
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                              </div>
                                                </form>
                                            </div>
                                </div>
                          </div>
                    </div>

						    </tr>
                            @endforeach
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	



@endsection