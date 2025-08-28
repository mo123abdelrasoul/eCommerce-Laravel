@extends('layouts.app')
@section('title', 'Vendor Profile')

@section('content')
    <div class="dashboard-container flex min-h-screen">
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Welcome Mohamed</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>New Orders</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3>53<sup class="fs-5">%</sup></h3>
                                    <p>Bounce Rate</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>User Registrations</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3>65</h3>
                                    <p>Unique Visitors</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                                    </path>
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                                    </path>
                                </svg>
                                <a href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Monthly Recap Report</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-box mb-3 text-bg-warning">
                                                <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Inventory</span>
                                                    <span class="info-box-number">5,200</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 text-bg-success">
                                                <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Mentions</span>
                                                    <span class="info-box-number">92,050</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 text-bg-danger">
                                                <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Downloads</span>
                                                    <span class="info-box-number">114,381</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 text-bg-info">
                                                <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Direct Messages</span>
                                                    <span class="info-box-number">163,921</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-center"><strong>Goal Completion</strong></p>
                                            <div class="progress-group">
                                                Add Products to Cart
                                                <span class="float-end"><b>160</b>/200</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Complete Purchase
                                                <span class="float-end"><b>310</b>/400</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <span class="progress-text">Visit Premium Page</span>
                                                <span class="float-end"><b>480</b>/800</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Send Inquiries
                                                <span class="float-end"><b>250</b>/500</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!-- ./card-body -->
                                <div class="card-footer">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end">
                                                <span class="text-success">
                                                    <i class="bi bi-caret-up-fill"></i> 17%
                                                </span>
                                                <h5 class="fw-bold mb-0">$35,210.43</h5>
                                                <span class="text-uppercase">TOTAL REVENUE</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end">
                                                <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                                                <h5 class="fw-bold mb-0">$10,390.90</h5>
                                                <span class="text-uppercase">TOTAL COST</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end">
                                                <span class="text-success">
                                                    <i class="bi bi-caret-up-fill"></i> 20%
                                                </span>
                                                <h5 class="fw-bold mb-0">$24,813.53</h5>
                                                <span class="text-uppercase">TOTAL PROFIT</span>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-3 col-6">
                                            <div class="text-center">
                                                <span class="text-danger">
                                                    <i class="bi bi-caret-down-fill"></i> 18%
                                                </span>
                                                <h5 class="fw-bold mb-0">1200</h5>
                                                <span class="text-uppercase">GOAL COMPLETIONS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-md-8">
                            <!--begin::Row-->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <!-- DIRECT CHAT -->
                                    <div class="card direct-chat direct-chat-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Direct Chat</h3>
                                            <div class="card-tools">
                                                <span title="3 New Messages" class="badge text-bg-warning"> 3 </span>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-collapse">
                                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" title="Contacts"
                                                    data-lte-toggle="chat-pane">
                                                    <i class="bi bi-chat-text-fill"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Conversations are loaded here -->
                                            <div class="direct-chat-messages">
                                                <!-- Message. Default to the start -->
                                                <div class="direct-chat-msg">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span class="direct-chat-name float-start"> Alexander Pierce
                                                        </span>
                                                        <span class="direct-chat-timestamp float-end"> 23 Jan 2:00 pm
                                                        </span>
                                                    </div>
                                                    <!-- /.direct-chat-infos -->
                                                    <img class="direct-chat-img"
                                                        src="{{ asset('assets/images/user1-128x128.jpg') }}"
                                                        alt="message user image" />
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        Is this template really for free? That's unbelievable!
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                                <!-- Message to the end -->
                                                <div class="direct-chat-msg end">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span class="direct-chat-name float-end"> Sarah Bullock </span>
                                                        <span class="direct-chat-timestamp float-start">
                                                            23 Jan 2:05 pm
                                                        </span>
                                                    </div>
                                                    <!-- /.direct-chat-infos -->
                                                    <img class="direct-chat-img"
                                                        src="{{ asset('assets/images/user3-128x128.jpg') }}"
                                                        alt="message user image" />
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">You better believe it!</div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                                <!-- Message. Default to the start -->
                                                <div class="direct-chat-msg">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span class="direct-chat-name float-start"> Alexander Pierce
                                                        </span>
                                                        <span class="direct-chat-timestamp float-end"> 23 Jan 5:37 pm
                                                        </span>
                                                    </div>
                                                    <!-- /.direct-chat-infos -->
                                                    <img class="direct-chat-img"
                                                        src="{{ asset('assets/images/user1-128x128.jpg') }}"
                                                        alt="message user image" />
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        Working with AdminLTE on a great new app! Wanna join?
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                                <!-- Message to the end -->
                                                <div class="direct-chat-msg end">
                                                    <div class="direct-chat-infos clearfix">
                                                        <span class="direct-chat-name float-end"> Sarah Bullock </span>
                                                        <span class="direct-chat-timestamp float-start">
                                                            23 Jan 6:10 pm
                                                        </span>
                                                    </div>
                                                    <!-- /.direct-chat-infos -->
                                                    <img class="direct-chat-img"
                                                        src="{{ asset('assets/images/user3-128x128.jpg') }}"
                                                        alt="message user image" />
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">I would love to.</div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                            </div>
                                            <!-- /.direct-chat-messages-->
                                            <!-- Contacts are loaded here -->
                                            <div class="direct-chat-contacts">
                                                <ul class="contacts-list">
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user1-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    Count Dracula
                                                                    <small class="contacts-list-date float-end"> 2/28/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg">
                                                                    How have you been? I was...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user7-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    Sarah Doe
                                                                    <small class="contacts-list-date float-end"> 2/23/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg"> I will be waiting for...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user3-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    Nadia Jolie
                                                                    <small class="contacts-list-date float-end"> 2/20/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg"> I'll call you back at...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user5-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    Nora S. Vans
                                                                    <small class="contacts-list-date float-end"> 2/10/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg"> Where is your new...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user6-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    John K.
                                                                    <small class="contacts-list-date float-end"> 1/27/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg"> Can I take a look at...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img"
                                                                src="{{ asset('assets/images/user8-128x128.jpg') }}"
                                                                alt="User Avatar" />
                                                            <div class="contacts-list-info">
                                                                <span class="contacts-list-name">
                                                                    Kenneth M.
                                                                    <small class="contacts-list-date float-end"> 1/4/2023
                                                                    </small>
                                                                </span>
                                                                <span class="contacts-list-msg"> Never mind I found...
                                                                </span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                </ul>
                                                <!-- /.contacts-list -->
                                            </div>
                                            <!-- /.direct-chat-pane -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <form action="#" method="post">
                                                <div class="input-group">
                                                    <input type="text" name="message" placeholder="Type Message ..."
                                                        class="form-control" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-warning">Send</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.card-footer-->
                                    </div>
                                    <!-- /.direct-chat -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- USERS LIST -->
                                    <div class="card latest-members">
                                        <div class="card-header">
                                            <h3 class="card-title">Latest Members</h3>
                                            <div class="card-tools">
                                                <span class="badge text-bg-danger"> 8 New Members </span>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-collapse">
                                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    data-lte-toggle="card-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <div class="row text-center m-1">
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user1-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Alexander Pierce
                                                    </a>
                                                    <div class="fs-8">Today</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user8-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Norman
                                                    </a>
                                                    <div class="fs-8">Yesterday</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user7-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Jane
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user6-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        John
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user2-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Alexander
                                                    </a>
                                                    <div class="fs-8">13 Jan</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user5-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Sarah
                                                    </a>
                                                    <div class="fs-8">14 Jan</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user4-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Nora
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                                <div class="col-3 p-2">
                                                    <img class="img-fluid rounded-circle"
                                                        src="{{ asset('assets/images/user3-128x128.jpg') }}"
                                                        alt="User Image" />
                                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                        href="#">
                                                        Nadia
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                            </div>
                                            <!-- /.users-list -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer text-center">
                                            <a href="javascript:"
                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View
                                                All Users</a>
                                        </div>
                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!--end::Row-->
                            <!--begin::Latest Order Widget-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Orders</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Item</th>
                                                    <th>Status</th>
                                                    <th>Popularity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                    </td>
                                                    <td>Call of Duty IV</td>
                                                    <td><span class="badge text-bg-success"> Shipped </span></td>
                                                    <td>
                                                        <div id="table-sparkline-1"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                    </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                                    <td>
                                                        <div id="table-sparkline-2"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                    </td>
                                                    <td>iPhone 6 Plus</td>
                                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                    <td>
                                                        <div id="table-sparkline-3"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                    </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td><span class="badge text-bg-info">Processing</span></td>
                                                    <td>
                                                        <div id="table-sparkline-4"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                    </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                                    <td>
                                                        <div id="table-sparkline-5"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                    </td>
                                                    <td>iPhone 6 Plus</td>
                                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                    <td>
                                                        <div id="table-sparkline-6"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                    </td>
                                                    <td>Call of Duty IV</td>
                                                    <td><span class="badge text-bg-success">Shipped</span></td>
                                                    <td>
                                                        <div id="table-sparkline-7"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                                        Place New Order
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                                        View All Orders
                                    </a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Info Boxes Style 2 -->
                            <!-- /.info-box -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Browser Usage</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="pie-chart"></div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                United States of America
                                                <span class="float-end text-danger">
                                                    <i class="bi bi-arrow-down fs-7"></i>
                                                    12%
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                India
                                                <span class="float-end text-success">
                                                    <i class="bi bi-arrow-up fs-7"></i> 4%
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                China
                                                <span class="float-end text-info">
                                                    <i class="bi bi-arrow-left fs-7"></i> 0%
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.footer -->
                            </div>
                            <!-- /.card -->
                            <!-- PRODUCT LIST -->
                            <div class="card recently-products-dashboard">
                                <div class="card-header">
                                    <h3 class="card-title">Recently Added Products</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="px-2">
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-2">
                                                <img src="{{ asset('assets/images/default-150x150.png') }}"
                                                    alt="Product Image" class="img-size-50" />
                                            </div>
                                            <div class="col-10 px-2">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Samsung TV
                                                    <span class="badge text-bg-warning float-end"> $1800 </span>
                                                </a>
                                                <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                                            </div>
                                        </div>
                                        <!-- /.item -->
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-2 image">
                                                <img src="{{ asset('assets/images/default-150x150.png') }}"
                                                    alt="Product Image" class="img-size-50" />
                                            </div>
                                            <div class="col-10 px-2">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Bicycle
                                                    <span class="badge text-bg-info float-end"> $700 </span>
                                                </a>
                                                <div class="text-truncate">
                                                    26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.item -->
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-2">
                                                <img src="{{ asset('assets/images/default-150x150.png') }}"
                                                    alt="Product Image" class="img-size-50" />
                                            </div>
                                            <div class="col-10 px-2">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    Xbox One
                                                    <span class="badge text-bg-danger float-end"> $350 </span>
                                                </a>
                                                <div class="text-truncate">
                                                    Xbox One Console Bundle with Halo Master Chief Collection.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.item -->
                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-2">
                                                <img src="{{ asset('assets/images/default-150x150.png') }}"
                                                    alt="Product Image" class="img-size-50" />
                                            </div>
                                            <div class="col-10 px-2">
                                                <a href="javascript:void(0)" class="fw-bold">
                                                    PlayStation 4
                                                    <span class="badge text-bg-success float-end"> $399 </span>
                                                </a>
                                                <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                                            </div>
                                        </div>
                                        <!-- /.item -->
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-center">
                                    <a href="javascript:void(0)" class="uppercase"> View All Products </a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
    </div>
@endsection
