@extends('dashboard.borrower.dashboardlayout')

@section('content')
<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark border-bottom" style="background: linear-gradient(90deg, rgba(252,176,69,1) 0%, rgba(253,29,29,1) 71%, rgba(131,58,180,1) 100%);"> 
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                </div>              
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
          
          </ul>
         
                <div class="media align-items-center">
                   <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{ url('/') }}/assets/uploadfile/Borrower/profile/{{ Auth::guard('borrower')->user()->imageProfile }}" class="borrower_picture">
                  </span> 
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold" style="color:white">{{ Auth::guard('borrower')->user()->firstname }}</span>
                  </div>
                </div>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header pb-4" style="background: linear-gradient(90deg, rgba(252,176,69,1) 0%, rgba(253,29,29,1) 71%, rgba(131,58,180,1) 100%);">
<div class="header pb-4"  style="background: linear-gradient(90deg, rgba(252,176,69,1) 0%, rgba(253,29,29,1) 71%, rgba(131,58,180,1) 100%);"> 
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">รายการโปรด</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="{{ route('borrower.home') }}"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('borrower.home') }}">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ผู้ให้กู้</li>
                  </ol>
              </nav>
            </div>
          </div>
      </div>
    </div>
</div>
</div>

     <!-- Page content -->
     <div class="container-fluid mt--4">
      <div class="row justify-content-center">
        <div class=" col ">
          <div class="card">
            <div class="card-header bg-transparent">
              <h3 class="mb-0 text-center">Dashboard ผู้ให้บริการ</h3>
            </div>
            <div class="card-body">
              <div class="row">
             
              <?php   
              $BorrowerID = Auth::guard('borrower')->user()->BorrowerID;
                  $sql="SELECT *  FROM pined 
                  INNER JOIN borrowlist ON pined.borrowlistID = borrowlist.borrowlistID
                  INNER JOIN loaners ON borrowlist.LoanerID = loaners.LoanerID
                  WHERE pined.BorrowerID = $BorrowerID";
              
                  $pin=DB::select($sql);     
              ?>

              
                    @foreach($pin as $show)

                        <div class="col-xl-4 col-md-6"  >
                        <div class="card">
                        <div class="row justify-content-center">
                        <a href="borrower/viewborrower/{{$show->LoanerID}}">
                        <img class="rounded-circle" src="{{ url('/') }}/assets/uploadfile/Loaner/profile/{{ $show->imageProfile }}" alt="image profile" width='100px' height='100px'>
                        </a>  
                        </div>
                        <div class="card-body" >
                        <h3 class="card-title">คุณ {{ $show->firstname }} {{ $show->lastname }}</h3>
                        <p class="card-text">วงเงิน : 0 ~ {{ $show->money_max }} บาท</p>
                        <p class="card-text">ดอกเบี้ยรายปี : {{ $show->interest }} %</p>
                        <a href="borrower/viewborrower/{{$show->LoanerID}}" class="btn btn-primary">View</a>
                        </div>
                        </div>
                        </div>

                    @endforeach
              
              
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>

@endsection