@if(captcha()->enabled)
    <input type="hidden" name="r_key" value="{{captcha()->key}}">
    <input type="hidden" name="r_token">
@endif
