# Modulo Crd 🎮

---

- [Crd CRUD](#section-crd)
- [Migración](#migrations)
- [Seeder](#seeds)
- [Modelo](#models)
- [Controlador](#controllers)
- [RutaWeb](#routes)
- [Vista](#views)
- [Comando](#mcr)

<a name="section-crd"></a>
## Migración, Sedder, Modelo, Controlador y Vista

Estructura del modulo Crd.. 
Si gustas es posible crear la estructura MVC de forma manual.

---

- [Migración](#migrations)
- [Seeder](#seeds)
- [Modelo](#models)
- [Controlador](#controllers)
- [RutaWeb](#routes)
- [Vista](#views)
- [Comando MCR](#mcr)

<a name="migrations"></a>
## Migración

Comando `php artisan make:migration Crd` ejecutar en consola dentro del proyecto.

> {info} Directorio  `database/migrations/2014_10_12_000000_create_crds_table.php`.

```php

class CreateCrdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('num_serie')->unique()->nullable();
            $table->string('name_machine');
            $table->string('nick_name');
            $table->string('password')->default('crd123');
            $table->string('api_token')->unique();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crds');
    }
}

```

<a name="seeds"></a>
## Seeder

Comando `php artisan make:seeder AddCrdTableSeeder` ejecutar en consola dentro del proyecto.

> {info} Directorio  `database/seeders/AddCrdTableSeeder.php`.

```php

class AddCrdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $crd = new Crd();
        $crd->id = 1;
        $crd->user_id = 1;
        $crd->num_serie = 333344441;
        $crd->name_machine = 'Angry birds';
        $crd->nick_name = 'Crd_1';
        $crd->password = Crypt::encrypt('crd123');
        $crd->api_token = ApiToken::GenerateToken32();
        $crd->save();
    }
}

```

<a name="models"></a>
## Modelo

Comando `php artisan make:model Crd` ejecutar en consola dentro del proyecto.

> {info} Directorio  `app/Crd.php`.

```php

class Crd extends Model
{
    use LaratrustUserTrait;
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id','user_id', 'name_machine', 'nick_name', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //protected $hidden = [
    //    'password', 
    //];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the user record  type hostpot.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    /**
     * Get the hostpot for the blog crd.
     */
    public function qr()
    {
        return $this->belongsToMany('App\Qr','crd_id');
    }

    /**
     * Get the hostpot for the blog crd.
     */
    public function nfc()
    {
        return $this->belongsToMany('App\Nfc','crd_id');
    }
}

```

<a name="controllers"></a>
## Controlador

Comando `php artisan make:controller Crd` ejecutar en consola dentro del proyecto.

> {info} Directorio  `app/Http/Controllers/CrdController.php`.

```php

class CrdController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $crds = Crd::all();
        foreach ($crds as $key => $crd) {
        $crd->password = Crypt::decrypt($crd->password);
        }
        return view('module.crd.index',compact('crds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testertuck()
    {
        //
        $crds = Crd::all();
        foreach ($crds as $key => $crd) {
        $crd->password = Crypt::decrypt($crd->password);
        }
        return view('module.crd.index',compact('crds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::all();
        return view('module.crd.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_id'=>'required|string|max:100',
            'num_serie'=>'required|string|max:100',
            'name_machine'=>'required|string|max:100',
            'nick_name'=>'required|string|max:100',
            'password'=>'required|string|max:100'
            
        ]);

         $crd = new Crd();
         $crd->user_id = $request->get('user_id');
         $crd->num_serie = $request->get('num_serie');
         $crd->nick_name = $request->get('nick_name');
         $crd->name_machine = $request->get('name_machine');
         $crd->password = Crypt::encrypt($request->get('password'));
         $crd->api_token = ApiToken::GenerateToken32();
         $crd->save();
        //return redirect('/crd')->with('success', 'Crd Generado Satisfactoriamente!');
        toastr()->success('Crd generado satisfactoriamente');
        return redirect()->route('crd.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Crd  $crd
     * @return \Illuminate\Http\Response
     */
    public function show(Crd $crd)
    {
        //
        $crd->password = Crypt::decrypt($crd->password);
        return view('module.crd.show',compact('crd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Crd  $crd
     * @return \Illuminate\Http\Response
     */
    public function edit(Crd $crd)
    {
        //
        $users = User::all();
        $crd->password = Crypt::decrypt($crd->password);
        return view('module.crd.edit', compact('crd','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Crd  $crd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crd $crd)
    {
        //
        $request->validate([
            'user_id'=>'required|string|max:100',
            'num_serie'=>'required|string|max:100',
            'name_machine'=>'required|string|max:100',
            'nick_name'=>'required|string|max:100',
            'password'=>'required|string|max:100',
            'api_token'=>'required|string|max:100'
        ]);
        $crd_request = $request->all();
        $crd_request['user_id'] =  $request->get('user_id');
        $crd_request['num_serie'] =  $request->get('num_serie');
        $crd_request['name_machine'] =  $request->get('name_machine');
        $crd_request['nick_name'] =  $request->get('nick_name');
        $crd_request['password'] = Crypt::encrypt($request->get('password'));
        $crd_request['api_token'] =  $request->get('api_token');
        $crd->update($crd_request);
        toastr()->warning('Crd Actualizado Satisfactoriamente');
        return redirect()->route('crd.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Crd  $crd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crd $crd)
    {
        //
        $crd->delete();
        toastr()->error('Crd eliminado satisfactoriamente');
        return redirect()->route('crd.index');
    }
}

```

<a name="routes"></a>
## Ruta Web

No cuenta con comando artisan para esto dispones ya de un archivo de rutas web.

> {info} Directorio  `routes/web.php` agregar dentro del archivo.

```php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::resource('crd', 'CrdController')->middleware('auth');
Auth::routes();

```

<a name="views"></a>
## Vista

No se cuenta con comando pero crea un archivos index para modulo de crd `index.blade.php` y pega este codigo.

> {info} Directorio  `resources/views/module/crd/index.blade.php`.

```php

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tabla Crd</h3>
              <a class="btn btn-xs btn-success float-right" href="{{ route('crd.create') }}" role="button"><span class="fas fa-plus"></span></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="crdTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>User Id</th>
                  <th>Serie</th>
                  <th>Nombre</th>
                  <th>Alias</th>
                  <th>ApiToken</th>
                  <th>FechaMod</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($crds as $crd)
                <tr>
                    <td>{{ $crd->id }}</td>
                    <td>{{ $crd->user_id }}</td>
                    <td>{{ $crd->num_serie }}</td>
                    <td>{{ $crd->name_machine }}</td>      
                    <td>{{ $crd->nick_name }}</td>
                    <td>{{ $crd->api_token }}</td>
                    <td>{{ $crd->updated_at }}</td>
                    <td>
                      <form role="form" action="{{ route('crd.destroy',$crd->id) }}" method="POST">
                      <a class="btn btn-info btn-xs" href="{{ route('crd.show',$crd->id) }}" role="button"><span class="fas fa-eye"></span></a> 
                      <a class="btn btn-warning btn-xs"  href="{{ route('crd.edit',$crd->id) }}" role="button"><span class="fas fa-pen"></span></a>
                      @csrf
                      @method('DELETE')
                      <a href="" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModalCenter{{$crd->id}}"><span class="fas fa-trash"></span></a>
                      <!------ Modal 1 ------>
                      <div class="modal fade" id="exampleModalCenter{{$crd->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                          <p class="text-center">Eliminarás ( <b>{{$crd->nick_name}}</b> ) seguro</p>
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
                  <th>User Id</th>
                  <th>NumSerie</th>
                  <th>Alias</th>
                  <th>Password</th>
                  <th>ApiToken</th>
                  <th>FechaCreacion</th>
                  <th>FechaMoficiacion</th>
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

```

<a name="mcr"></a>
## Comando para crear Migración, Modelo, Controlador + Seeder

Tu puedes crear los archivos de forma automatica y sin tanta complejidad.

☝️ En un solo comando crearas migración, modelo, controlador con recursos.

```php
   php artisan make:model Crd -mcr

```

✌️ Comando para crear Seeder.

```php
   php artisan make:seeder AddCrdTableSeeder

```



<larecipe-newsletter></larecipe-newsletter>