<?php


namespace App\Services;


use GuzzleHttp\Client as HTTPClient;

/**
 * @property-read string $key
 * @property-read string $inputs
 * @property-read boolean $enabled
 */
class CaptchaService
{
    private static $_instance;
    private $private;
    private $public;
    private $enabled;
    private $sensitivity;

    public function __construct()
    {
        $this->private = env("RECAPTCHA_PRIVATE", null);
        $this->public = env("RECAPTCHA_PUBLIC", null);
        $this->enabled = env("RECAPTCHA_ENABLED", false);
        $this->sensitivity = (float) env("RECAPTCHA_SENS", 0.5);
    }

    //----------------------------------------------

    /**
     * Returns global instance of CaptchaService
     *
     * @return CaptchaService
     */
    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new CaptchaService();
    }

    //-------------- INTERFACE ---------------------

    /**
     * Gets current public key for captcha
     *
     * @return mixed|null
     */

    public function getKey()
    {
        return $this->enabled ? $this->public : null;
    }

    /**
     * Validate request, usings "r_token" property as client verification token.
     *
     * @param $request
     * @param bool $abort
     * @return bool
     */
    public function validate($request, $abort = false)
    {
        $res = $this->verify($request->get("r_token", null));
        if (!$res && $abort) {
            abort(403);
        }
        return $res;
    }

    /**
     * Verify client token in Google Recaptcha services
     *
     * @param $token
     * @return bool
     */
    public function verify($token)
    {
        //bypass if captcha disabled;
        if (!$this->enabled) {
            return true;
        }

        //block is keys/tokens not present
        if (!$token || !$this->public || !$this->private) {
            return false;
        }

        $data = [
            'secret' => $this->private,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $httpClient = new HTTPClient();
        $response = $httpClient->post('https://www.google.com/recaptcha/api/siteverify', ["form_params" => $data]);
        try {
            $result = $response->getBody();
            $result = json_decode($result);

            if ($result->success) {
                return $result->score >= $this->sensitivity;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    //-------- getters ---------------

    function __get($property)
    {
        switch ($property) {
            case "key":
                return $this->getKey();
                break;
            case "enabled":
                return $this->enabled;
                break;
            case "inputs":
                return view("shared.recaptcha_key");
                break;
            default:
                throw new \BadMethodCallException();
        }
    }
}
