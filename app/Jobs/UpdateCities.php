<?php

namespace App\Jobs;

use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client as HTTPClient;

/**
 * Updating cities info from remote sources
 *
 * Class UpdateCities
 * @package App\Jobs
 */

class UpdateCities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $token = config("crm.token");
        $date = date('d.m.Y');
        $time = date('H:i:s');

        $data = [
            "token" => md5($token . md5($time) . $date . md5($token)),
            "date" => $date,
            "time" => $time,
            "framew"=>"laravel",
        ];

        $serialized = [
            "data" => base64_encode(json_encode($data))
        ];

        $httpClient = new HTTPClient();

        //$response = $httpClient->post('http://rus-crm.ru/scripts/cities_warehouses_availability.php', ["form_params" => $serialized]);
        $response = $httpClient->post('http://rus-erp.ru/scripts/city_address_availability.php',["form_params" => $serialized]);

        $result = $response->getBody();
        $result = json_decode($result);
        if ($result->error ?? null) {
            \MessagesStack::addError('Ошибка ' . $result->error);
            return;
        }

        $result = json_decode(base64_decode($result->success ?? null)) ?? [];
        $count = 0;
        foreach ($result as $key => $value) {
            if ($this->findAndUpdateCity($value)) $count++;
        }
    }


    /**
     * Find and update city by $remote_item
     *
     * @param $remote_item
     * @return bool|null
     */
    public function findAndUpdateCity($remote_item)
    {
        $city = $this->findCityByRemoteId($remote_item->id) ?? $this->findCityByName($remote_item->name);
        if ($city) {
            $this->updateCity($city, $remote_item);
            $city->save();
            return true;
        }
        return null;
    }

    /**
     * Find city with specified remote_id
     *
     * @param $remote_id
     * @return City|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findCityByRemoteId($remote_id)
    {
        $city = $remote_id ? City::where('remote_id', $remote_id)->first() : null;
        return $city;
    }

    /**
     * Find city with specified name
     *
     * @param $name
     * @return City|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findCityByName($name)
    {
        $name = explode(",", $name)[0];
        $name = trim($name);
        $city = City::where('name', $name)->first();
        return $city;
    }

    /**
     * Update city with remote data
     *
     * @param $city
     * @param $remote_item
     * @return bool
     */
    public function updateCity(&$city, $remote_item)
    {
        if (!($city->remote_id > 0) && $remote_item->id > 0) {
            $city->remote_id = $remote_item->id;
        }
        if (strlen($remote_item->address) > 0) {
            $city->address = $remote_item->address;
        }
        if (strlen($remote_item->timetable) > 0) {
            $city->schedule = $remote_item->timetable;
        }
        if ($remote_item->latitude && $remote_item->longitude) {
            $city->lat_map = $remote_item->latitude;
            $city->lng_map = $remote_item->longitude;
        }
    }
}
