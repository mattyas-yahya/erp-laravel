@php
    use App\Models\Utility;

    // $settings = Utility::settings();
    //  $logo=asset(Storage::url('uploads/logo/'));
    // $logo=\App\Models\Utility::get_file('uploads/logo');

    // $company_logo=Utility::getValByName('company_logo_dark');
    // $company_logos=Utility::getValByName('company_logo_light');

    $setting = Utility::colorset();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    if ($color == 'theme-4') {
        $logo = 'intisolutions-blue.png';
    }elseif($color == 'theme-3'){
        $logo = 'intisolutions-green.png';
    }elseif($color == 'theme-2'){
        $logo = 'intisolutions-blue-gradiasi.png';
    }elseif($color == 'theme-1'){
        $logo = 'intisolutions.png';
    }
    // $mode_setting = \App\Models\Utility::mode_layout();
    // $SITE_RTL = Utility::getValByName('SITE_RTL');

@endphp
<!DOCTYPE html>
<html lang="en">
<head>

    <title>{{__('ERP IntiSolutions')}}</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="IntiSolutions" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/'.$logo)}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}" />
    <!-- font css -->
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}"> --}}
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}">
    <style>
        .widget-telephone, .widget-envelope, .widget-whatsapp, .widget-demo{
            background-color: white; /* Warna latar belakang */
            color: #6FD943; /* Warna teks */
            border: 1px solid #6FD943;; /* Tidak ada batas */
            padding: 15px 32px; /* Jarak padding tombol */
            text-align: center; /* Teks tengah */
            text-decoration: none;
            display: inline-block;
            font-size: 16px; /* Ukuran font */
            margin: 4px 2px; /* Jarak margin */
            transition-duration: 0.4s;
            border-radius: 100px;/* Durasi transisi efek */
            width: 500px;
            z-index: 99;
        }
        .widget-telephone:not(:hover) {
            transition: transform 0.4s ease-out;
            transform: translateX(100%); /* Efek translasi untuk tombol yang tidak diarahkan */
        }

        .widget-envelope:not(:hover) {
            transition: transform 0.4s ease-out;
            transform: translateX(100%); /* Efek translasi untuk tombol yang tidak diarahkan */
        }

        .widget-whatsapp:not(:hover) {
            transition: transform 0.4s ease-out;
            transform: translateX(100%); /* Efek translasi untuk tombol yang tidak diarahkan */
        }

        .widget-demo:not(:hover) {
            transition: transform 0.4s ease-out;
            transform: translateX(100%); /* Efek translasi untuk tombol yang tidak diarahkan */
        }


        .widget-telephone {
            position: fixed;
            top: 139px;
            right: 53px;
        }

        .widget-envelope {
            position: fixed;
            top: 207px;
            right: 53px;
        }

        .widget-whatsapp {
            position: fixed;
            top: 275px;
            right: 53px;
        }

        .widget-demo {
            position: fixed;
            top: 348px;
            right: 53px;
        }
    </style>

    <!-- vendor css -->
    {{-- @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    {{-- @endif --}}
    <link rel="stylesheet" href="{{asset('assets/css/customizer.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/landing.css')}}" />
</head>

<body class="{{$color}}">
<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-dark default top-nav-collapse">
    <div class="container">
        <a class="navbar-brand bg-transparent" href="">
            <img src="{{ asset('assets/images/'.$logo) }}" alt="logo" width="30%"/>
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-light ms-2 me-1" href="{{ route('login') }}">{{__('Login')}}</a>
                </li>
                @if($settings['enable_signup'] == 'on')
                    <li class="nav-item">
                        <a class="btn btn-light ms-2 me-1" href="{{ route('register.show') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- [ Nav ] start -->

<!-- [ Header ] start -->
<header id="home" class="bg-primary">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-5">
                <h1 class="text-white mb-sm-4 wow animate__fadeInLeft"
                    data-wow-delay="0.4s">
                    {{__('Software ERP IntiSolutions')}}
                </h1>
                <h2 class="text-white mb-sm-4 wow animate__fadeInLeft"
                    data-wow-delay="0.4s">
                    {{__('Software ERP untuk operasional bisnis lebih efisien')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Aplikasi & software ERP dari IntiSolutions dirancang untuk meningkatkan efisiensi operasional perusahaan melalui solusi otomasi bisnis yang aman dan terintegrasi.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="{{ route('login') }}" class="btn btn-light me-2">
                        <i class="far fa-eye me-2"></i>Live Demo
                    </a>
                    <a href="#" class="btn btn-outline-light" target="_blank">
                        <i class="fas fa-shopping-cart me-2"></i>Buy now
                    </a>
                </div>
            </div>
            <div class="col-sm-5">
                <img
                    src="{{asset('assets/images/front/header-mokeup.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                />
            </div>
        </div>
    </div>
</header>
<!-- [ Header ] End -->

<div class="widget2">
    <button class="widget-telephone">
        <i class="fa fa-phone" style="font-size: 25px; margin-left: -70px"></i>
        <span style="margin-left: 20px">Hubungi Kami - 0823-3800-1994</span>
        <a href="tel:6282338001994" target="_blank" style="margin-left: 20px;" class="btn btn-outline-primary rounded-pill btn-sm">Telepon</a>
    </button>
    <button class="widget-envelope">
        <i class="fa fa-envelope" style="font-size: 25px; margin-left: -160px"></i>
        <span style="margin-left: 20px">Kirim pesan via Email</span>
        <a href="mailto:hello@intisolutions.com" target="_blank" style="margin-left: 20px;" class="btn btn-outline-primary rounded-pill btn-sm">Email</a>
    </button>
    <button class="widget-whatsapp">
        <i class="fa-brands fa-whatsapp" style="font-size: 30px; margin-left: -100px"></i>
        <span style="margin-left: 20px">Kirim pesan via WhatsApp</span>
        <a href="https://wa.me/6282338001994" target="_blank" style="margin-left: 20px;" class="btn btn-outline-primary rounded-pill btn-sm">WhatsApp</a>
    </button>
    <button class="widget-demo">
        <i class="fa-solid fa-file-signature" style="font-size: 30px; margin-left: -100px"></i>
        <span style="margin-left: 20px">Demo Gratis, Daftar Sekarang</span>
        <a href="#demoForm" style="margin-left: 20px;" class="btn btn-outline-primary rounded-pill btn-sm">Daftar</a>
    </button>
    {{-- <button class="widget-telephone myButton"><i class="fa-thin fa-noted"></i></button> --}}
</div>

<!-- [ feature ] start -->
<section id="feature" class="feature">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2>
                    ERP IntiSolutions
                </h2>
                <p class="m-0">
                    Optimalkan proses bisnis dengan solusi ERP lengkap dari IntiSolutions
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div
                    class="card wow animate__fadeInUp"
                    data-wow-delay="0.8s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="card-body">
                        <div class="theme-avtar bg-danger">
                            <i class="ti ti-shield"></i>
                        </div>
                        <h6 class="text-muted mt-4">ERP IntiSolutions</h6>
                        <h4 class="my-3 f-w-600">Keamanan Data Terjamin</h4>
                        <p class="mb-0" style="padding-bottom: 20px">
                            Prosedur keamanan bersertifikasi ISO 27001 yang setara dengan bank.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.4s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="card-body">
                        <div class="theme-avtar bg-success">
                            <i class="ti ti-cloud"></i>
                        </div>
                        <h6 class="text-muted mt-4">ERP IntiSolutions</h6>
                        <h4 class="my-3 f-w-600">Tersimpan di cloud</h4>
                        <p class="mb-0" style="padding-bottom: 20px">
                            Akses seluruh data penting dengan mudah, di mana saja dan kapan saja.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.6s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="card-body">
                        <div class="theme-avtar bg-warning">
                            <i class="fa fa-money-check"></i>
                        </div>
                        <h6 class="text-muted mt-4">ERP IntiSolutions</h6>
                        <h4 class="my-3 f-w-600">Fleksibel sesuai kebutuhan</h4>
                        <p class="mb-0" style="padding-bottom: 20px">
                            Solusi fleksibel yang menyesuaikan kebutuhan dan budget.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.8s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="card-body">
                        <div class="theme-avtar bg-danger">
                            <i class="fa fa-cogs"></i>
                        </div>
                        <h6 class="text-muted mt-4">ERP IntiSolutions</h6>
                        <h4 class="my-3 f-w-600">Otomatisasi aktivitas bisnis</h4>
                        <p class="mb-0">
                            Hindari human-error serta proses manual yang memakan waktu dan biaya.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="card wow animate__fadeInUp" data-wow-delay="0.8s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="card-body">
                        <div class="theme-avtar bg-success">
                            <i class="fa-solid fa-circles-overlap"></i>
                        </div>
                        <h6 class="text-muted mt-4">ERP IntiSolutions</h6>
                        <h4 class="my-3 f-w-600">Solusi yang saling terintegrasi</h4>
                        <p class="mb-0">
                            Maksimalkan performa bisnis melalui integrasi antar produk yang praktis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ feature ] End -->

<!-- [ dashboard ] start -->
<section class="">
    <div class="container">
        <div class="row align-items-center justify-content-end mb-5">
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                >
                    {{__('ERP IntiSolutions')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.4s">
                    {{__('Teknologi untuk penuhi kebutuhan bisnis modern')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInLeft" data-wow-delay="0.6s">
                    Semua solusi dari IntiSolutions telah dirancang secara khusus untuk meningkatkan produktivitas dengan mempermudah kegiatan operasional perusahaan.
                </p>
                <div class="my-4 wow animate__fadeInLeft" data-wow-delay="0.8s">
                    <a href="#" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Buy now</a
                    >
                </div>
            </div>
            <div class="col-sm-6">
                <img
                    src="{{asset('landing/images/dash-2.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                />
            </div>
        </div>
        <div class="row align-items-center justify-content-start">
            <div class="col-sm-6">
                <img
                    src="{{asset('assets/images/front/img-crm-dash-4.svg')}}"
                    alt="Datta Able Admin Template"
                    class="img-fluid header-img wow animate__fadeInLeft"
                    data-wow-delay="0.2s"
                />
            </div>
            <div class="col-sm-4">
                <h1
                    class="mb-sm-4 f-w-600 wow animate__fadeInRight"
                    data-wow-delay="0.2s"
                >
                    {{__('ERP IntiSolutions')}}
                </h1>
                <h2 class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.4s">
                    {{__('ERP IntiSolutions Semua Dalam Satu Dengan Proyek, Akun, HRM, CRM')}}
                </h2>
                <p class="mb-sm-4 wow animate__fadeInRight" data-wow-delay="0.6s">
                     Aplikasi & software ERP dari IntiSolutions dirancang untuk meningkatkan efisiensi operasional perusahaan melalui solusi otomasi bisnis yang aman dan terintegrasi.
                </p>
                <div class="my-4 wow animate__fadeInRight" data-wow-delay="0.8s">
                    <a href="#" class="btn btn-primary" target="_blank"
                    ><i class="fas fa-shopping-cart me-2"></i>Buy now</a
                    >
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->

<section class="side-feature">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <h3 class="text-center wow animate__fadeInRight" data-wow-delay="0.6s">Telah dipercaya oleh 35.000+ perusahaan terkemuka</h3>
                <img src="{{ asset('assets/images/kerjasama.png') }}" class="mt-3 rounded mx-auto d-block wow animate__fadeInRight" data-wow-delay="0.6s">
            </div>
        </div>
    </div>
</section>

<section class="faq">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9 title">
                <h2><span>Mengenal apa itu software ERP?</span></h2>
                <p class="m-0">
                   Software ERP adalah sebuah aplikasi yang digunakan untuk merencanakan dan mengelola sumber daya perusahaan dengan harapan dapat meningkatkan produktivitas dari bisnis. Biasanya ERP berupa paket aplikasi berbasis cloud yang saling terintegrasi sesuai dengan kebutuhan perusahaan, seperti mengelola keuangan, karyawan, penjualan, hingga pajak.
                </p>
            </div>
        </div>
        @php
            $erp = [
                [
                    "title"         => "Apa pengertian dari ERP?",
                    "description"   => "ERP atau Enterprise Resource Planning adalah sebuah sistem informasi yang dapat mengintegrasikan
                    dan mengotomasi data yang dihasilkan oleh berbagai software, sehingga menghasilkan informasi yang dapat
                    digunakan pihak manajemen untuk mengambil keputusan."
                ],
                [
                    "title"         => "Apa Keuntungan Menggunakan Software ERP?",
                    "description"   => "Ada banyak manfaat dan keuntungan dalam menggunakan sebuah sistem ERP. Berikut beberapa keuntungannya: <br>
                    1. ERP software yang baik dapat menyederhanakan berbagai proses operasional yang biasanya menggunakan waktu dan tenaga yang banyak. <br>
                    2. Dapat meningkatkan kolaborasi antar tim atau departemen dalam perusahaan dengan data yang terpusat dan akurat. <br>
                    3. Kegiatan operasional yang semakin efisien dan cepat diselesaikan maka biaya operasional juga akan berkurang.<br>
                    4. Data penting perusahaan aman terjaga dengan kontrol yang lebih mudah.<br>
                    5. Yang terpenting adalah perusahaan lebih mudah dan efektif dalam membuat sebuah perencanaan bisnis dengan data yang lengkap dan akurat."
                ],
                [
                    "title"         => "Bagaimana cara kerja software ERP?",
                    "description"   => "Secara sederhana, cara kerja dari ERP adalah mengintegrasikan dan mengotomatiskan segala kegiatan operasional perusahaan dalam satu sistem yang terpusat dan terintegrasi.
                    Dengan menggunakan software ERP maka data dari berbagai departemen dapat terintegrasi satu sama lain secara real time dan otomatis sehingga pengambilan keputusan bisnis akan lebih cepat dan menguntungkan."
                ],
                [
                    "title"         => "Mengapa IntiSolutions merupakan pilihan sistem ERP perusahaan terbaik?",
                    "description"   => "IntiSolutions merupakan sistem aplikasi ERP terbaik dengan kombinasi antara aplikasi keuangan, inventory, sumber daya manusia, aplikasi chat dan perpajakan yang saling terintegrasi dengan baik. <br>
                    Harga yang ditawarkan oleh IntiSolutions juga sangat terjangkau, karena Anda dapat memilih software apa saja yang dibutuhkan oleh perusahaan. <br>
                    Anda dapat mencoba software-software ERP dari IntiSolutions secara gratis."
                ],
            ];
        @endphp
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-xxl-8">
                <div class="accordion accordion-flush" id="accordionExample">
                    @foreach ($erp as $key=> $item)
                    <div class="accordion-item card">
                        <h2 class="accordion-header" id="heading{{ $key+1 }}">
                            <button class="accordion-button collapsed"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key+1 }}"
                                aria-expanded="false" aria-controls="collapse{{ $key+1 }}">
                                <span class="d-flex align-items-center">
                                <i class="ti ti-info-circle text-primary"></i> {{ $item['title'] }}
                                </span>
                            </button>
                        </h2>
                        <div id="collapse{{ $key+1 }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $key+1 }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! $item['description'] !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ faq ] End -->

@include('layouts.message')

<section class="side-feature" id="demoForm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <h5 class="card-header">Coba Gratis Software ERP untuk Bisnis yang Lebih Berkembang!</h5>
                    <form action="{{ route('dashboard.store') }}" method="post" autocomplete="off">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}">
                                        @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}">
                                        @error('company')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">No.Telp/Whatsapp</label>
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp') }}">
                                        @error('no_telp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">Industri</label>
                                        <select name="industri" class="form-select @error('industri') is-invalid @enderror">
                                            <option selected disabled>Pilih Industri</option>
                                            @foreach ($industri as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('industri')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label">Solusi</label>
                                        <select name="solusi" class="form-select @error('solusi') is-invalid @enderror">
                                            <option selected disabled>Solusi</option>
                                            @foreach ($solusi as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('solusi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="" cols="10" rows="5" class="form-control">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button href="#" class="btn btn-primary">Coba Gratis</button>
                        </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
</section>

{{-- start --}}
<section class="side-feature">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <img src="{{ asset('assets/images/'.$logo) }}" class="rounded mx-auto d-block" width="20%">
                <h3 class="text-center">Siap untuk maju bersama IntiSolutions?</h3>
                <p class="text-center text-muted mt-4">
                    Tingkatkan efisiensi, produktivitas, dan performa bisnis dengan berbagai <br> produk IntiSolutions yang telah digunakan oleh puluhan ribu bisnis di Indonesia.
                </p>
                <div class="text-center pt-sm-2 feature-mobile-screen">
                    <a href="https://wa.me/6282338001994" target="_blank" class="btn px-sm-3 btn-outline-primary">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- end --}}

<!-- [ dashboard ] start -->
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                @if($settings['cust_darklayout'] && $settings['cust_darklayout'] == 'on' )

                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                         alt="logo" style="width: 150px;" >
                @else

                    <img src="{{ asset('assets/images/'.$logo) }}"
                         alt="logo" style="width: 50%">
                @endif
            </div>
            <div class="col-lg-6 col-sm-12 text-end">
                <p class="text-body">Jalan Rungkut Permai V/K-9 Surabaya</p>
                <p class="text-body">Copyright © {{ date('Y') }} | Design By ERP Intisolutions</p>
            </div>
        </div>
    </div>
</section>
<!-- [ dashboard ] End -->

<!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pages/wow.min.js')}}"></script>
<script>
    var myButton = document.getElementById(".myButton");
    myButton.addEventListener("mouseenter", function() {
    myButton.style.right = "0";
    });
    myButton.addEventListener("mouseleave", function() {
    myButton.style.right = "-100px";
    });
    var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?68301';
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url;
    var options = {
        "enabled":true,
        "chatButtonSetting":{
            "backgroundColor":"#4dc247",
            "ctaText":"Hubungi Kami",
            "borderRadius":"25",
            "marginLeft":"0",
            "marginBottom":"65",
            "marginRight":"25",
            "position":"right"
        },
        "brandSetting":{
            "brandName":"IntiSolution",
            "brandSubTitle":"Siap membantu kebutuhan anda",
            "brandImg":"{{ url('assets/images/intisolutions-white.png') }}",
            "welcomeText":"Halo, Ada yang bisa kami bantu?",
            "messageText":"Halo, Saya ingin bertanya",
            "backgroundColor":"#0a5f54",
            "ctaText":"Silahkan Hubungi Kami",
            "borderRadius":"25",
            "autoShow":false,
            "phoneNumber":"6282338001994"
        }
    };
    s.onload = function() {
        CreateWhatsappChatWidget(options);
    };
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
</script>
<script>
    // Start [ Menu hide/show on scroll ]
    let ost = 0;
    document.addEventListener("scroll", function () {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
        } else if (cOst > ost) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
            document.querySelector(".navbar").classList.remove("default");
        } else {
            document.querySelector(".navbar").classList.add("default");
            document
                .querySelector(".navbar")
                .classList.remove("top-nav-collapse");
        }
        ost = cOst;
    });
    // End [ Menu hide/show on scroll ]
    var wow = new WOW({
        animateClass: "animate__animated", // animation css class (default is animated)
    });
    wow.init();
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: "#navbar-example",
    });
</script>
</body>
</html>
