# User Module 🙈

---

- [CRUD User](#section-user)
- [Migration](#migrations)
- [Seeder](#seeds)
- [Model](#models)
- [Controller](#controllers)
- [RouteWeb](#routes)
- [View](#views)
- [Command](#mcr)

<a name="section-user"></a>
## Migration, Sedder, Model, Controller y View

User module structure.. 
If you like it is possible to create the MVC structure manually.

---

- [Migration](#migrations)
- [Seeder](#seeds)
- [Model](#models)
- [Controller](#controllers)
- [RouteWeb](#routes)
- [View](#views)
- [Command MCR](#mcr)

<a name="migrations"></a>
## Migration

Command `php artisan make:migration User` run in console inside project.

> {info} Directory  `database/migrations/2014_10_12_000000_create_users_table.php`.

```php

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('branch_office')->nullable();
            $table->string('serial_number')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('region_id')->references('id')->on('regions')->onUpdate('cascade')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

```

<a name="seeds"></a>
## Seeder

Command `php artisan make:seeder AddUserTableSeeder` run in console inside project.

> {info} Directory  `database/seeders/AddUserTableSeeder.php`.

```php

class AddUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $root = new User();
        $root->id = 1;
        $root->region_id = 2;
        $root->name = 'Root';
        $root->email = 'root@fjlic.com';
        $root->password = Hash::make('root@54321');
        $root->branch_office = 'Sin Asignar';
        $root->serial_number = '0000000001';
        $root->save();

        $admin = new User();
        $admin->id = 2;
        $admin->region_id = 2;
        $admin->name = 'Admin';
        $admin->email = 'admin@fjlic.com';
        $admin->password = Hash::make('admin@54321');
        $admin->branch_office = 'Sin Asignar';
        $admin->serial_number = '0000000002';
        $admin->save();

        $super = new User();
        $super->id = 3;
        $super->region_id = 2;
        $super->name = 'Super';
        $super->email = 'super@fjlic.com';
        $super->password = Hash::make('super@54321');
        $super->branch_office = 'Sin Asignar';
        $super->serial_number = '0000000003';
        $super->save();

        $user = new User();
        $user->id = 4;
        $user->region_id = 2;
        $user->name = 'User';
        $user->email = 'user@fjlic.com';
        $user->password = Hash::make('user@54321');
        $user->branch_office = 'Sin Asignar';
        $user->serial_number = '0000000004';
        $user->save();

        $disable = new User();
        $disable->id = 5;
        $disable->region_id = 2;
        $disable->name = 'Demo';
        $disable->email = 'demo@fjlic.com';
        $disable->password = Hash::make('demo@54321');
        $disable->branch_office = 'Sin Asignar';
        $disable->serial_number = '0000000005';
        $disable->save();
    }
}

```

<a name="models"></a>
## Model

Command `php artisan make:model User` run in console inside project.

> {info} Directory  `app/User.php`.

```php

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_id','name', 'email', 'password', 'branch_office', 'serial_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user record  type hostpot.
     */
    public function region()
    {
        return $this->belongsTo('App\Region', 'id');
    }

    /**
     * Get the crd for the user.
     */
    public function crd()
    {
        return $this->hasMany('App\Crd','user_id');
    }

    /**
     * Get the crd for the user.
     */
    public function erb()
    {
        return $this->hasMany('App\Erb','user_id');
    }
}

```

<a name="controllers"></a>
## Controlller

Command `php artisan make:controller User` run in console inside project.

> {info} Directory  `app/Http/Controllers/UserController.php`.

```php

class UserController extends Controller
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
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $filter = Role::all();
        if(auth()->user()->hasRole('root')){
          $roles = $filter->filter(function ($role, $key) {
              return $role->name != 'root';
          });
        }
        else if(auth()->user()->hasRole('admin')){
            $roles = $filter->filter(function ($role, $key) {
                return $role->name != 'root' && $role->name != 'admin';
            });
        }
        else if(auth()->user()->hasRole('super')){
            $roles = $filter->filter(function ($role, $key) {
                return $role->name != 'root' && $role->name != 'admin' && $role->name != 'super';
            });
        }
        else if(auth()->user()->hasRole('user')){
            $roles = $filter->filter(function ($role, $key) {
                return $role->name != 'root' && $role->name != 'admin' && $role->name != 'super' && $role->name != 'user' && $role->name != 'disable';
            });
        }
        $users = collect();
            foreach ($roles as $key => $role) {
                foreach (User::whereRoleIs($role->name)->get() as $key => $value) {
                $value->name_role = $role->name;  
                $users->push($value); 
                $users->all();
                }
            }
        return view('module.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource for Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $filter = Role::all();
        $roles = $filter->filter(function ($role, $key) {
            return $role->name != 'root';
        });
        $roles = Role::all();
        return view('module.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage for Users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:30|unique:users',
            'password'=>'required|string|min:3',
            'name_role'=>'required|string|max:50',
        ]);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' =>  Hash::make($request->get('password'))]);  
        $user->save();
        $user->attachRole($request->get('name_role'));
        toastr()->success('Usuario creado');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource for Users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        foreach (Role::all() as $key => $role) {
            if($user->hasRole($role->name)){
             $user->name_role = $role->name;        
            }
        }
        return view('module.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource for Users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        return view('module.user.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage for Users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:50',
            'name_role'=>'required|string|max:30',
            'password'=>'nullable'
        ]);
        if(!empty($request->get('password'))){
           $request['password'] = Hash::make($request->get('password'));  
        }
        else{
            $request['password'] = $user->password;  
        }
        $user_request = $request->all();
        foreach (Role::all() as $key => $role) {
            if($user->hasRole($role->name)){
               $user->detachRole($role->name);       
            }
        }
        $update_role = Role::where('name',$request->get('name_role'))->first();
        $user->attachRole($update_role);
        $user->update($user_request);
        toastr()->warning('Usuario actualizado');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage for Users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        //return redirect('/user')->with('success', 'Usuario Eliminado!');
        toastr()->error('Usuario eliminado');
        return redirect()->route('user.index');
    }
}

```

<a name="routes"></a>
## Route Web

It does not have an artisan command, for this you already have a file of web routes.

> {info} Directory  `routes/web.php` add inside file.

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
Route::resource('user', 'UserController')->middleware('auth');
Auth::routes();

```

<a name="views"></a>
## View

There is no command but it creates an index file for the user module `index.blade.php` and paste this code.

> {info} Directory  `resources/views/module/user/index.blade.php`.

```php

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">User Table</h3>
              <a class="btn btn-xs btn-success float-right" href="{{ route('user.create') }}" role="button"><span class="fas fa-plus"></span></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Mail</th>
                  <th>ModDate</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                      <form role="form" action="{{ route('user.destroy',$user->id) }}" method="POST">
                      <a class="btn btn-info btn-xs" href="{{ route('user.show',$user->id) }}" role="button"><span class="fas fa-eye"></span></a> 
                      <a class="btn btn-warning btn-xs"  href="{{ route('user.edit',$user->id) }}" role="button"><span class="fas fa-pen"></span></a>
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-xs" type="submit"><span class="fas fa-trash"></span></button>
                      </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
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
## Command to create Migration, Model, Controller + Seeder

You can create the files automatically and without so much complexity.

☝️ In a single command you will create migration, model, controller with resources.

```php
   php artisan make:model User -mcr

```

✌️ Command to create Seeder.

```php
   php artisan make:seeder AddUserTableSeeder

```

<larecipe-newsletter></larecipe-newsletter>