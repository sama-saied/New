<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Setting;
use App\Traits\UploadAble;

use Illuminate\Http\UploadedFile;

class SettingController extends BaseController
{
    use UploadAble;

    /**
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
public function index()
{
    $this->setPageTitle('Settings', 'Manage Settings');

       if(auth()->admin()->role == 'super Admin')
        {
        return view('admin.settings.index'); 
        }
        else
        {
        return view('admin.settings.index2');
        }
}


 
public function update(Request $request)
{
    if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {

        if (config('settings.site_logo') != null) {
            $this->deleteOne(config('settings.site_logo'));
        }

        $logo = $this->UploadOne($request->file('site_logo'), 'img');
        Setting::set('site_logo', $logo);
    }

    
    elseif ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {

        if (config('settings.site_favicon') != null) {
            $this->deleteOne(config('settings.site_favicon'));
        }
        $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
        Setting::set('site_favicon', $favicon);

    } 


    elseif ($request->has('hero_first') && ($request->file('hero_first') instanceof UploadedFile)) {

        if (config('settings.hero_first') != null) {
            $this->deleteOne(config('settings.hero_first'));
        }
        $herofirst = $this->uploadOne($request->file('hero_first'), 'img');
        Setting::set('hero_first', $herofirst);

    } 

    elseif ($request->has('hero_second') && ($request->file('hero_second') instanceof UploadedFile)) {

        if (config('settings.hero_second') != null) {
            $this->deleteOne(config('settings.hero_second'));
        }
        $herosecond = $this->uploadOne($request->file('hero_second'), 'img');
        Setting::set('hero_second', $herosecond);

    }  

    elseif ($request->has('ad_pic') && ($request->file('ad_pic') instanceof UploadedFile)) {

        if (config('settings.ad_pic') != null) {
            $this->deleteOne(config('settings.ad_pic'));
        }
        $herosecond = $this->uploadOne($request->file('ad_pic'), 'img');
        Setting::set('ad_pic', $herosecond);

    } 

    else 
    {

        $keys = $request->except('_token');

        foreach ($keys as $key => $value)
        {
            Setting::set($key, $value);
        }
    }

    return $this->responseRedirectBack('Settings updated successfully.', 'success');

}

}