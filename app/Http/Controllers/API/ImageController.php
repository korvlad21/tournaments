<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Images\AvatarRequest;
use App\Http\Requests\Images\LogoRequest;
use App\Http\Requests\Images\PassportRequest;
use App\Http\Resources\UserResource;
use App\Mail\PassportMail;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarUpload(AvatarRequest $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        $oldAvatar = $user->avatar;
        $avatar = $request->file('avatar');
        $filename = md5(Carbon::now().'_'.$avatar->getClientOriginalName()). '.' . $avatar->getClientOriginalExtension();
        $image = Image::make($avatar);
        Storage::put('public/images/user/avatar/thumbnail/'.$filename, $image->fit(100, 100)->encode());
        Storage::put('public/images/user/avatar/medium/'.$filename, $image->fit(500, 500)->encode());
        Storage::put('public/images/user/avatar/large/'.$filename, $image->fit(1000, 1000)->encode());
        $user->avatar = $filename;
        $user->save();
        if ($oldAvatar) {
            Storage::delete('public/images/user/avatar/thumbnail/'.$oldAvatar);
            Storage::delete('public/images/user/avatar/medium/'.$oldAvatar);
            Storage::delete('public/images/user/avatar/large/'.$oldAvatar);
        }
        $path = '/storage/images/user/avatar/thumbnail/'.$filename;
        return response()->json([
            'path' => $path
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passportUpload(PassportRequest $request)
    {
        $image = $request->file('image');
        $filename = 'passport.' . $image->getClientOriginalExtension();
        $passport = $request->post('passport');
        $user = Auth::user();
        Mail::to('vladek2000@inbox.ru')->send(new PassportMail($image, $filename, $passport, $user->username, $user->slug));
        return response()->json([
            'success' => true
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvatar(Request $request)
    {
        $slug = $request->post('slug');
        $user = User::where('slug', $slug)->first();
        $path = ($user->avatar) ? '/storage/images/thumbnail/'.$user->avatar : '';
        return response()->json([
            'path' => $path
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoTeamUpload(LogoRequest $request)
    {
        $team = Team::find($request->post('id'));
        $oldLogo = $team->logo;
        $logo = $request->file('logo');
        $filename = md5(Carbon::now().'_'.$logo->getClientOriginalName()). '.' . $logo->getClientOriginalExtension();
        $image = Image::make($logo);
        Storage::put('public/images/team/logo/thumbnail/'.$filename, $image->fit(100, 100)->encode());
        Storage::put('public/images/team/logo/medium/'.$filename, $image->fit(500, 500)->encode());
        Storage::put('public/images/team/logo/large/'.$filename, $image->fit(1000, 1000)->encode());
        $team->logo = $filename;
        $team->save();
        if ($oldLogo) {
            Storage::delete('public/images/team/logo/thumbnail/'.$oldLogo);
            Storage::delete('public/images//team/logo/medium/'.$oldLogo);
            Storage::delete('public/images/team/logo/large/'.$oldLogo);
        }
        $path = '/storage/images/team/logo/thumbnail/'.$filename;
        return response()->json([
            'path' => $path
        ]);
    }
}
