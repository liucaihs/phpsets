<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 2017/6/21
 * Time: 17:00
 */
namespace App\Http\Controllers;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InformationController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $req)
    {
        $site = session('admuser.account');
        $ret = DB::select('select * FROM tb_advertiser WHERE account = ?', [$site]);
        return view('information.index', ['row' => $ret[0]]);
    }
}