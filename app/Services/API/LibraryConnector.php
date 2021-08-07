<?php


namespace App\Services\API;


use GuzzleHttp\Client as HTTPClient;

class LibraryConnector
{
    private $token;
    private $date;
    private $time;

    public function __construct()
    {
        $this->date = date('d.m.Y');
        $this->time = date('H:i:s');
        $this->token = md5(config("crm.token") . md5($this->time) . $this->date . md5(config("crm.token")));
    }

    //============================================================================//

    public function exist($remote)
    {
        $res = $this->_get([$remote], []);
        return count($res ?? []) > 0;
    }

    public function order($remotes)
    {
        return $this->_get($remotes, []);
    }

    public function cases($remotes)
    {
        return $this->_get($remotes, ['cases']);
    }

    public function prices($remotes)
    {
        return $this->_get($remotes, ['prices']);
    }

    public function description($remotes)
    {
        return $this->_get($remotes, ['description']);
    }

    public function status($remotes)
    {
        return $this->_get($remotes, ['status']);
    }

    public function get($remotes, $data)
    {
        return $this->_get($remotes, $data);
    }


    //===========================================================================//

    public static function relayLink($remote_id)
    {
        $date = date('d.m.Y');
        $time = date('H:i:s');
        $token = md5(config("crm.token") . md5($time) . $date . md5(config("crm.token")));

        return config("crm.library_address") . "api/relay/{$remote_id}/edit?token={$token}&date={$date}&time={$time}";
    }

    public static function widgetLink($remote_id)
    {
        $date = date('d.m.Y');
        $time = date('H:i:s');
        $token = md5(config("crm.token") . md5($time) . $date . md5(config("crm.token")));
        $target = config("crm.my_domain");
        //http://library1337.f1-gtr.ru/api/library/product/1528054?data%5B%5D=system&data%5B%5D=status&target=gsmdom.ru&widget=1
        return config("crm.library_address") . "api/library/product/{$remote_id}?token={$token}&date={$date}&time={$time}&data%5B%5D=system&data%5B%5D=status&target={$target}&widget=1";
    }

    //===========================================================================//

    public function send($data)
    {
        $data = [
            "token" => $this->token,
            "date" => $this->date,
            "time" => $this->time,

            "target" => config("crm.my_domain"),
            "data" => ['cases', 'description'],
            "products" => $data
        ];

        $client = new HTTPClient(['verify' => false]);
        try {
            $response = $client->post(config("crm.library_address") . "api/library/products", ["form_params" => $data]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return null;
        }
        return json_decode($response->getBody(), true);
    }

    private function _get($remotes, $data = [], $head = false)
    {
        $data = [
            "token" => $this->token,
            "date" => $this->date,
            "time" => $this->time,
            "target" => config("crm.my_domain"),
            "data" => $data,
            "head" => $head
        ];

        if (is_array($remotes) && count($remotes)) {
            $data['products'] = $remotes;
        }

        $res = [];

        $client = new HTTPClient(['verify' => false]);
        try {
            $frames = 1;
            for ($frame = 0; $frame < $frames; $frame++) {
                $data['frame'] = $frame;
                $response = $client->get(config("crm.library_address") . "api/library/products", ["query" => $data]);

                if ($response->getStatusCode() != 200) {
                    return null;
                }

                $response = json_decode($response->getBody(), true);
                $frames = $response['frames'];
                $res = array_merge($res, $response['products']);

            }
            return $res;

        } catch (\Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return null;
        }
    }

    //======================= Promocode ======================

    public function promocodeCheck($code)
    {
        $data = [
            "token" => $this->token,
            "date" => $this->date,
            "time" => $this->time,
            "target" => config("crm.my_domain"),
            "code" => $code,
        ];

        $client = new HTTPClient(['verify' => false]);

        try {
            $response = $client->post(config("crm.library_address") . "api/promocode/check", ["form_params" => $data]);

            if ($response->getStatusCode() != 200) {
                return null;
            }

            $response = json_decode($response->getBody());
            if($response->status)
            {
                return $response;
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return null;
        }
        return null;
    }

    public function promocodeApply($code, $remotes)
    {
        $data = [
            "token" => $this->token,
            "date" => $this->date,
            "time" => $this->time,
            "target" => config("crm.my_domain"),
            "code" => $code,
            "products" => $remotes
        ];
        $client = new HTTPClient(['verify' => false]);
        try {
            $response = $client->post(config("crm.library_address") . "api/promocode/apply", ["form_params" => $data]);

            if ($response->getStatusCode() != 200) {
                return null;
            }

            $response = json_decode($response->getBody());
            if($response->status)
            {
                return true;
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return null;
        }
        return null;
    }
}
