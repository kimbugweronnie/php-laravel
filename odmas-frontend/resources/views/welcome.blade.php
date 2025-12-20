@extends('layouts.auth_app')

@section('content')

<div class="container mt-3">
    <div class="row mb-5">
        <div class="col-12 text-center">
        <img src="{{ asset('img/ucmb_logo.png') }}" width="120" alt="landing page image">
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-sm-12 col-md-6">
            <div class="border rounded p-4 ps-4 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-people mb-2" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                </svg>
                <h4 class="text-capitalize"> User management </h4>
                <p class="text-muted">This will involve user management and accounts, giving access to various Inforamtion Technology resources like mobile application, website, system audit, network management, storage, and more. </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="border rounded p-4 ps-4 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-kanbane mb-2" viewBox="0 0 16 16">
                    <path d="M13.5 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M6.5 3a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm-4 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm8 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1z"/>
                </svg>
                <h4 class="text-capitalize"> Projects management </h4>
                <p class="text-muted">This will involve user management and accounts, giving access to various Inforamtion Technology resources like mobile application, website, system audit, network management, storage, and more. </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="border rounded p-4 ps-4 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-texte mb-2" viewBox="0 0 16 16">
                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                </svg>
                <h4 class="text-capitalize"> Requisitions & Memos </h4>
                <p class="text-muted">This will involve user management and accounts, giving access to various Inforamtion Technology resources like mobile, website, systems, networks, storage, and more. </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="border rounded p-4 ps-4 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-activitye mb-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2"/>
                </svg>
                <h4 class="text-capitalize">Activities & more others </h4>
                <p class="text-muted">This will involve user management and accounts, giving access to various Inforamtion Technology resources like mobile, website, systems, networks, storage, and more. </p>
            </div>
        </div>
    </div>
</div>

@endsection