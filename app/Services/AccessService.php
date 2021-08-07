<?php


namespace App\Services;

/**
 * @property-read boolean $admin
 * @property-read boolean $content
 * @property-read boolean $manager
 * @property-read boolean $dev
 * @property-read boolean $edit
 * @property-read boolean $user
 * @property-read boolean $id
 */
class AccessService
{
    private static $_instance;

    /**
     * Return global instance of AccessService
     *
     * @return AccessService
     */
    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new AccessService();
    }

    /**
     * Return user is user (!sic)
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return auth()->user() != null;
    }

    /**
     * Return user is administrator
     *
     * @return bool
     */
    public function isAdmin()
    {
        return  $this->isAuthenticated() && (auth()->user()->role == "admin" || auth()->user()->id == 1);
    }

    /**
     * Return user is content-manager
     *
     * @return bool
     */
    public function isContent()
    {
        return $this->isAdmin() || $this->isAuthenticated() && auth()->user()->role == "content";
    }

    /**
     * Return user is call-manager
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->isContent() || $this->isAuthenticated() && auth()->user()->role == "manager";
    }

    /**
     * Return developer mode enabled
     *
     * @return bool
     */
    public function isDeveloperMode()
    {
        return $this->isAdmin() && \Illuminate\Support\Facades\Session::get('devmode', false);
    }

    /**
     * Return editor mode enabled
     *
     * @return bool
     */
    public function isEditorMode()
    {
        return $this->isContent() && \Illuminate\Support\Facades\Session::get('editmode', false);
    }

    public function getUser()
    {
        return $this->isAuthenticated() ? auth()->user() : null;
    }

    public function getUserId()
    {
        return $this->isAuthenticated() ? $this->getUser()->id : null;
    }

    //------------------------- GETTERS -----------------------------
    function __get($property)
    {
        switch ($property) {
            case "auth":
                return $this->isAuthenticated();
                break;
            case "admin":
                return $this->isAdmin();
                break;
            case "content":
                return $this->isContent();
                break;
            case "manager":
                return $this->isManager();
                break;
            case "dev":
                return $this->isDeveloperMode();
                break;
            case "edit":
                return $this->isEditorMode();
                break;
            case "user":
                return $this->getUser();
                break;
            case "id":
                return $this->getUserId();
                break;
            default:
                throw new \BadMethodCallException();
        }
    }
}
