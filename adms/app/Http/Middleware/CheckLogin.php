<?php

namespace App\Http\Middleware;

use Closure;
use Route,Log,Request ,URL;
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->session()->get('admuser.id', false)) {
            return redirect('login');
        }
        $this->permisionCheck($request);
        $is_super =  $request->session()->get('admuser.is_super', 0);
        $allow_route =  $request->session()->get('admuser.allow', '');
        $route_name = $request->path();
        $route_name = preg_replace('/\/+\d+/' ,'', $route_name) . ',';
        Log::info('info',array('context'=> $allow_route ."|" .$route_name ."|" . var_export(strpos($allow_route , $route_name),true)));
        if(strpos($allow_route , $route_name) === false && !$is_super) {

            if($request->ajax() ) { //&& ($request->getMethod() != 'GET')) {
                Log::info('info',array('context'=> '您没有权限执行此操作'));
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {
                $previousUrl = URL::previous();
//                Log::info('info',array('context'=> '您没有权限执行此操作222'.$previousUrl));
//                return view('errors.403', compact('previousUrl'));
                return redirect('403');
            }
        }

        return $next($request);
    }

    /*
     *  judge Role permision
     */
    public function permisionCheck($request)
    {

    }
}
