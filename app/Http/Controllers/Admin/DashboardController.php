<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AccommodationPicModel;
use Intervention\Image\ImageManagerStatic as Image;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function resize()
    {
        // foreach ($list as $itm) {
        //     try {
        //         $img = Image::make($itm->pic_path);
        //         $img->resize($img->width() / 4, $img->height() / 4);
        //         $new_name = $itm->pic_path;
        //         $new_name = substr($new_name, strlen("http://jabit1.3paresh.com/images/accommodation-pic/"), 49);
        //         $new_path = public_path('images/accommodation-pic-thumb') . '/' . $new_name;
        //         $img->save($new_path);
        //     } catch (\Exception $e) {

        //     }
        // }
        // dd('end');
    }
}
