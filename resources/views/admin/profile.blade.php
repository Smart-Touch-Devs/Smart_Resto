
@extends('admin.layouts.main')
@section('content')
<!-- BEGIN: Header-->

@include('admin.components.header')
<!-- BEGIN: Main Menu-->
@include('admin.components.horizontalBar')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
<!-- END: Main Menu-->
    <div class="row">
        <div class="offset-3 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Détails de la structure</h4>
                </div>
                <div class="card-body">

                    <div>
                        <div class="row">
                            <div class="col-12 mb-2 d-flex justify-content-between">
                                <div class="mt-1 p-1 border rounded text-center" style="width: fit-content;">
                                    <p class="small">Photo de profil</p>
                                    @if (stristr(Auth::user()->profile, 'avatar.png'))
                                    <img src="{{ asset('storage/avatars/avatar.png') }}" class="mx-auto"
                                        height="100" width="100" alt="{{Auth::user()->firstname }}">
                                    @else
                                    <img src="{{ asset('storage/avatars/' . Auth::user()->profile) }}"
                                        class="mx-auto" height="100" width="100" alt="{{Auth::user()->firstname }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <small class="small">Nom</small><br>
                                    <p class="p-1 bg-light border rounded text-italic">{{ Auth::user()->firstname }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <small class="small">Adresse email</small><br>
                                    <p class="p-1 bg-light border rounded text-italic">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <small class="small">Numéro de téléphone</small><br>
                                    <p class="p-1 bg-light border rounded text-italic">{{  Auth::user()->phone }}</p>
                                </div>
                            </div>
                                <a href="{{ route('admin.home') }}">
                                    <button class="btn btn-primary">
                                        Retour
                                    </button>
                                </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('admin.components.footer')
</div>
    <script src="{{asset('dashboard/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    @endsection
