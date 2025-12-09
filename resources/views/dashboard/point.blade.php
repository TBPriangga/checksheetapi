@extends('component.navbar')

   @section('content')
   <div class="row wrapper border-bottom white-bg page-heading">
       <div class="col-lg-10">
           <h2>Dashboard Point</h2>
           <ol class="breadcrumb">
               <li class="breadcrumb-item active">
                   <strong>Hyarihatto Activity</strong>
               </li>
           </ol>
       </div>
   </div>
   @livewire('dashboard-point')
   @stack('scripts')
   @endsection