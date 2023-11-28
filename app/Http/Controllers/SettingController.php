<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        $setting = Setting::first();

        return apiResourceResponse(SettingResource::make($setting), 'Settings');
    }
}
