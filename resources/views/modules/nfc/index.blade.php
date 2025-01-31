@extends('adminlte::page')
@section('title', 'Hotspot|Nfc')
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
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Tabla Nfc</h3>
              <a class="btn btn-xs btn-success float-right" href="{{ route('nfc.create') }}" role="button"><span class="fas fa-plus"></span></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="nfcTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Crd</th>
                  <th>Erb</th>
                  <th>Serie</th>
                  <th>Cont Qr</th>
                  <th>Cont Mon</th>
                  <th>Cont Mon 2</th>
                  <th>Cont Corte</th>
                  <th>Cont Prem</th>
                  <th>Cost Mon</th>
                  <th>Ssid</th>
                  {{-- <th>Passw</th>  --}}
                  <th>Ip Server</th>
                  <th>Puerto</th>
                  <th>Texto</th>
                  {{--<th>FechaMod</th>--}}
                  <th>FechaMod</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($nfcs as $nfc)
                <tr>
                    <td>{{ $nfc->id }}</td>
                    <td>{{ $nfc->crd_id }}</td>
                    <td>{{ $nfc->erb_id }}</td>
                    <td>{{ $nfc->num_serie }}</td>
                    <td>{{ $nfc->cont_qr }}</td>
                    <td>{{ $nfc->cont_mon }}</td>
                    <td>{{ $nfc->cont_mon_2 }}</td>
                    <td>{{ $nfc->cont_corte }}</td>
                    <td>{{ $nfc->cont_prem }}</td>
                    <td>{{ $nfc->cost_mon }}</td>
                    <td>{{ $nfc->ssid }}</td>
                   {{-- <td>{{ $nfc->passwd }}</td> --}}
                    <td>{{ $nfc->ip_server }}</td>
                    <td>{{ $nfc->port }}</td>
                    <td>{{ $nfc->txt }}</td>
                    {{--<td>{{ $nfc->created_at }}</td>--}}
                    <td>{{ $nfc->updated_at }}</td>
                    <td>
                      <form role="form" action="{{ route('nfc.destroy',$nfc->id) }}" method="POST">
                      <a class="btn btn-info btn-xs" href="{{ route('nfc.show',$nfc->id) }}" role="button"><span class="fas fa-eye"></span></a> 
                      <a class="btn btn-warning btn-xs"  href="{{ route('nfc.edit',$nfc->id) }}" role="button"><span class="fas fa-pen"></span></a>
                      @csrf
                      @method('DELETE')
                      <a href="" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModalCenter{{$nfc->id}}"><span class="fas fa-trash"></span></a>
                      <!------ ESTE ES EL MODAL QUE SE MUESTRA AL DAR CLICK EN EL BOTON "ELIMINAR" ------>
                      <div class="modal fade" id="exampleModalCenter{{$nfc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Ten cuidado con esta acción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="modal-body" style="text-align: center">
                            <a><img src="{{ asset('storage/Images/Warning.JPG') }}" alt="" title=""  text-align="center" /></a>
                           </div>
                           <br>
                          <p class="text-center">Eliminarás ( <b>{{$nfc->num_serie}}</b> ) seguro?</p>
                      </div>
                      <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-danger" value="Eliminar">
                      </div>
                      </div>
                      </div>
                      </div>
                    <!--fin modal--> 
                      </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
               <!-- <tfoot>
                 <tr>
                 <th>Id</th>
                  <th>Crd</th>
                  <th>Erb</th>
                  <th>Serie</th>
                  <th>Clv1</th>
                  <th>Clv2</th>
                  <th>Clv3</th>
                  <th>Clv4</th>
                  <th>Clv5</th>
                  <th>Ssid</th>
                  <th>Passw</th>
                  <th>Ip Server</th>
                  <th>Dns Server</th>
                  <th>Puerto</th>
                  <th>Protocol</th>
                  <th>Texto</th>
                  <th>FechMod</th>
                  <th>FechMod</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>-->
              </table>
            </div>
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
<div class="pull-right hidden-xs"><b>Version</b> 2.0.1<strong>  Copyright &copy; 2021 <a href="http://hotspot.fjlic.com/home" target="_blank">Hotspot</a>.</strong>  Todo los derechos Reservados.</div> 
@stop

@section('css')
@toastr_css 
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css"> --}}
@stop

@section('js')
@toastr_js
@toastr_render
<script>
  $(function () {
     $('#nfcTable').DataTable({  
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'scrollX'     : true,
      'scrollY'     : false,
      'scrollCollapse': false
      //'language': {'url': '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'}   
    })
  });
</script>
<script>
        var botmanWidget = {
            aboutText: 'Centro de Ayuda FJLIC',
            introMessage: "✋ Hola!! soy tu asistente IoT-Hotspot"
        };
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
@stop