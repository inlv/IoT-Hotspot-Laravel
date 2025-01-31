@extends('adminlte::page')
@section('title', 'Hotspot|Erb')
@section('content_header')
   <!-- <h1>Menu Admin</h1>-->
@stop

@section('content')
 @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
@endif

@if ($message = Session::get('success'))

<div class="alert alert-success">

    <p>{{ $message }}</p>

</div>
@endif

 <!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card card-warning card-outline">
            <div class="card-header">
              <h3 class="card-title">Edit Erb</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <!-- form start -->
            <form role="form" action="{{ route('erb.update',$erb->id) }}" method="POST">
            @csrf
            @method('PUT')
              <div class="card-body">
              <div class="form-group">
                    <label for="user_id">Assigned User</label>
                        <select class="form-control" name="user_id" id="user_id">
                          @foreach($users as $user)
                          <option>{{ $user->id }}</option>
                          @endforeach
                        </select>
              </div>
                <div class="form-group">
                  <label for="num_serie">Serial Number</label>
                  <input type="text" class="form-control" name="num_serie" id="num_serie"  placeholder="Introduce Num serie" required value="{{ $erb->num_serie }}" />
                </div>
                <div class="form-group">
                  <label for="name_machine">Name</label>
                  <input type="text" class="form-control" name="name_machine" id="name_machine"  placeholder="Introduce alias" required value="{{ $erb->name_machine }}" />
                </div>
                <div class="form-group">
                  <label for="nick_name">Alias</label>
                  <input type="text" class="form-control" name="nick_name" id="nick_name"  placeholder="Introduce alias" required value="{{ $erb->nick_name }}" />
                </div>
                <div class="form-group">
                  <label for="password">Passw</label>
                  <input type="text" class="form-control" name="password" id="password" placeholder="Introduce contraseña" required value="{{ $erb->password }}" />
                </div>
                <div class="form-group">
                  <label for="api_token">Token</label>
                  <input type="text" class="form-control" name="api_token" id="api_token" placeholder="Sin Token" readonly="readonly" value="{{ $erb->api_token }}" />
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="{{ route('erb.index') }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-warning pull-right" >Send</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
          <!-- form-->
          <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content --> 
@stop

@section('footer') 
<div class="pull-right hidden-xs"><b>Version</b> 2.1.1<strong>  Copyright &copy; 2022 <a href="http://hotspot.fjlic.com/home" target="_blank">Hotspot</a>.</strong>  All rights reserved.</div> 
@stop

@section('css')
@toastr_css 
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css"> --}}
@stop

@section('js')
@toastr_js
@toastr_render
<script>
        var botmanWidget = {
          aboutText: 'FJLIC Help Center',
          introMessage: "✋ Hello!! I am your IoT-Hotspot assistant"
        };
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
@stop