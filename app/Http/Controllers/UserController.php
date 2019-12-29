<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Validator;
use Storage;
use Session;
use Image;
use File;
use DB;

class UserController extends Controller
{
    public function index() {
        return view('backend.user.index');
    }

    public function personalData($id) {
        $bio = \App\User::with('bio')->find($id);

        // dd($bio);
        // echo $bio->bio->nama;
        return view('backend.user.personal', ['user' => $bio]);
    }

    public function fishData($id) {
        $ufish = \App\Models\Tbl_user_fish::with([
            'user' => function($query) use ($id) {
                $query->where('id', '=', $id);
                },
            'bio' => function($query) use ($id) {
                $query->where('user_id', '=', $id);
                },
            'fish', 'cat'    
        ])->where('user_id', $id)->get();

        // $ufish = \App\User::where('id', $id)->with('user_fish')->get();
        // $ufish = \App\Models\Tbl_user_fish::with('fish')->get();    
        // dd($ufish);
        // echo count($ufish);
        return view('backend.user.fish', ['user_id' => $id, 'data_fish' => $ufish]);
    }

    public function userRegisterFish($id) {
        $user_id = $id;
        $user = \App\User::with('bio')->find($user_id);

        $varietas = \App\Models\Tbl_fish::all();

        $cat = \App\Models\Tbl_cat::all();

        // dd($user);
        return view('backend.user.create_fish', [
            'user' => $user,
            'data_varietas' => $varietas,
            'data_cat' => $cat,
        ]);
    }

    public function userStoreFish(Request $r) {

        if($r->hasFile('fish_pict')) {
            $filename_ext = $r->file('fish_pict')->getClientOriginalName();
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            $extension = $r->file('fish_pict')->getClientOriginalExtension();
            $filenametostore = $filename.'_'.Carbon::now()->format('Y_m_d_His').'.'.$extension;
            $r->file('fish_pict')->storeAs('public/fish', $filenametostore);
            $r->file('fish_pict')->storeAs('public/fish/thumbnail', $filenametostore);
            $thumbnailpath = public_path('storage/fish/thumbnail/'.$filenametostore);
            $img = Image::make($thumbnailpath)->fit(100, 100, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $img_path = '/storage/fish/'.$filenametostore;
        } else {
            $img_path = '/storage/fish/default_fish.jpg';
        }

        DB::beginTransaction();

        $user_fish = [
            'user_id'            => $r->user_id,
            'handler_name'       => $r->handler_name,
            'handler_address'    => $r->handler_address,
            'bio_id'             => $r->bio_id,
            'fish_id'            => $r->varietas,
            'cat_id'             => $r->type_ukuran,
            'fish_size'          => $r->fish_size,
            'fish_picture'       => $img_path,
            'status'             => 'BELUM LUNAS',
            'date_reg'           => Carbon::now()->format('Y-m-d'),
            'time_reg'           => Carbon::now()->format('H:i:s')
        ];

        $fish = \App\Models\Tbl_user_fish::create($user_fish);

        if(!$fish) {
            Session::flash('notif', ['type' => 'error', 'msg' => 'Gagal Daftar, Ulangi Lagi']);
            DB::rollBack();
        }
        else {
            DB::commit();
            Session::flash('notif', ['type' => 'success', 'msg' => 'Ikan Berhasil Di daftarkan']);
    
            return redirect()->route('user.fish', ['id'=> auth()->user()->id]);
        }
        

    }

    public function showDetailFish($id) {
        // $fish = \App\Models\Tbl_user_fish::find($id);
        $ufish = \App\Models\Tbl_user_fish::with([
            'user',
            'bio',
            'fish',
            'cat'
        ])->find($id);

        $cat = \App\Models\Tbl_cat::all();
        $var = \App\Models\Tbl_fish::all();

        return view('backend.user.show_fish', ['fish' => $ufish, 'data_cat' => $cat, 'data_var' => $var]);
    }

    public function updateFish(Request $req) {
        $ufish_id = $req->fish_id;

        $ufish = \App\Models\Tbl_user_fish::find($ufish_id);

        $ufish->handler_name = $req->handler_name;
        $ufish->handler_address = $req->handler_address;
        $ufish->fish_id = $req->varietas;
        $ufish->cat_id = $req->type_ukuran;
        $ufish->fish_size = $req->fish_size;

        $update = $ufish->save();

        if(!$update) {
            Session::flash('notif', ['type' => 'error', 'msg' => 'Update Data Gagal, Ulangi Lagi']);
        } else {
            Session::flash('notif', ['type' => 'success', 'msg' => 'Data Ikan Berhasil Di Update']);
        }

        return redirect()->back();

    }

    public function updateFishPicture(Request $req) {
        if($req->hasFile('fish_pict')) {
            $filename_ext = $req->file('fish_pict')->getClientOriginalName();
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            $extension = $req->file('fish_pict')->getClientOriginalExtension();
            $filenametostore = $filename.'_'.Carbon::now()->format('Y_m_d_His').'.'.$extension;
            $req->file('fish_pict')->storeAs('public/fish', $filenametostore);
            $req->file('fish_pict')->storeAs('public/fish/thumbnail', $filenametostore);
            $oripath = public_path('storage/fish/'.$filenametostore);
            $thumbnailpath = public_path('storage/fish/thumbnail/'.$filenametostore);
            $img = Image::make($oripath)->resize(500, null, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($oripath);
            $img = Image::make($thumbnailpath)->fit(100, 100, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $img_path = '/storage/fish/'.$filenametostore;
        } else {
            $img_path = '/storage/fish/default_fish.jpg';
        }

        $ufish_id = $req->fish_id;
        $ufish = \App\Models\Tbl_user_fish::find($ufish_id);
        $oldimg = preg_replace("#/storage/fish/#", "", $ufish->fish_picture);
        // echo $oldimg;
        //delete old fish
        // echo base_path('/'.$oldimg);
        Storage::delete(base_path($oldimg));
        Storage::delete(base_path('/thumbnail'.$oldimg));
        $ufish->fish_picture = $img_path;
        $update = $ufish->save();


        if(!$update) {
            Session::flash('notif', ['type' => 'error', 'msg' => 'Update Gambar Gagal, Ulangi Lagi']);
        } else {
            Session::flash('notif', ['type' => 'success', 'msg' => 'Gambar Ikan Berhasil Di Update']);
        }

        return redirect()->back();

    }
}
