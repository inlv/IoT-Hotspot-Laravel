<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ApiToken;
use App\Models\Sensor;
use App\Models\HistorialSensor;
use Carbon\Carbon;

class AddHistorialSensorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sensors = Sensor::all();
        $modDate = Carbon::now()->subDays(90);
        foreach ($sensors as $key => $sensor) {
                $histosensor = new HistorialSensor();
                $histosensor->id = $sensor->id;
                $histosensor->sensor_id = $sensor->id;
                $histosensor->num_serie = $sensor->num_serie;
                $histosensor->passw = $sensor->passw;
                $histosensor->vol_1 = $sensor->vol_1;
                $histosensor->vol_2 = $sensor->vol_2;
                $histosensor->vol_3 = $sensor->vol_3;
                $histosensor->temp_1 = $sensor->temp_1;
                $histosensor->temp_2 = $sensor->temp_2;
                $histosensor->temp_3 = $sensor->temp_3;
                $histosensor->temp_4 = $sensor->temp_4;
                $histosensor->door_1 = $sensor->door_1;
                $histosensor->door_2 = $sensor->door_2;
                $histosensor->door_3 = $sensor->door_3;
                $histosensor->door_4 = $sensor->door_4;
                $histosensor->rlay_1 = $sensor->rlay_1;
                $histosensor->rlay_2 = $sensor->rlay_2;
                $histosensor->rlay_3 = $sensor->rlay_3;
                $histosensor->rlay_4 = $sensor->rlay_4;
                $histosensor->text = $sensor->text;
                $histosensor->created_at = $modDate;
                $histosensor->updated_at = $modDate;
                $histosensor->save();
        } 
        
        $id_tmp = HistorialSensor::all()->count()+1;
        for ($i=1; $i <= 12960; $i++) { // 12960
                //$modDate = $modDate->addMinutes(10);
                $temp_1_rand = ApiToken::random_float(14, 26, 2);
                $temp_2_rand = ApiToken::random_float(14, 26, 2);
                $temp_3_rand = ApiToken::random_float(14, 26, 2);
                $temp_4_rand = ApiToken::random_float(14, 26, 2);
                $modDate = $modDate->addSeconds(random_int(585, 615));
                foreach ($sensors as $key => $sensor) {
                    $histosensor = new HistorialSensor();
                    $histosensor->id = $id_tmp++;
                    $histosensor->sensor_id = $sensor->id;
                    $histosensor->num_serie = $sensor->num_serie;
                    $histosensor->passw = $sensor->passw;
                    $histosensor->vol_1 = $sensor->vol_1;
                    $histosensor->vol_2 = $sensor->vol_2;
                    $histosensor->vol_3 = $sensor->vol_3;
                    $histosensor->temp_1 = $temp_1_rand;
                    $histosensor->temp_2 = $temp_2_rand;
                    $histosensor->temp_3 = $temp_3_rand;
                    $histosensor->temp_4 = $temp_4_rand;
                    $histosensor->door_1 = $sensor->door_1;
                    $histosensor->door_2 = $sensor->door_2;
                    $histosensor->door_3 = $sensor->door_3;
                    $histosensor->door_4 = $sensor->door_4;
                    $histosensor->rlay_1 = $sensor->rlay_1;
                    $histosensor->rlay_2 = $sensor->rlay_2;
                    $histosensor->rlay_3 = $sensor->rlay_3;
                    $histosensor->rlay_4 = $sensor->rlay_4;
                    $histosensor->text = $sensor->text;
                    $histosensor->created_at = $modDate;
                    $histosensor->updated_at = $modDate;
                    $histosensor->save();
                }
        }

        foreach ($sensors as $key => $sensor) {
            $data_his = HistorialSensor::where('sensor_id', $sensor->id)->latest('created_at')->first();
            $sensor->temp_1 = $data_his->temp_1;
            $sensor->temp_2 = $data_his->temp_2;
            $sensor->temp_3 = $data_his->temp_3;
            $sensor->temp_4 = $data_his->temp_4;
            $sensor->save();
        } 
    }
}
