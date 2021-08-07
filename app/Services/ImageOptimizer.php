<?php


namespace App\Services;

use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimizer
{
    private static $_public_folder = "/public";
    private static $_root_folder = null;
    private static $_im_styles_folder = null;
    private static $_im_uploads_folder = null;
    private static $_ready = false;

    public static function Compress($path, $token = "")
    {
        if ($path === '/images/project/no-photo.jpg')
        {
            return ["status" => false, "message" => "Попытка сжать заглушку!"];
        }

        $message = "";
        try {
            $full_path = static::$_root_folder . "/" . $path;
            $old = filesize($full_path);
            \Tinify\setKey($token);
            \Tinify\validate();
            $source = \Tinify\fromFile($full_path);
            $source->toFile($full_path);
            clearstatcache();
            $new = filesize($full_path);
            $compressionsThisMonth = \Tinify\compressionCount();
            return ["status" => true, "old" => $old, "new" => $new, "api_count" => $compressionsThisMonth];
        } catch (\Tinify\AccountException $e) {
            $message = "Ошибка ключа: " . $e->getMessage();

            // Verify your API key and account limit.
        } catch (\Tinify\ClientException $e) {
            $message = "Неверный формат изображения: " . $e->getMessage();
            // Check your source image and request options.
        } catch (\Tinify\ServerException $e) {
            $message = "Ошибка сервиса сжатия: " . $e->getMessage();
            // Temporary issue with the Tinify API.
        } catch (\Tinify\ConnectionException $e) {
            $message = "Ошибка соединения: " . $e->getMessage();
            // A network connection error occurred.
        } catch (Exception $e) {
            $message = "Ошибка: " . $e->getMessage();
            // Something else went wrong, unrelated to the Tinify API.
        }

        return ["status" => false, "message" => $message];
    }


    public static function Auto($path, $compress = false, $flush = false)
    {
        if ($path === '/images/project/no-photo.jpg')
        {
            return $path;
        }
        //-------------- COMPRESS -----------------
        if ($compress) {
            static::_optimize(static::$_root_folder . "/" . $path, static::$_root_folder . "/" . $path);
        }

        //-------------- GENERATE BY MODES ---------------
        $modes = config('optimizer.modes') ?? [];
        foreach ($modes as $mode) {
            switch ($mode["name"]) {
                //--------------------------------//
                //      ADD NEW MODES HERE        //
                //--------------------------------//
                case "fit":
                    static::_fitMode($path, $mode["width"], $mode["height"], $flush);
                    break;
                case "size":
                    static::_sizeMode($path, $mode["width"], $mode["height"], $flush);
                    break;
            }
        }
    }

    public static function Assign($path, ...$params)
    {
        if ($path === '/images/project/no-photo.jpg')
        {
            return $path;
        }

        if (!static::$_ready) {
            return $path;
        }
        //--------------parse params----------------

        //--------------------------------//
        //      ADD NEW MODES HERE        //
        //--------------------------------//

        //optimize mode
        if (count($params) == 0) {
            return static::_assign($path, "orig");
        }
        //fit mode
        if (count($params) == 2) {
            return static::_assign($path, "fit_w" . $params[0] . "_h" . $params[1]);
        }

        //manual mode
        if (count($params) == 3) {
            if ($params[2] == "fit")
                return static::_assign($path, "fit_w" . $params[0] . "_h" . $params[1]);
            if ($params[2] == "size")
                return static::_assign($path, "size_w" . $params[0] . "_h" . $params[1]);
        }

        return $path;
    }


    public static function Optimize($path, ...$params)
    {
        if ($path === '/images/project/no-photo.jpg')
        {
            return $path;
        }

        if (!static::$_ready || !self::_valid($path)) {
            return $path;
        }

        try {
            //--------------parse params----------------

            //--------------------------------//
            //      ADD NEW MODES HERE        //
            //--------------------------------//

            //optimize mode
            if (count($params) == 0) {
                return static::_optimizeMode($path);
            }
            //fit mode
            if (count($params) == 2) {
                return static::_fitMode($path, $params[0], $params[1]);
            }
            //manual mode
            if (count($params) == 3) {
                if ($params[2] == "fit")
                    return static::_fitMode($path, $params[0], $params[1]);
                if ($params[2] == "size")
                    return static::_sizeMode($path, $params[0], $params[1]);
            }

        } catch (\Exception $e) {
            report($e);
            return $path;
        }

        return $path;
    }

    public static function CheckKey($object = false)
    {
        $message = "";
        $compressionsThisMonth = -1;
        try {
            $key = getConfigValue("TinyPNGApiKey");
            \Tinify\setKey($key);
            \Tinify\validate();
            $compressionsThisMonth = \Tinify\compressionCount();
        } catch (\Tinify\AccountException $e) {
            $message = "Ошибка ключа: " . $e->getMessage();

            // Verify your API key and account limit.
        } catch (\Tinify\ClientException $e) {
            $message = "Неверный формат изображения: " . $e->getMessage();
            $compressionsThisMonth = -1;
            // Check your source image and request options.
        } catch (\Tinify\ServerException $e) {
            $message = "Ошибка сервиса сжатия: " . $e->getMessage();
            $compressionsThisMonth = -1;
            // Temporary issue with the Tinify API.
        } catch (\Tinify\ConnectionException $e) {
            $message = "Ошибка соединения: " . $e->getMessage();
            $compressionsThisMonth = -1;
            // A network connection error occurred.
        } catch (Exception $e) {
            $message = "Ошибка: " . $e->getMessage();
            $compressionsThisMonth = -1;
            // Something else went wrong, unrelated to the Tinify API.
        }

        return $object ? (object)["status" => $compressionsThisMonth, "message" => $message] : ["status" => $compressionsThisMonth, "message" => $message];
    }

    public static function FixImageName($image, $slug)
    {
        if ($image === '/images/project/no-photo.jpg')
        {
            return $image;
        }
        //----------------- SET FILENAME BY ALIAS -------------------
        if ($slug && !strpos($image, $slug) && is_file(static::$_root_folder . "/" . $image)) {
            $i = 0;
            $exploded = explode(".", $image);
            $ext = array_last($exploded);
            $filename = $slug . "." . $ext;
            while (is_file(static::$_root_folder . "/images/uploads/" . $filename)) {
                $i++;
                $filename = $slug . '_' . $i . "." . $ext;
            }
            rename(static::$_root_folder . "/" . $image, static::$_root_folder . "/images/uploads/" . $filename);
            return "/images/uploads/" . $filename;
        }
        //-----------------------------------------------------------
        return $image;
    }

    public static function Init()
    {
        static::$_root_folder = base_path() . (config("optimizer.public_path") ?? static::$_public_folder);
        static::$_im_styles_folder = static::$_root_folder . "/images/styles";
        static::$_im_uploads_folder = static::$_root_folder . "/images/uploads";
        if (!file_exists(static::$_im_styles_folder)) {
            mkdir(static::$_im_styles_folder);
        }
        static::$_ready = true;
    }

    //================== TOOLBOX ===================//

    //----- PATH TOOLS ---------
    /**
     * Check the $path target to file with extension
     *
     * @param $path
     * @return false|int
     */
    private static function _valid($path)
    {
        $fr = "/([\w\.\-]+)$/";

        return preg_match($fr, $path);

    }

    /**
     * Check the file with name $image exist in mode folder
     *
     * @param $image
     * @param $mode
     * @return bool|string
     */
    private static function _exists($image, $mode)
    {
        if (!is_null($image)) {
            //return file_exists(static::$_im_styles_folder."/".$mode."/".$image);
            return is_file(static::$_im_styles_folder . "/" . $mode . "/" . $image);
        }
        return false;
    }

    /**
     * Assign the real image to optimized image
     *
     * @param $path
     * @param $mode
     * @return string
     */
    private static function _assign($path, $mode)
    {
        $image = self::_extract_filename($path);
        return "/images/styles/" . $mode . "/" . $image;
        //$exists = self::_exists($image,$mode);
        //return $exists ? "/images/styles/".$mode."/".$image : $path;
    }

    private static function _flush($path, $mode)
    {
        $filename = self::_store($path, $mode);
        if (file_exists($filename)) {
            unlink(self::_store($path, $mode));
        }
    }

    /**
     * Generate file path for storing image with selected mode
     *
     * @param $path
     * @param $mode
     * @return string
     */
    private static function _store($path, $mode)
    {

        if (!file_exists(static::$_im_styles_folder . "/" . $mode)) {
            mkdir(static::$_im_styles_folder . "/" . $mode);
        }
        return static::$_im_styles_folder . "/" . $mode . "/" . self::_extract_filename($path);
    }

    /**
     * Get file name by patch
     *
     * @param $path
     * @return mixed|null
     */
    private static function _extract_filename($path)
    {
        $fr = "/([\w\.\-]+)$/";
        preg_match($fr, $path, $matches);
        return isset($matches[0]) ? $matches[0] : null;
    }

    //------ EDIT TOOLS ------------

    //modes
    /**
     * Fit image to container with $w $h
     *
     * @param $path
     * @param $w
     * @param $h
     * @param $flush
     * @return bool|mixed|string
     */
    private static function _fitMode($path, $w, $h, $flush = false)
    {
        $mode = "fit_w" . $w . "_h" . $h;
        if (!static::_exists($path, $mode)) {
            if ($flush) {
                static::_flush($path, $mode);
            }
            static::_fit(static::$_root_folder . "/" . $path, static::_store($path, $mode), $w, $h);
        }
        return static::_assign($path, $mode);
    }

    /**
     * Size image size  to $w $h
     *
     * @param $path
     * @param $w
     * @param $h
     * @param $flush
     * @return bool|mixed|string
     */
    private static function _sizeMode($path, $w, $h, $flush = false)
    {
        $mode = "size_w" . $w . "_h" . $h;
        if (!static::_exists($path, $mode)) {
            if ($flush) {
                static::_flush($path, $mode);
            }
            static::_size(static::$_root_folder . "/" . $path, static::_store($path, $mode), $w, $h);
        }
        return static::_assign($path, $mode);
    }


    /**
     * Optimize image using spatie
     *
     * @param $path
     * @return bool|mixed|string
     */
    private static function _optimizeMode($path)
    {
        $mode = "orig";
        if (!static::_exists($path, $mode)) {
            static::_optimize(static::$_root_folder . "/" . $path, static::_store($path, $mode));
        }
        return static::_assign($path, $mode);
    }


    //tools

    /**
     * Fit image
     *
     * @param $source
     * @param $destination
     * @param $width
     * @param $height
     * @return mixed
     */
    private static function _fit($source, $destination, $width, $height)
    {
        if (is_file($source)) {
            try {
                $img = \Image::make($source);
                $img->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($destination);
                return $destination;
            } catch (\Exception $e) {
                dd($e);
            }
        }
        return null;
    }

    private static function _size($source, $destination, $width, $height)
    {
        if (is_file($source)) {
            try {
                $img = \Image::make($source);
                if ($img->width() > $img->height()) {
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }, 'center');
                } else {
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }, 'center');
                }
                $bg = \Image::canvas($width, $height);
                $bg->insert($img, 'center');
                $img->save($destination, 95);
                return $destination;
            } catch (\Exception $e) {
                dd($e);
            }
        }
        return null;
    }

    /**
     * Optimize image
     *
     * @param $source
     * @param $destination
     * @return mixed
     */
    private static function _optimize($source, $destination)
    {
        copy($source, $destination);
        //================= OPTIMIZER STRATEGY ==================
        if (env("IMG_OPTIMIZER_SPATIE", false)) {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($destination);
        }
        if (env("IMG_OPTIMIZER_TINYPNG", true)) {
            \Tinify\setKey(getConfigValue("TinyPNGApiKey"));
            \Tinify\validate();
            $source = \Tinify\fromFile($destination);
            $source->toFile($destination);
        }
        //=======================================================
        return $destination;
    }


}
